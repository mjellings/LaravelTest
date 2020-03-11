<?php

namespace App\Http\Controllers;

use App\Roulette;
use App\RouletteGame;
use App\RouletteTurn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouletteController extends Controller
{
    public function index(Request $request) {
        $data = array();
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'DESC');
        if (!in_array($sort, array('id', 'finish'))) { $sort = 'id'; }
        if (!in_array($order, array('ASC', 'DESC'))) { $order = 'DESC'; }
        $data['games'] = RouletteGame::orderBy($sort, $order)->simplePaginate(25);

        $all_games = RouletteGame::all();

        /*
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
        */
        $data['total_games'] = count($all_games);
        $data['total_win'] = 0;
        $data['total_lose'] = 0;
        $data['total_even'] = 0;

        $data['biggest_win_amount'] = 0;
        $data['biggest_win_perc'] = 0;
        $data['avg_win_perc'] = 0;

        foreach ($all_games as $game) {
            if ($game->finish > $game->start) {
                // Win game
                $data['total_win']++;
                $win_amount = $game->finish - $game->start;
                $win_perc = $win_amount / $game->start * 100;
                $data['avg_win_perc'] += $win_perc;
                if ($data['biggest_win_amount'] == 0 || $win_amount > $data['biggest_win_amount']) {
                    $data['biggest_win_amount'] = $win_amount;
                }
                if ($data['biggest_win_perc'] == 0 || $win_perc > $data['biggest_win_perc']) {
                    $data['biggest_win_perc'] = $win_perc;
                }
            }
            elseif ($game->finish < $game->start) {
                // Lose
                $data['total_lose']++;
            }
            else {
                // Draw
                $data['total_even']++;
            }
        }
        $data['avg_win_perc'] = $data['avg_win_perc'] / $data['total_win'];

        return view('test', $data);
    }

    public function view($id) {
        $game = RouletteGame::findOrFail($id);
        $data = array();
        $data['game'] = $game;
        return view('test-view', $data);
    }
}
