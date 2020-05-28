@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">

                    <table cellpadding="2" cellspacing="2" border="0">
                    <thead>
                        <tr>
                            <td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>Score</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($crops as $crop)
                    <tr>
                        @foreach ($crop->genes as $gene)
                        <td class="gene gene-{{ $gene->code }}">{{ $gene->code }}</td>
                        @endforeach
                        <td>{{ $crop->score }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">

                    <table cellpadding="2" cellspacing="2" border="0">
                        <thead>
                            <tr>
                                <td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>Score</td><td>Note</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="gene gene-{{ $starter->genes[0]->code }}">{{ $starter->genes[0]->code }}</td> 
                                <td class="gene gene-{{ $starter->genes[1]->code }}">{{ $starter->genes[1]->code }}</td> 
                                <td class="gene gene-{{ $starter->genes[2]->code }}">{{ $starter->genes[2]->code }}</td> 
                                <td class="gene gene-{{ $starter->genes[3]->code }}">{{ $starter->genes[3]->code }}</td> 
                                <td class="gene gene-{{ $starter->genes[4]->code }}">{{ $starter->genes[4]->code }}</td> 
                                <td class="gene gene-{{ $starter->genes[5]->code }}">{{ $starter->genes[5]->code }}</td>
                                <td>{{ $starter->score }}</td>
                                <td>Parent</td>
                            </tr>
                            <tr>
                                <td colspan="8">&nbsp;</td>
                            </tr>
                            @foreach ($children as $crop)
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
                                <td class="gene gene-{{ $new_crop->genes[0]->code }}">{{ $new_crop->genes[0]->code }}</td> 
                                <td class="gene gene-{{ $new_crop->genes[1]->code }}">{{ $new_crop->genes[1]->code }}</td> 
                                <td class="gene gene-{{ $new_crop->genes[2]->code }}">{{ $new_crop->genes[2]->code }}</td> 
                                <td class="gene gene-{{ $new_crop->genes[3]->code }}">{{ $new_crop->genes[3]->code }}</td> 
                                <td class="gene gene-{{ $new_crop->genes[4]->code }}">{{ $new_crop->genes[4]->code }}</td> 
                                <td class="gene gene-{{ $new_crop->genes[5]->code }}">{{ $new_crop->genes[5]->code }}</td>
                                <td>{{ $new_crop->score }}</td>
                                <td>New Crop</td>
                            </tr>
                            <tr>
                        </tbody>
                    </table>
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
