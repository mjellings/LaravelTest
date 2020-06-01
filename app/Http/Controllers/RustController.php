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
        $num_genes = 50;
        $pool = GenePool::makeRandom($num_genes);

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

        /*
        yggghw
        hyyhyg
        wgyygh
        yhgyyx
        ggywhh
        ghhwgh
        ghyygh
        gygxgh
        */

        $input = $request->input('genetics', "");

        # Convert to uppercase
        $input = strtoupper($input);

        # Trim some unwanted crap, this should be done using arrays for input into str_replace but im lazy
        $input = str_replace("\r", "\n", $input);
        $input = str_replace("\n\n", "\n", $input);
        $input = str_replace("\t", '', $input);
        $input = str_replace(' ', '', $input);

        # Trim any whitespace
        $input = trim($input);

        # If we dont have any text left, then exit
        if (!$input) {
            die('No input text found');
        }

        # Split into individual lines
        $tmp = explode("\n", $input);

        # Pass input lines onto the GenePool class to create a new instance with specific gene codes
        $pool = GenePool::makeSpecific($tmp);

        # Loop a few times and tell the pool to breed
        for ($i = 0; $i < 100; $i++) {
            $pool->breed();
        }

        # Prepare view data
        $data = array();
        $data['pool'] = $pool;

        # Show view
        return view('rust.pool', $data);
        
    }
}
