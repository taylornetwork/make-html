<?php

namespace TaylorNetwork\MakeHTML;


trait MakeHTML
{
    /**
     * HTMLGenerator Instance
     * 
     * @var HTMLGenerator
     */
    public $HTMLGenerator;

    /**
     * Call HTMLGenerator->makeHTML
     * 
     * @param string $text
     * @return string
     */
    public function makeHTML($text)
    {
        return $this->getHTMLGeneratorInstance()->makeHTML($text);
    }

    public function makeLinks($text)
    {
        return $this->getHTMLGeneratorInstance()->makeLinks($text);
    }

    public function HTMLConfig(&$generator)
    {
        // $generator->defaultActions['makeLinks'] = false;
    }

    /**
     * Get the generator instance, or create one.
     * 
     * @return HTMLGenerator
     */
    public function getHTMLGeneratorInstance()
    {
        if(!isset($this->HTMLGenerator) || !$this->HTMLGenerator instanceof HTMLGenerator)
        {
            $this->HTMLGenerator = new HTMLGenerator();
            $this->HTMLConfig($this->HTMLGenerator);
        }
        
        return $this->HTMLGenerator;
    }
}