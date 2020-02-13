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
        $data['games'] = RouletteGame::with('turns')->orderBy('id', 'DESC')->simplePaginate(25);

        $all_games = RouletteGame::all();

        $win_games = RouletteGame::where('finish', '>', 'start')->get();
        $lose_games = RouletteGame::where('finish', '<', 'start')->get();
        $break_even_games = RouletteGame::where('finish', '=', 'start')->get();

        $data['total_games'] = count($all_games);
        $data['total_win'] = count($win_games);
        $data['total_lose'] = count($lose_games);
        $data['total_even'] = count($break_even_games);
        
        $biggest_win_amount = 0;
        $biggest_win_perc = 0;
        foreach ($win_games as $win) {
            $win_amount = ($win->finish - $win->start);
            $win_percentage = $win_amount / $win->start * 100;
            if ($biggest_win_perc == 0 || $win_percentage > $biggest_win_perc) { $biggest_win_perc = $win_percentage; }
            if ($biggest_win_amount == 0 | $win_amount > $biggest_win_amount) { $biggest_win_amount = $win_amount; }
        }

        $data['biggest_win_amount'] = $biggest_win_amount;
        $data['biggest_win_perc'] = $biggest_win_perc;

        return view('test', $data);
    }

    public function view($id) {
        $game = RouletteGame::findOrFail($id);
        $data = array();
        $data['game'] = $game;
        return view('test-view', $data);
    }
}
