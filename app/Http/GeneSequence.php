<?php

namespace App\Http;

use App\Http\Gene;

use LengthException;

class GeneSequence {
    public $genes = array();
 
    function randomise() {
        $tmp = array();
        for ($i = 0; $i < 6; $i++) {
            $tmp[] = Gene::makeRandom();
        }
        $this->genes = $tmp;
    }

    function getGeneSequence() {
        $tmp = '';
        foreach ($this->genes as $gene) {
            $tmp .= $gene->code;
        }
        return $tmp;
    }

    function score() {
        $score = 0;
        $values = array('Y' => 1, 'G' => 1, 'H' => 0, 'X' => -1, 'W' => -1);
        foreach ($this->genes as $gene) {
            $score += $values[$gene->code];
        }
        return $score;
    }
}