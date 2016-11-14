<?php

if(!function_exists('associative_implode'))
{
    /**
     * Implode an associative array.
     * 
     * Character between key and value.
     * @param string $glue
     * 
     * Character between each array segment
     * @param string $separator
     * 
     * Array to implode
     * @param array $array
     * 
     * Place a quote around keys
     * @param bool $quoteKeys
     * 
     * Place a quote around values
     * @param bool $quoteValues
     * 
     * Character to use to quote
     * @param string $quote
     * 
     * @return string
     */
    function associative_implode($glue, $separator, array $array, $quoteKeys = false, $quoteValues = true, $quote = '"')
    {
        $keyQuote = '';
        $valQuote = '';
        
        if($quoteKeys)
        {   
            $keyQuote = $quote;
        }
        
        if($quoteValues)
        {
            $valQuote = $quote;
        }
        
        return implode($separator, 
            array_map(
                function ($value, $key) use ($glue, $keyQuote, $valQuote)
                {
                    return $keyQuote . $key . $keyQuote . $glue . $valQuote . $value . $valQuote;
                },
                array_values($array),
                array_keys($array)
            )    
        );
    }
}

