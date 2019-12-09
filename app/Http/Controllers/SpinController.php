<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class SpinController extends Controller
{
    public function index(Request $request) {
        $turns = $request->input('turns', 1);

        $user = User::find(auth()->user()->id);
        
        $prizes = array('A' => 100000, 'B' => 250000, 'C' => 400000, 'D' => 1000000);
        $weights = array('A' => 50, 'B' => 25, 'C' => 10, 'D' => 5);
        $results = array();

        if ($user->turns < $turns) {
            // Not enough spins left, error
            $results['error'] = 'Not enough spins';
        }
        else {
            for ($i = 1; $i <= 3; $i++) {
                $results[] = $this->getRandomWeightedElement($weights);
            }
            $cash = 0;
            foreach ($results as $value) {
                $cash += $prizes[$value];
            }
            $user->turns -= $turns;
            $user->cash += $cash;
            $user->save();
            $results['turns'] = $user->turns;
            $results['cash_win'] = number_format($cash, 0, '.', ',');
            $results['cash'] = number_format($user->cash, 0, '.', ',');
            $results['success'] = 'Spin Complete';
        }
        return response()->json($results);
    }

    public function getRandomWeightedElement(array $weightedValues) {
    $rand = mt_rand(1, (int) array_sum($weightedValues));

    foreach ($weightedValues as $key => $value) {
        $rand -= $value;
        if ($rand <= 0) {
        return $key;
        }
    }
    }
}
