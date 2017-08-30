@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>{{ $survey->name }}</h3>

            <a class="btn btn-primary" href="{{ route('question.create', ['id'=>$survey->id]) }}" role="button">New question</a>

            <div class="panel-body">
              <ul>
              @foreach($survey->questions as $question)
                  <a href="{{ route('question.show', $question->id) }}">{{ $question->name }}</a>
              @endforeach
              </ul>
            </div>
        </div>
    </div>
</div>
@endsection
