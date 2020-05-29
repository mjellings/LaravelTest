<?php
namespace App\Http;

use App\Http\GeneSequence;
use App\Http\Gene;

use LengthException;

class GenePool {
    public $num_crops = 50;
    public $crops = array();
    public $history = array();
    function __construct($num_crops = 50) {
        $this->$num_crops = $num_crops;

        for ($i = 0; $i < $num_crops; $i++) {
            $crop = new GeneSequence();
            $crop->randomise();
            $this->crops[] = $crop;
        }
        
        $this->sort_pool();
    }

    function sort_pool() {
        usort($this->crops, function ($a, $b) {
            return $b->score < $a->score;
        });
    }

    function find_donors($count = 4) {
        $donors = array();
        $iterations = count($this->crops);
        $i = 0;
        while ($i < $iterations) {
            
            for ($j = 1; $j < count($this->crops); $j++) {
                $existing = false;
                $temp_crop = $this->crops[$j];
                foreach ($donors as $donor) {
                    if ($donor->getGeneSequence() == $temp_crop->getGeneSequence()) {
                        $existing = true;
                    }
                }
                if (!$existing && count($donors) < $count && mt_rand(0,100) > 80) { $donors[] = $temp_crop; }
            }
            $i++;
        }

        return $donors;
    }

    function breed() {
        $starter = $this->crops[mt_rand(0, 5)];
        //$starter = $this->crops[0];
        $donors = $this->find_donors(4);
        $new_crop = $starter->CrossBreed($donors);
        $this->crops[] = $new_crop;
        $this->sort_pool();
        $data = array();
        $data['starter'] = $starter;
        $data['donors'] = $donors;
        $data['new_crop'] = $new_crop;
        $this->history[] = $data;
    }
}