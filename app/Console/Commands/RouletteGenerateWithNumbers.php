<?php

namespace App\Console\Commands;

use App\RouletteWithNumbers;
use App\RouletteGame;
use App\RouletteTurn;
use Illuminate\Console\Command;

class RouletteGenerateWithNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roulette:generate_with_numbers {--games=10}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate 10 roulette games';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $start_cash = 20;
        $max_plays = 100;

        $total_games = 10;
        if ($this->option('games') != $total_games) { $total_games = $this->option('games'); }

        $data = array();

        $this->info('Generating ' . $total_games . ' roulette game(s)');

        $bet_per_number = 0.1;
        $numbers = array();
        $numbers[0] = $bet_per_number;
        $numbers[4] = $bet_per_number;
        $numbers[7] = $bet_per_number;
        $numbers[10] = $bet_per_number;
        $numbers[11] = $bet_per_number;
        $numbers[16] = $bet_per_number;
        $numbers[17] = $bet_per_number;
        $numbers[18] = $bet_per_number;
        $numbers[24] = $bet_per_number;
        $numbers[25] = $bet_per_number;

        $bar = $this->output->createProgressBar($total_games);
        $bar->start();
        for ($i = 1; $i <= $total_games; $i++) {
            $game = new RouletteWithNumbers($start_cash, $max_plays, $numbers);
            $data = $game->playAll();
            $game = null;
            $db = new RouletteGame();
            $db->win_odd = count($numbers) / 37 * 100;
            $db->start = number_format($start_cash, 2);
            $db->finish = number_format($data['final_play']['balance_new'], 2);
            $db->plays = count($data['plays']);
            $db->save();

            $playNumber = 0;
            foreach ($data['plays'] as $play) {
                $playNumber++;
                $dbPlay = new RouletteTurn();
                $dbPlay->roulette_game_id = $db->id;
                $dbPlay->turn = $playNumber;
                $dbPlay->balance_before = number_format($play['balance'], 2);
                $dbPlay->bet = number_format($play['bet'], 2);
                $dbPlay->win = 0;
                if ($play['result'] == 'win') { $dbPlay->win = 1; }
                $dbPlay->result = $play['win_number'];
                $dbPlay->balance_after = number_format($play['balance_new'], 2);
                $dbPlay->save();
            }
            $bar->advance();
            //$this->info(number_format($data['final_play']['balance_new'], 2, '.', ','));
        }
        $bar->finish();
        $this->info(' ');
        $this->info('Finished.');
    }
}
