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

    function CrossBreed($crops = array()) {
        if (count($crops)) {
            $new_sequence = new GeneSequence();

            #echo "Crossbreeding " . $this->getGeneSequence() . "<br />\n";
            #echo "With ";
            foreach ($crops as $crop) {
                #echo $crop->getGeneSequence() . " ";
            }
            #echo "<br />\n";
            $slots = array();
            for ($i = 0; $i < 6; $i++) { $slots[$i] = array('H' => 0, 'Y' => 0, 'G' => 0, 'X' => 0, 'W' => 0); }
            //dd($this->genes);
            for ($i = 0; $i < 6; $i++) {
                $gene = $this->genes[$i];
                $slots[$i][$gene->code]++;
            }
            
            foreach ($crops as $crop) {
                for ($i = 0; $i < 6; $i++) {
                    $gene = $crop->genes[$i];
                    $slots[$i][$gene->code]++;
                    arsort($slots[$i], SORT_NUMERIC);
                }
            }
            
            for ($i = 0; $i < 6; $i++) {
                $slot = $slots[$i];
                $prev_count = 0;
                $chosen = '';
                foreach ($slot as $gene => $count) {
                    if ($count > $prev_count) { $chosen .= $gene; $prev_count = $count; }
                }
                $new_sequence->genes[$i] = Gene::makeSpecific($chosen[mt_rand(0, strlen($chosen)-1)]);
            }
            $new_sequence->calcScore();
            return $new_sequence;
        }
        else {
            return [];
        }
    }
}