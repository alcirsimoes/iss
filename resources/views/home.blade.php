@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ route('user.index') }}" class="btn btn-default">Usuários</a>
                    <a href="{{ route('survey.index') }}" class="btn btn-default">Pesquisas</a>
                    <a href="{{ route('sample.index') }}" class="btn btn-default">Amostras</a>
                    <a href="{{ route('subject.index') }}" class="btn btn-default">Respondentes</a>

                    <hr>
                    @foreach($surveys as $survey)
                        <a href="{{ route('form.index', $survey->id) }}" class="btn btn-default">Questionário - {{ $survey->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
