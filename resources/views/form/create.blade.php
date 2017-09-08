@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $survey->name }} - {{ $survey->samples->first()->name }} - {{ $subject->name }}</div>
            </div>

            <div class="jumbotron">
                <p class="lead">{{ $survey->intro }}</p>
            </div>

            <div class="panel-body">
                @foreach($survey->questions as $question)
                    <p><strong>{{ $question->name }}</strong> {!! $question->statement !!}</p>

                    @switch($question->type)
                        @case(1)
                            Unique choice...
                            @foreach($question->options as $option)
                                <p>{{ $option->statement }}</p>
                                <input type="radio"
                                    name="question[{{ $question->id }}]"
                                    value="{{ $option->value }}"
                                />
                            @endforeach
                            @break

                        @case(2)
                            Multiple choice...
                            @foreach($question->options as $option)
                                <p>{{ $option->statement }}</p>
                                <input type="checkbox"
                                    name="question[{{ $question->id }}][]"
                                    value="{{ $option->value }}"
                                />
                            @endforeach
                            @break

                        @case(3)
                            Open answer...
                            <textarea name="question[{{ $question->id }}]" rows="8" cols="80"></textarea>
                            @break

                        @case(4)
                            Ordering answer...
                            <textarea name="question[{{ $question->id }}]" rows="8" cols="80"></textarea>
                            @break

                        @case(5)
                            Grade answer...
                            <textarea name="question[{{ $question->id }}]" rows="8" cols="80"></textarea>
                            @break

                        @default
                            Invalid question type...
                    @endswitch

                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
