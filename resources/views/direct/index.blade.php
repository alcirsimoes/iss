@extends('layouts.direct')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="jumbotron">
                <p class="lead">{{ $subject->name }}. {!! $survey->intro !!}</p>
                <form action="{{ route('direct.next') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="init" value="1">
                    <input type="hidden" name="next" value="0">
                    <button type="submit" class="btn btn-primary btn-lg">Começar</button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
