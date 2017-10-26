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
                                <th>id</th>
                                <th>nome</th>
                                <th>empresa</th>
                                <th>telefone</th>
                                <th>Finalizada</th>
                                <th>Duração</th>
                                <th>Iniciar Pesquisa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (Auth::user()->isSupervisor || Auth::user()->isAdmin)
                                @forelse ($sample->subjects as $subject)
                                    <tr>
                                        <?php $c = $subject->answers->first() ?>
                                        <?php if ($c) $c = $c->created_at ?>
                                        <td>{{ $subject->id }}</td>
                                        <td><a href="{{ route('subject.edit', [$subject->id]) }}">{{ $subject->name }}</a></td>
                                        <td>{{ $subject->company }}</td>
                                        <td>{{ $subject->telephone }}</td>
                                        <td>{{ $subject->pivot->finished_at }}</td>
                                        <td>
                                            @if($subject->pivot->finished_at)
                                            {{ $c->diffInMinutes(Carbon\Carbon::parse($subject->pivot->finished_at)) }} min
                                            @endif
                                        </td>
                                        @if($survey->type != 1)
                                        <td><a href="{{ route('form.create', [$survey->id, $subject->id]) }}" class="btn btn-default">Responder </a></td>
                                        @endif
                                        @if($survey->type == 1)
                                        <?php $token = base64_encode(json_encode([
                                            'survey_id' => $survey->id,
                                            'sample_id' => $sample->id,
                                            'subject_id' => $subject->id,
                                            ])) ?>
                                        <td><a href="{{ route('direct.login', $token) }}" class="btn btn-default">Questionário</a></td>
                                        @endif
                                    </tr>
                                @empty
                                @endforelse
                            @else
                                @forelse($sample->subjects->where('user_id', Auth::user()->id) as $subject)
                                <tr>
                                    <?php $c = $subject->answers->first() ?>
                                    <?php if ($c) $c = $c->created_at ?>
                                    <td>{{ $subject->id }}</td>
                                    <td><a href="{{ route('subject.edit', [$subject->id]) }}">{{ $subject->name }}</a></td>
                                    <td>{{ $subject->company }}</td>
                                    <td>{{ $subject->telephone }}</td>
                                    <td>{{ $subject->pivot->finished_at }}</td>
                                    <td>
                                        @if($subject->pivot->finished_at)
                                        {{ $c->diffInMinutes(Carbon\Carbon::parse($subject->pivot->finished_at)) }} min
                                        @endif
                                    </td>
                                    @if($survey->type != 1)
                                    <td><a href="{{ route('form.create', [$survey->id, $subject->id]) }}" class="btn btn-default">Responder </a></td>
                                    @endif
                                </tr>
                                @empty
                                @endforelse
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
