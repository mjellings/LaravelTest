@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <style>
        .win { background-color: rgba(0, 255, 0, 0.3); }
        .lose { background-color: rgba(255, 0, 0, 0.3); }
        </style>
        
        
        <div class="col-md-12" style="margin-bottom: 10px;">
            <div class="card">
                <div class="card-header">Game: {{ $game->id }}</div>
                <div class="card-body">
                    <p>Win Odds: {{ number_format($game->win_odd, 2) }} %</p>
                    <p>Start Balance: &pound; {{ number_format($game->start, 2, '.', ',') }}</p>
                    <p>Finish Balance: &pound; {{ number_format($game->finish, 2, '.', ',') }}</p>
                    <p>Rounds: {{ count($game->turns) }}</p>
                    <table cellpadding="5" cellspacing="0" class="collapse-one">
                        <thead>
                            <tr>
                                <th>Turn</th>
                                <th>Balance</th>
                                <th>Bet</th>
                                <th>Number</th>
                                <th>Result</th>
                                <th>New Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($game->turns as $turn)
                            <tr>
                                <td class="{{ $turn['win'] == 1 ? 'win' : 'lose' }}">{{ $turn->turn }}</td>
                                <td class="{{ $turn['win'] == 1 ? 'win' : 'lose' }}">&pound; {{ number_format($turn->balance_before, 2, '.', ',') }}</td>
                                <td class="{{ $turn['win'] == 1 ? 'win' : 'lose' }}">&pound; {{ number_format($turn->bet, 2, '.', ',') }}</td>
                                <td class="{{ $turn['win'] == 1 ? 'win' : 'lose' }}">{{ $turn->result }}</td>
                                <td class="{{ $turn['win'] == 1 ? 'win' : 'lose' }}">{{ $turn['win'] == 1 ? 'win' : 'lose' }}</td>
                                <td class="{{ $turn['win'] == 1 ? 'win' : 'lose' }}">&pound; {{ number_format($turn->balance_after, 2, '.', ',') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
