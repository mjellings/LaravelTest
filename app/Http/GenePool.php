<?php
namespace App\Http;

use App\Http\GeneSequence;
use App\Http\Gene;

use LengthException;

class GenePool {
    public $num_genes = 50;
    public $genes = array();
    public $history = array();
    public $best_found = false;

    /*
    function __construct($num_genes = 50) {
        $this->$num_genes = $num_genes;

        for ($i = 0; $i < $num_genes; $i++) {
            $gene = new GeneSequence();
            $gene->randomise();
            $this->genes[] = $gene;
        }
        
        $this->sort_pool();
    }
    */

    public static function makeSpecific($genes = array()) {
        $pool = new GenePool();
        
        if (count($genes)) {
            foreach ($genes as $gene_string) {
                $gene_sequence = new GeneSequence();
                $gene_sequence->fromString($gene_string);
                $pool->genes[] = $gene_sequence;
            }

            $pool->sort_pool();
        }

        return $pool;
    }

    public static function makeRandom($num_genes = 50) {
        $pool = new GenePool();
        $pool->num_genes = $num_genes;

        for ($i = 0; $i < $num_genes; $i++) {
            $gene = new GeneSequence();
            $gene->randomise();
            $pool->genes[] = $gene;
        }
        
        $pool->sort_pool();

        return $pool;
    }

    function sort_pool() {
        usort($this->genes, function ($a, $b) {
            return $b->score > $a->score;
        });
    }

    function find_donors($count = 4) {
        $donors = array();
        $iterations = count($this->genes);
        $i = 0;
        while ($i < $iterations) {
            
            for ($j = 1; $j < count($this->genes); $j++) {
                $existing = false;
                $temp_crop = $this->genes[$j];
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
        $starter = $this->genes[mt_rand(0, 5)];
        //$starter = $this->crops[0];
        $donors = $this->find_donors(4);
        $new_crop = $starter->CrossBreed($donors);
        $this->genes[] = $new_crop;
        $this->sort_pool();
        $data = array();
        $data['starter'] = $starter;
        $data['donors'] = $donors;
        $data['new_crop'] = $new_crop;
        $this->history[] = $data;

        if ($new_crop->getGeneSequenceSorted() == 'GGGGYY') {
            $this->best_found = true;
        }
    }

    function breedSpecific($parent = null, $donors = array()) {
        $starter = $parent;
        //$starter = $this->crops[0];
        $donors = $donors;
        $new_crop = $starter->CrossBreed($donors);
        $this->genes[] = $new_crop;
        $this->sort_pool();
        $data = array();
        $data['starter'] = $starter;
        $data['donors'] = $donors;
        $data['new_crop'] = $new_crop;
        $this->history[] = $data;

        if ($new_crop->getGeneSequenceSorted() == 'GGGGYY') {
            $this->best_found = true;
        }
    }

    function breedAll() {
        $this->sort_pool();
        $combinations = $this->getCombinationsFromPool();
        $i = 0;
        $total = count($combinations) - 1;
        while (!$this->best_found && $i < $total) {
            $this->breedSpecific($combinations[$i]['parent'], $combinations[$i]['donors']);
            $i++;
        }
        if ($this->best_found) { 
            dd($this->history[count($this->history)-1]); 
        }
    }

    function getCombinationsFromPool() {
        $combinations=[];

        $gene_count = count($this->genes);

        for ($a = 0; $a < $gene_count; $a++) {
            for ($b = 0; $b < $gene_count; $b++) {
                for ($c = 0; $c < $gene_count; $c++) {
                    for ($d = 0; $d < $gene_count; $d++) {
                        for ($e = 0; $e < $gene_count; $e++) {
                            //$combinations[] = $this->genes[$a] . '|' . $this->genes[$b] . '|' . $this->genes[$c] . '|' . $this->genes[$d];
                            $combinations[] = array('parent' => $this->genes[$a], 'donors' => array($this->genes[$b], $this->genes[$c], $this->genes[$d], $this->genes[$e]));
                        }
                    }
                }    
            }
        }    
        return $combinations;
    }
}