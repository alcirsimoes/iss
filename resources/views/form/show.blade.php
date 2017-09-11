@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $survey->name }} - {{ $sample->name }} - {{ $subject->name }}</div>
            </div>

            <div class="jumbotron">
                <p class="lead">{!! $survey->intro !!}</p>
            </div>

            <form action="{{ route('form.current') }}" method="post">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-primary">Começar</button>
            </form>
        </div>
    </div>
</div>
@endsection
