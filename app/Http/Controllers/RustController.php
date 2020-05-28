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
        $num_crops = 60;
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
            //echo $i . ": " . $crop->getGeneSequence() . " Score: " . $crop->score . "<br />\n";
            $i++;
        }

        $data = array();
        $data['crops'] = $crops;

        $starter = $crops[0];
        $new_crop = $starter->CrossBreed(array($crops[1], $crops[2]), $crops[3], $crops[4]);

        $data['starter'] = $starter;
        $data['children'][0] = $crops[1];
        $data['children'][1] = $crops[2];
        $data['children'][2] = $crops[3];
        $data['children'][3] = $crops[4];
        $data['new_crop'] = $new_crop;
        
        return view('rust.genetics', $data);
    }

    function genetics_post(Request $request) {
        $crop = new GeneSequence();
        $crop->randomise();
        dd($crop);
    }
}
