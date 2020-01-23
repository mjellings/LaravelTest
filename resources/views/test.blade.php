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

                <div class="card-body">
                    <table cellpadding="5" cellspacing="2">
                        <thead>
                            <tr>
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
                            $plays = $game['plays'];
                            ?>
                            <tr>
                                <td>&pound; {{ number_format($settings['start_cash'], 2, '.', ',') }}</td>
                                <td>&pound; {{ number_format($final_play['balance_new'], 2, '.', ',') }}</td>
                                <td>{{ count($plays) }}</td>
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
