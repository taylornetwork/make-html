<?php

namespace TaylorNetwork\MakeHTML;

use Nahid\Linkify\Linkify;

class HTMLGenerator
{
    /**
     * Associative array of options to use with Nahid\Linkify
     * see https://github.com/nahid/linkify
     *
     * @var array
     */
    protected $linkifyAttributes;
    
    /**
     * HTML void/singleton tags
     * 
     * @var array
     */
    protected $voidTags;

    /**
     * External Key Word
     * 
     * @var string
     */
    protected $externalKey;

    /**
     * Open Tag Pattern
     * 
     * @var string
     */
    protected $openTagPattern;

    /**
     * Closing Tag Pattern
     * 
     * @var string
     */
    protected $closeTagPattern;

    /**
     * Void Tag Pattern
     * 
     * @var string
     */
    protected $voidTagPattern;

    /**
     * MakeHTML constructor.
     */
    public function __construct()
    {
        $this->linkifyAttributes = config('makehtml.linkifyAttributes', []);
        $this->voidTags = config('makehtml.voidTags', []);
        $this->externalKey = config('makehtml.externalKey', 'external');
        $this->openTagPattern = config('makehtml.openTagPattern', '<{tag}>');
        $this->closeTagPattern = config('makehtml.closeTagPattern', '</{tag}>');
        $this->voidTagPattern = config('makehtml.voidTagPattern', null);
    }

    /**
     * Set the HTMLText variable
     *
     * @param $text
     * @return $this
     */
    public function setHTMLText($text)
    {
        $this->HTMLText = $text;
        return $this;
    }

    /**
     * Make the links clickable.
     *
     * @param $text
     * @param array $options
     * @return string
     */
    public function makeLinks($text, $options = [])
    {
        $linkify = new Linkify([ 'attr' => $this->linkifyAttributes, 'callback' => function($url, $defCaption, $isEmail){
            if(!$isEmail)
            {
                $caption = substr($url, 7);
                preg_match('/www\d{0,3}\./', $caption, $match);

                if($match)
                {
                    $caption = substr($caption, strlen($match[0]) + strpos($caption, $match[0]));
                }

                $split = explode('/', $caption);

                $caption = $split[0];

                return '<a href="' . $url . '" target="_blank">' . $caption . '</a>';
            }
            return $url;
        }]);

        return $linkify->process($text, $options);
    }

    /**
     * Convert line endings to <br> for HTML
     *
     * @param $text
     * @return string
     */
    public function convertLineEndings($text)
    {
        return nl2br($text);
    }
    
    /**
     * The main function to use instead of calling everything individually.
     *
     * @param $text
     * @return string
     */
    public function makeHTML($text)
    {
        $html = $this->makeLinks($text);
        return $this->convertLineEndings($html);
    }

    /**
     * Generate an HTML tag
     * 
     * @param $tag
     * @param $attributes
     * @return string
     */
    public function generateTag($tag, $attributes)
    {
        $openPattern = str_replace('{tag}', $tag, $this->openTagPattern);
        $external = '';
        
        if(in_array($tag, $this->voidTags) && !empty($this->voidTagPattern) && $this->voidTagPattern != $this->openTagPattern)
        {
            $openPattern = str_replace('{tag}', $tag, $this->voidTagPattern);
        }
        
        if(array_key_exists($this->externalKey, $attributes))
        {
            $external = $attributes[$this->externalKey];
            unset($attributes[$this->externalKey]);
        }

        $strAttributes = implode(' ',
            array_map(
                function ($value, $key) {
                    return $key . '="' . $value . '"';
                },
                array_values($attributes),
                array_keys($attributes)
            )
        );
        
        $html = str_replace('{attr}', $strAttributes, $openPattern);
        
        if(!in_array($tag, $this->voidTags))
        {
            $html .= $external . str_replace('{tag}', $tag, $this->closeTagPattern);
        }
        
        return $html;
    }

    /**
     * Call for generate tag
     *
     * @param string $name
     * @param array|string $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if(strtolower(substr($name, -3)) == 'tag')
        {
            $tag = strtolower(substr($name, 0, strlen($name) - 3));
            return $this->generateTag($tag, $arguments);
        }
        return false;
    }
}