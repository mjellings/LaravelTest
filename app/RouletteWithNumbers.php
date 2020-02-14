<?php

namespace App;

class RouletteWithNumbers {
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

    public $numbers = array();

    public function __construct($start_cash = 100, $max_plays = 200, $numbers = array()) {
        $this->start_cash = $start_cash;
        $this->current_cash = $this->start_cash;
        $this->current_bet = 0;
        $this->max_plays = $max_plays;
        $this->numbers = $numbers;
    }

    public function playAll() {
        $this->settings['start_cash'] = $this->start_cash;
        if (!count($this->numbers)) { $this->numbers = array('0' => 0.1); }
        foreach ($this->numbers as $number => $stake) {
            $this->current_bet += $stake;
        }
        $this->settings['max_plays'] = $this->max_plays;
        $final_play = array();

        while ($this->can_play) {
            $play = array();
            $result = floor(mt_rand(0, 37));
            $play['win_number'] = $result;
            if (isset($this->numbers[$result])) {
                // Win
                $play['result'] = 'win';
                $play['bet'] = $this->current_bet;
                $play['balance'] = $this->current_cash;

                $this->current_cash += $this->numbers[$result] * 36;
                $play['balance_new'] = $this->current_cash;
            } else {
                // Lose
                $play['result'] = 'lose';
                $play['bet'] = $this->current_bet;
                $play['balance'] = $this->current_cash;

                $this->current_cash -= $this->current_bet;
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