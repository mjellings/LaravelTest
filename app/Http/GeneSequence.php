<?php

namespace App\Http;

use App\Http\Gene;

use LengthException;

class GeneSequence {
    public $genes = array();
    public $score = 0;

    function randomise() {
        $tmp = array();
        for ($i = 0; $i < 6; $i++) {
            $tmp[] = Gene::makeRandom();
        }
        $this->genes = $tmp;
        $this->calcScore();
    }

    function getGeneSequence() {
        $tmp = '';
        foreach ($this->genes as $gene) {
            $tmp .= $gene->code;
        }
        return $tmp;
    }

    function calcScore() {
        $score = 0;
        foreach ($this->genes as $gene) {
            $score = $score + $gene->score;
        }
        $this->score = $score;
    }
}