@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $survey->name }} - {{ $sample->name }} - {{ $subject->name }}</div>

                <div class="panel-body">
                    @forelse($answers as $answer)

                    <div class="panel panel-default">
                        <div class="panel-heading">{!! $answer->question->name !!} - {!! $answer->question->statement !!}</div>

                        <div class="panel-body">
                            @if($answer->question->type == 3 && !count($answer->question->options))
                            <p>{{ $answer->value }}</p>

                            @else
                            <table class="table table-striped">
                                <thead>
                                    <th>Opção {!! $answer->question->options_header !!}</th>
                                    <th> - </th>
                                    <th>Nota</th>
                                </thead>

                                <tbody>
                                    @forelse($answer->options as $option)
                                    <?php $subOption = App\Option::find($option->pivot->sub_option_id); ?>
                                    <tr>
                                        <td>{{ $option->statement }}</td>
                                        <td>@if($subOption){{ $subOption->statement }}@endif</td>
                                        <td>{{ $option->pivot->value }}</td>
                                    </tr>
                                    @empty
                                    @endforelse
                                </tbody>

                            </table>
                            @endif
                        </div>
                    </div>
                    @empty
                    <h3>Questionário sem nenhuma resposta.</h3>
                    @endforelse
                </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
