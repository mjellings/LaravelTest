@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <style>
        .win { background-color: rgba(0, 255, 0, 0.3); }
        .lose { background-color: rgba(255, 0, 0, 0.3); }
        </style>
        
        
        <div class="col-md-6" style="margin-bottom: 10px;">
            <div class="card">

                <div class="card-body">
                    <table cellpadding="5" cellspacing="2">
                        <thead>
                            <tr>
                                <th>Game ID</th>
                                <th>Win Odds</th>
                                <th>Start</th>
                                <th>Finish</th>
                                <th>Plays</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($games as $game)
                            <?php
                            $settings = $game['settings'];
                            $final_play = $game['final_play'];
                            $turns = $game->turns;
                            ?>
                            <tr>
                                <td class="{{ ($game->finish > $game->start) ? 'win' : 'lose' }}"><a href="/test/{{ $game->id }}">{{ $game->id }}</a></td>
                                <td class="{{ ($game->finish > $game->start) ? 'win' : 'lose' }}">{{ number_format($game->win_odd, 2) }} %</td>
                                <td class="{{ ($game->finish > $game->start) ? 'win' : 'lose' }}">&pound; {{ number_format($game->start, 2, '.', ',') }}</td>
                                <td class="{{ ($game->finish > $game->start) ? 'win' : 'lose' }}">&pound; {{ number_format($game->finish, 2, '.', ',') }}</td>
                                <td class="{{ ($game->finish > $game->start) ? 'win' : 'lose' }}">{{ count($turns) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    {{ $games->links() }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>

        <div class="col-md-6" style="margin-bottom: 10px;">
            <div class="card">
                <div class="card-header">Statistics</div>
                <div class="card-body">
                    Total Games: {{ $total_games }}<br />
                    Total Wins: {{ $total_win }}<br />
                    Total Lose: {{ $total_lose }}<br />
                    Total Break Even: {{ $total_even }}<br />
                    Biggest Win %: {{ $biggest_win_perc }}<br />
                    Biggest Win &pound: {{ $biggest_win_amount }}<br />
                    Avg Win %: {{ number_format($avg_win_perc, 2) }} %<br />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$('.expand-one').click(function(){
    $('.content-one').slideToggle('slow');
});
</script>
@endsection
