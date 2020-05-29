<?php

namespace App\Http\Controllers;

use App\Http\GenePool;
use Illuminate\Http\Request;
use App\Http\GeneSequence;

class RustController extends Controller
{
    //

    function index() {
        return view('rust.index');
    }

    function genetics(Request $request) {
        $num_crops = 50;
        $pool = new GenePool($num_crops);
        for ($i = 0; $i < 10; $i++) {
            $pool->breed();
        }
        //echo '<pre>'; print_r($pool); echo '</pre>'; die();

        
        $data = array();

        /*
        $data['crops'] = $crops;
        $data['starter'] = $starter;
        $data['children'][0] = $crops[1];
        $data['children'][1] = $crops[2];
        $data['children'][2] = $crops[3];
        $data['children'][3] = $crops[4];
        $data['new_crop'] = $new_crop;
        
        return view('rust.genetics', $data);
        */
        $data['pool'] = $pool;
        return view('rust.pool', $data);
    }

    function genetics_post(Request $request) {
        $crop = new GeneSequence();
        $crop->randomise();
        dd($crop);
    }
}
