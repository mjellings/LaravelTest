<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\GeneSequence;

class RustController extends Controller
{
    //

    function index() {
        return view('rust.index');
    }

    function genetics(Request $request) {
        $num_crops = 20;
        $crops = array();
        for ($i = 0; $i < $num_crops; $i++) {
            $crop = new GeneSequence();
            $crop->randomise();
            $crops[] = $crop;
        }
        
        usort($crops, function ($a, $b) {
            return $b->score > $a->score;
        });

        $i = 0;
        foreach ($crops as $crop) {
            echo $i . ": " . $crop->getGeneSequence() . " Score: " . $crop->score . "<br />\n";
            $i++;
        }

        dd($crops);
    }

    function genetics_post(Request $request) {
        $crop = new GeneSequence();
        $crop->randomise();
        dd($crop);
    }
}
