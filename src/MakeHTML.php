<?php

namespace TaylorNetwork\MakeHTML;

use Nahid\Linkify\Linkify;

trait MakeHTML
{
    /**
     * Associative array of options to use with Nahid\Linkify
     * see https://github.com/nahid/linkify
     *
     * @var array
     */
    protected $linkifyAttributes = [
        'target' => '_blank',
    ];

    /**
     * Stores the HTMLified text
     *
     * @var string
     */
    protected $HTMLText;

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
        $this->setHTMLText($text);
        $this->HTMLText = $this->makeLinks($this->HTMLText);
        $this->HTMLText = $this->convertLineEndings($this->HTMLText);
        
        return $this->HTMLText;
    }
}