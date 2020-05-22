<?php

namespace App\Http;

class Gene {
    public $code = '';
    public $score = 0;

    function __construct() {

    }

    public static function makeRandom() {
        $gene = new Gene(); 
        // other initialization
        $options = array('Y', 'G', 'H', 'X', 'W');
        $gene->setCode($options[mt_rand(0, count($options)-1)]);
        return $gene;
    }

    public static function makeSpecific($code) {
        $gene = new Gene(); 
        // other initialization
        $gene->setCode($code);
        return $gene;
    }

    function setCode($code) {
        $this->code = $code;
        $this->calcScore();
    }

    function calcScore() {
        $values = array('Y' => 1, 'G' => 1, 'H' => 0, 'X' => -1, 'W' => -1);
        $this->score = $values[$this->code];
    }
}