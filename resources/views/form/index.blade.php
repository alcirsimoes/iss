@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $survey->name }} - {{ $sample->name }}</div>

                <div class="panel-body">
                    <a href="{{ route('subject.create', ['id'=>$survey->samples->first()->id,'r'=>1]) }}" class="btn btn-default">Nova entrada</a>
                    <h5>Responder para:</h5>

                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <!-- <th>id</th> -->
                                <th>nome</th>
                                <th>empresa</th>
                                <th>telefone</th>
                                <th>Iniciar Pesquisa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sample->subjects->where('user_id', Auth::user()->id) as $subject)
                            <tr>
                                <!-- <td>{{ $subject->id }}</td> -->
                                <td><a href="{{ route('subject.edit', [$subject->id]) }}">{{ $subject->name }}</a></td>
                                <td>{{ $subject->company }}</td>
                                <td>{{ $subject->telephone }}</td>
                                <td><a href="{{ route('form.create', [$sample->id, $subject->id]) }}" class="btn btn-default">Responder </a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
