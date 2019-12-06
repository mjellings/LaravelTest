@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Game Spins: <span id="spins_remiaining">{{ Auth::user()->spins }}</span></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row" style="margin-bottom: 20px;">
                        <div id="spin1" class="col-md-4" style="text-align: center;">
                        
                        </div>
                        <div id="spin2" class="col-md-4" style="text-align: center;">
                        
                        </div>
                        <div id="spin3" class="col-md-4" style="text-align: center;">
                        
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 20px;">
                            <div id="win" class="col-md-12 style="text-align: center;">
                            
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-md-12" style="text-align: center;">
                            <input class="btn btn-primary" type="button" id="do_spin" value="Spin" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $("#do_spin").click(function(e){
        e.preventDefault();
        $.ajax({
           type:'POST',
           url:'/spin',
           data:{"_token": "{{ csrf_token() }}"},
           success:function(data){
              if (data.success) {
                jQuery('#spins_remiaining').html(data['spins']);
                jQuery('#spin1').html(data[0]);
                jQuery('#spin2').html(data[1]);
                jQuery('#spin3').html(data[2]);
                jQuery('#win').html('$' + data['cash_win']);
              }
           }, 
           error:function(data) {
               
           }
        });
	});
</script>
@endsection
