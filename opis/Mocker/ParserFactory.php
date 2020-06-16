<?php

namespace Opis\Mocker; 

use Opis\Mocker\Parser;
use Opis\Mocker\PhpParser;

/**
 * Factory method pattern that generates a parser
 * based on configuration infos. 
 * 
 */
class ParserFactory
{    
    /**
     * get parser based on configurations 
     *
     * @return Parser
     */
    public static function get(): Parser 
    {
        switch (config('mocker.parser_type')) {
            
            default:
                return new PhpParser(\storage_path(config('mocker.file_path'))); 
                break;
        }
    }
}