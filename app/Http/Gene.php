<?php

namespace App\Http;

class Gene {
    public $code = '';

    function __construct() {

    }

    public static function makeRandom() {
        $obj = new Gene(); 
        // other initialization
        $options = array('Y', 'G', 'H', 'X', 'W');
        $obj->code = $options[rand(0, count($options)-1)];
        return $obj;
    }

    public static function makeSpecific($code) {
        $obj = new Gene(); 
        // other initialization
        $obj->code = $code;
        return $obj;
    }
}