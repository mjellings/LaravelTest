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

        $numbers = array();
        $numbers[0] = 0.2;
        $numbers[4] = 0.2;
        $numbers[7] = 0.2;
        $numbers[10] = 0.2;
        $numbers[11] = 0.2;
        $numbers[16] = 0.2;
        $numbers[17] = 0.2;
        $numbers[18] = 0.2;
        $numbers[24] = 0.2;
        $numbers[25] = 0.2;

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
