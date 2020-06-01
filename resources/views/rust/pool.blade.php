@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Gene Pool ({{ count($pool->genes) }} crops)</div>

                <div class="card-body">

                    <table cellpadding="2" cellspacing="2" border="0">
                    <thead>
                        <tr>
                            <td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>Score</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($pool->genes as $crop)
                    <tr>
                        @foreach ($crop->genes as $gene)
                        <td class="gene gene-{{ $gene->code }}">{{ $gene->code }}</td>
                        @endforeach
                        <td>
                            {{ $crop->score }} 
                            @if ($crop->is_new)
                                *
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cross Breeding</div>

                <div class="card-body">

                    @foreach ($pool->history as $breed)
                    <p>Cross Breeding Group</p>
                    <table cellpadding="2" cellspacing="2" border="0">
                        <thead>
                            <tr>
                                <td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>Score</td><td>Note</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="gene gene-{{ $breed['starter']->genes[0]->code }}">{{ $breed['starter']->genes[0]->code }}</td> 
                                <td class="gene gene-{{ $breed['starter']->genes[1]->code }}">{{ $breed['starter']->genes[1]->code }}</td> 
                                <td class="gene gene-{{ $breed['starter']->genes[2]->code }}">{{ $breed['starter']->genes[2]->code }}</td> 
                                <td class="gene gene-{{ $breed['starter']->genes[3]->code }}">{{ $breed['starter']->genes[3]->code }}</td> 
                                <td class="gene gene-{{ $breed['starter']->genes[4]->code }}">{{ $breed['starter']->genes[4]->code }}</td> 
                                <td class="gene gene-{{ $breed['starter']->genes[5]->code }}">{{ $breed['starter']->genes[5]->code }}</td>
                                <td>{{ $breed['starter']->score }}</td>
                                <td>Parent</td>
                            </tr>
                            <tr>
                                <td colspan="8">&nbsp;</td>
                            </tr>
                            @foreach ($breed['donors'] as $crop)
                            <tr>
                                @foreach ($crop->genes as $gene)
                                <td class="gene gene-{{ $gene->code }}">{{ $gene->code }}</td>
                                @endforeach
                                <td>{{ $crop->score }}</td>
                                <td>Donor</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="8">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="gene gene-{{ $breed['new_crop']->genes[0]->code }}">{{ $breed['new_crop']->genes[0]->code }}</td> 
                                <td class="gene gene-{{ $breed['new_crop']->genes[1]->code }}">{{ $breed['new_crop']->genes[1]->code }}</td> 
                                <td class="gene gene-{{ $breed['new_crop']->genes[2]->code }}">{{ $breed['new_crop']->genes[2]->code }}</td> 
                                <td class="gene gene-{{ $breed['new_crop']->genes[3]->code }}">{{ $breed['new_crop']->genes[3]->code }}</td> 
                                <td class="gene gene-{{ $breed['new_crop']->genes[4]->code }}">{{ $breed['new_crop']->genes[4]->code }}</td> 
                                <td class="gene gene-{{ $breed['new_crop']->genes[5]->code }}">{{ $breed['new_crop']->genes[5]->code }}</td>
                                <td>{{ $breed['new_crop']->score }}</td>
                                <td>New Crop</td>
                            </tr>
                        </tbody>
                    </table>
                    <br /><br />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    td { text-align: center; }
    .gene-G { background-color: rgba(0, 255, 0, 0.4); }
    .gene-Y { background-color: rgba(0, 255, 0, 0.4); }
    .gene-H { background-color: rgba(0, 255, 0, 0.2); }
    .gene-W { background-color: rgba(255, 0, 0, 0.4); }
    .gene-X { background-color: rgba(255, 0, 0, 0.4); }
</style>
@endsection

@section('scripts')
<script type="text/javascript">
</script>
@endsection
