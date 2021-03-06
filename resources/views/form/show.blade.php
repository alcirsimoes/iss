@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $survey->name }} - {{ $sample->name }} - {{ $subject->name }}</div>
            </div>

            <div class="jumbotron">
                <p class="lead">{!! $survey->intro !!}</p>
            </div>

            <form action="{{ route('form.next') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="init" value="1">
                <input type="hidden" name="next" value="0">
                <button type="submit" class="btn btn-primary">Começar</button>
            </form>
        </div>
    </div>
</div>
@endsection
