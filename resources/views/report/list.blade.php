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
                                <th>email</th>
                                <th>empresa</th>
                                <th>Finalizada</th>
                                <th>Duração</th>
                                <th>Visualizar respostas</th>
                                @if(Auth::user()->isDev && $survey->type == 1)
                                <th>Enviar e-mail</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sample->subjects as $subject)
                            <tr>
                                <?php $c = $subject->answers->first() ?>
                                <?php if ($c) $c = $c->created_at ?>
                                <td>{{ $subject->id }}</td>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->email }}</td>
                                <td>{{ $subject->company }}</td>
                                <td>{{ $subject->pivot->finished_at }}</td>
                                <td>
                                    @if($subject->pivot->finished_at)
                                    {{ $c->diffInMinutes(Carbon\Carbon::parse($subject->pivot->finished_at)) }} min
                                    @endif
                                </td>
                                <td><a href="{{ route('report.view', [$survey->id, $sample->id, $subject->id]) }}" class="btn btn-default">Visualizar</a></td>
                                @if(Auth::user()->isDev && $survey->type == 1)
                                <td><a href="{{ route('direct.email', [$survey->id, $sample->id, $subject->id]) }}" class="btn btn-primary">Enviar</a></td>
                                @endif
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
