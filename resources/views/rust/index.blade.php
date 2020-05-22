@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">

                    <form method="post" action="/rust/genetics">
                        @csrf
                        <div class="form-group row">
                            <label for="genetics" class="col-md-4 col-form-label text-md-right">Genetics (one per line)</label>

                            <div class="col-md-6">
                                <textarea id="genetics" class="form-control @error('genetics') is-invalid @enderror" name="genetics" rows="20" cols="10"></textarea>

                                @error('genetics')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
</script>
@endsection
