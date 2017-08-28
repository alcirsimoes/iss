@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>{{ $survey->name }}</h3>

            <div class="panel-body">
                @foreach($survey->questions as $question)
                    <a href="{{ route('question.show', $question->id) }}">{{ $question->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
