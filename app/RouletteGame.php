<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RouletteGame extends Model
{
    public function turns() {
        return $this->hasMany('App\RouletteTurn', 'roulette_game_id');
    }
}
