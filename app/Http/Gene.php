<?php

namespace App\Http;

class Gene {
    public $code = '';
    public $score = 0;
    public $cross_breed_slots = array();

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
        $values = array('G' => 3, 'Y' => 2, 'H' => -2, 'X' => -3, 'W' => -5);
        $this->score = $values[$this->code];
    }
}