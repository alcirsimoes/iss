@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $survey->name }} - {{ $sample->name }}</div>

                <div class="panel-body">
                    <a href="{{ route('subject.create', ['id'=>$survey->samples->first()->id,'r'=>1]) }}" class="btn btn-default">Nova entrada</a>
                    <h5>Responder para:</h5>
                    @foreach($sample->subjects as $subject)
                    <ul>
                        <li><a href="{{ route('form.create', [$survey->id, $subject->id]) }}">{{ $subject->name }}</a></li>
                    </ul>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
