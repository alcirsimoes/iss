@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(Auth::user()->isAdmin || Auth::user()->isSupervisor)
                    <a href="{{ route('user.index') }}" class="btn btn-default">Usuários</a>
                    @endif
                    @if(Auth::user()->isAdmin)
                    <a href="{{ route('survey.index') }}" class="btn btn-default">Pesquisas</a>
                    <a href="{{ route('sample.index') }}" class="btn btn-default">Amostras</a>
                    @endif
                    <!--a href="{{ route('subject.index') }}" class="btn btn-default">Respondentes</a-->

                    <hr>
                    <table class="table table-striped">
                        <!-- <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Ações</th>
                            </tr>
                        </thead> -->

                        <tbody>
                            @forelse($surveys as $survey)
                            <tr>
                                <td>{{ $survey->name }}</td>
                                <td>
                                    <a href="{{ route('form.index', $survey->id) }}" class="btn btn-default">Entrevistar</a>
                                    @if(Auth::user()->isAdmin || Auth::user()->isSupervisor)
                                    <a href="{{ route('report.index', $survey->id) }}" class="btn btn-default">Acompanhar</a>
                                    @endif
                                </td>
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
