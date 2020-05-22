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
        $crop = new GeneSequence();
        $crop->randomise();
        dd($crop);
    }

    function genetics_post(Request $request) {
        $crop = new GeneSequence();
        $crop->randomise();
        dd($crop);
    }
}
