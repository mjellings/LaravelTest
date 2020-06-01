<?php

namespace App\Http;

use App\Http\Gene;

use LengthException;

class GeneSequence {
    public $genes = array();
    public $score = 0;
    public $is_new = false;

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

    function getGeneSequenceSorted() {
        $parts = str_split($this->getGeneSequence());
        sort($parts);
        return implode('', $parts);
    }

    function calcScore() {
        $perfect_score = 14;
        $score = 0;
        foreach ($this->genes as $gene) {
            $score = $score + $gene->score;
        }
        //$score = 14 - $score;
        //if ($score < 0) { $score = $score * -1; }



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

            // echo $this->getGeneSequence() . "<br />\n";
            for ($i = 0; $i < 6; $i++) {
                $gene = $this->genes[$i];
                $code = trim($gene->code);
                $slots[$i][$code]++;
                
                /*
                for ($j = 0; $j < 6; $j++) {
                    $slot = $slots[$j];
                    foreach ($slot as $code => $count) {
                        echo "$code:$count ";
                    }
                    echo "<br />\n";
                }
                */
                
            }
            
            foreach ($crops as $crop) {
                // echo $crop->getGeneSequence() . "<br />\n";
                for ($i = 0; $i < 6; $i++) {
                    $gene = $crop->genes[$i];
                    $code = trim($gene->code);
                    $before = $slots[$i][$code];
                    $slots[$i][$code]++;
                    //echo "Slot: " . $i . " Code: " . $code . " Before: " . $before . " After: " . $slots[$i][$code] . "<br />\n"; 
                    arsort($slots[$i], SORT_NUMERIC);

                    /*
                    for ($j = 0; $j < 6; $j++) {
                        $slot = $slots[$j];
                        foreach ($slot as $code => $count) {
                            echo "$j $code:$count ";
                        }
                        echo "<br />\n";
                    }
                    */
                    
                }
            }
            
            for ($i = 0; $i < 6; $i++) {
                $slot = $slots[$i];
                $slots[$i] = array();
                $prev_count = 0;
                $chosen = '';
                foreach ($slot as $gene => $count) {
                    $slots[$i]['genes'][$gene] = $count;
                    if ($count >= $prev_count) { $chosen .= $gene; $prev_count = $count; }
                }
                $slots[$i]['chosen'] = $chosen;
                $new_sequence->genes[$i] = Gene::makeSpecific($chosen[mt_rand(0, strlen($chosen)-1)]);
            }
            $new_sequence->cross_breed_slots = $slots;
            $new_sequence->calcScore();
            $new_sequence->is_new = true;
            return $new_sequence;
        }
        else {
            return [];
        }
    }
}