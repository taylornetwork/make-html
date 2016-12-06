<?php

namespace TaylorNetwork\MakeHTML;

class HTMLGenerator
{
    /**
     * Associative array of attributes to add to all links
     *
     * @var array
     */
    protected $linkAttributes;

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
        $this->linkAttributes = config('makehtml.linkAttributes', []);
        $this->voidTags = config('makehtml.voidTags', []);
        $this->externalKey = config('makehtml.externalKey', 'external');
        $this->openTagPattern = config('makehtml.openTagPattern', '<{tag} {attr}>');
        $this->closeTagPattern = config('makehtml.closeTagPattern', '</{tag}>');
        $this->voidTagPattern = config('makehtml.voidTagPattern', null);
    }

    /**
     * Make the links clickable.
     *
     * @param $text
     * @return string
     */
    public function makeLinks($text)
    {
        $pattern = '~(?xi)
              (?:
                ((ht|f)tps?://)                    # scheme://
                |                                  #   or
                www\d{0,3}\.                       # "www.", "www1.", "www2." ... "www999."
                |                                  #   or
                www\-                              # "www-"
                |                                  #   or
                [a-z0-9.\-]+\.[a-z]{2,4}(?=/)      # looks like domain name followed by a slash
              )
              (?:                                  # Zero or more:
                [^\s()<>]+                         # Run of non-space, non-()<>
                |                                  #   or
                \(([^\s()<>]+|(\([^\s()<>]+\)))*\) # balanced parens, up to 2 levels
              )*
              (?:                                  # End with:
                \(([^\s()<>]+|(\([^\s()<>]+\)))*\) # balanced parens, up to 2 levels
                |                                  #   or
                [^\s`!\-()\[\]{};:\'".,<>?«»“”‘’]  # not a space or one of these punct chars
              )
        ~';

        $callback = function ($urlMatch)
        {
            $url = $urlMatch[0];

            // Look for protocol
            preg_match('~^(ht|f)tps?://~', $url, $protocolMatch);

            if($protocolMatch)
            {
                $protocol = $protocolMatch[0];
            }
            else
            {
                $protocol = 'http://';
                $url = $protocol . $url;
            }

            // Start building caption, remove protocol from url
            $noProtocol = substr($url, strlen($protocol));

            // Check for a variation of www
            preg_match('/www\d{0,3}\./', $noProtocol, $wwwMatch);

            if($wwwMatch)
            {
                // Remove www
                $noProtocol = substr($noProtocol, strlen($wwwMatch[0]));
            }

            // Only use domain name as caption
            $caption = explode('/', $noProtocol)[0];

            return $this->generateTag('a', $this->linkAttributes + [ 'href' => $url, $this->externalKey => $caption ]);
        };

        return preg_replace_callback($pattern, $callback, $text);
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
     * @param $closeTag
     * @return string
     */
    public function generateTag($tag, $attributes, $closeTag = true)
    {
        $openPattern = replace_variables($this->openTagPattern, compact('tag'));
        $external = '';

        if(in_array($tag, $this->voidTags) && !empty($this->voidTagPattern) && $this->voidTagPattern != $this->openTagPattern)
        {
            $openPattern = replace_variables($this->voidTagPattern, compact('tag'));
        }

        if(array_key_exists($this->externalKey, $attributes))
        {
            $external = $attributes[$this->externalKey];
            unset($attributes[$this->externalKey]);
        }

        $html = replace_variables($openPattern, [ 'attr' => associative_implode('=', ' ', $attributes) ]);

        if(!in_array($tag, $this->voidTags))
        {
            $html .= $external;

            if ($closeTag)
            {
                $html .= replace_variables($this->closeTagPattern, compact('tag'));
            }
        }

        return $html;
    }

    /**
     * Close an HTML tag
     *
     * @param $tag
     * @return string
     */
    public function closeTag($tag)
    {
        if(!in_array($tag, $this->voidTags))
        {
            return replace_variables($this->closeTagPattern, compact('tag'));
        }
        return '';
    }

    /**
     * Get the external key
     *
     * @return string
     */
    public function getExternalKey()
    {
        return $this->externalKey;
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
            return $this->generateTag($tag, $arguments[0]);
        }
        return false;
    }
}