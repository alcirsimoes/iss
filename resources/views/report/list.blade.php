@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $survey->name }} - {{ $sample->name }}</div>

                <div class="panel-body">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>nome</th>
                                <th>empresa</th>
                                <th>telefone</th>
                                <th>Visualizar respostas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sample->subjects as $subject)
                            <tr>
                                <td>{{ $subject->id }}</td>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->company }}</td>
                                <td>{{ $subject->telephone }}</td>
                                <td><a href="{{ route('report.view', [$survey->id, $sample->id, $subject->id]) }}" class="btn btn-default">Visualizar</a></td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
