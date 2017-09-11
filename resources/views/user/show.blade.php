@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>{{ $user->name }}</h3>

            @if(Auth::user()->isAdmin)
            <a class="btn btn-primary" href="{{ route('user.admin', ['id'=>$user->id]) }}" role="button">Set admin</a>
            @endif
            @if(Auth::user()->isAdmin || Auth::user()->isSupervisor)
            <a class="btn btn-default" href="{{ route('user.supervisor', ['id'=>$user->id]) }}" role="button">Tornar Supervisor</a>
            @endif

            <div class="panel-body">
                <ul>
                    <li>{{ $user->name }}</li>
                    <li>{{ $user->email }}</li>
                    @if($user->isAdmin)
                    <li>Administrador</li>
                    @endif()
                    @if($user->isSupervisor)
                    <li>Supervisor</li>
                    @endif()
                    <li>Entrevistador</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
