<?php

namespace App\Http\Controllers;

use App\Roulette;
use Illuminate\Http\Request;

class RouletteController extends Controller
{
    public function index() {
        $start_cash = 100;
        $start_bet = 0.1;
        $max_plays = 100;
        $win_odd = 4865;

        $total_games = 100;

        $data = array();
        for ($i = 1; $i <= $total_games; $i++) {
            $game = new Roulette($start_cash, $start_bet, $max_plays, $win_odd);
            $data['games'][] = $game->playAll();
            $game = null;
        }

        return view('test', $data);
    }
}
