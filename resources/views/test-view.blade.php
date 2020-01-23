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
                    
                    <pre><?php print_r($game); ?></pre>

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
