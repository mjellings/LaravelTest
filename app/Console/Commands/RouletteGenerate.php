<?php

namespace App\Console\Commands;

use App\Roulette;
use App\RouletteGame;
use App\RouletteTurn;
use Illuminate\Console\Command;

class RouletteGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roulette:generate {--games=10}';

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
        $start_cash = 100;
        $start_bet = 0.1;
        $max_plays = 100;
        $win_odd = 4865;

        $total_games = 10;
        if ($this->option('games') != $total_games) { $total_games = $this->option('games'); }

        $data = array();

        $this->info('Generating ' . $total_games . ' roulette game(s)');

        $bar = $this->output->createProgressBar($total_games);
        $bar->start();
        for ($i = 1; $i <= $total_games; $i++) {
            $game = new Roulette($start_cash, $start_bet, $max_plays, $win_odd);
            $data = $game->playAll();
            $game = null;
            $db = new RouletteGame();
            $db->win_odd = $win_odd / 100;
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
