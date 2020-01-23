<?php

namespace App;

class Roulette {
    private $start_cash = 100;
    private $current_cash;

    private $start_bet = 0.1;
    private $current_bet;

    private $max_plays = 100;
    private $current_play = 1;

    private $can_play = true;

    private $win_odd = 4865;

    private $plays = array();
    private $final_play = array();

    public $data = array();
    public $settings = array();

    public function __construct($start_cash = 100, $start_bet = 0.1, $max_plays = 200, $win_odd = 4865) {
        $this->start_cash = $start_cash;
        $this->current_cash = $this->start_cash;
        $this->start_bet = $start_bet;
        $this->current_bet = $this->start_bet;
        $this->max_plays = $max_plays;
        $this->win_odd = $win_odd;
    }

    public function playAll() {
        $this->settings['start_cash'] = $this->start_cash;
        $this->settings['start_bet'] = $this->start_bet;
        $this->settings['max_plays'] = $this->max_plays;
        $this->settings['win_odd'] = $this->win_odd / 100;
        $final_play = array();

        while ($this->can_play) {
            $play = array();
            if (mt_rand(0, 10000) <= $this->win_odd) {
                $play['result'] = 'win';
                $play['bet'] = $this->current_bet;
                $play['balance'] = $this->current_cash;
                
                $this->current_cash += $this->current_bet;
                $this->current_bet = $this->start_bet;

                $play['balance_new'] = $this->current_cash;
            }else {
                $play['result'] = 'lose';
                $play['bet'] = $this->current_bet;
                $play['balance'] = $this->current_cash;
                
                $this->current_cash -= $this->current_bet;
                $this->current_bet = $this->current_bet * 2;

                $play['balance_new'] = $this->current_cash;
            }
            $this->plays[] = $play;
            $this->current_play++;
            if ($this->current_play > $this->max_plays) { $this->can_play = false; $this->final_play = $play; }
            if ($this->current_cash <= 0) { $this->can_play = false; $this->final_play = $play; }
        }

        $this->data['plays'] = $this->plays;
        $this->data['final_play'] = $this->final_play;
        $this->data['settings'] = $this->settings;

        return $this->data;
    }
}