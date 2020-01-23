<?php

namespace App\Http\Controllers;

use App\Roulette;
use App\RouletteGame;
use App\RouletteTurn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouletteController extends Controller
{
    public function index() {
        $data = array();
        $data['games'] = RouletteGame::orderBy('id', 'DESC')->simplePaginate(25);
        return view('test', $data);
    }

    public function view($id) {
        $game = RouletteGame::findOrFail($id);
        $data = array();
        $data['game'] = $game;
        return view('test-view', $data);
    }
}
