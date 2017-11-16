@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $survey->name }} - {{ $sample->name }}</div>

                <div class="panel-body">
                    @forelse($questions as $question)

                    <div class="panel panel-default">
                        <div class="panel-heading">{!! $question->name !!} - {!! $question->statement !!}</div>

                        <div class="panel-body">
                            @if($question->type == 3)
                            @forelse($answers->where('question_id', $question->id) as $answer)
                            <p>{{ $answer->value }}</p>
                            @empty
                            @endforelse

                            @elseif($question->type == 1)
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
