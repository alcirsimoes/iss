@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>{{ $user->name }}</h3>

            @if(Auth::user()->isDev)
                @if($user->isAdmin)
                <a class="btn btn-default" href="{{ route('user.unsetAdmin', ['id'=>$user->id]) }}" role="button">Remover admin</a>
                @else
                <a class="btn btn-default" href="{{ route('user.setAdmin', ['id'=>$user->id]) }}" role="button">Tornar admin</a>
                @endif
            @endif
            @if(Auth::user()->isAdmin )
                @if($user->isSupervisor)
                <a class="btn btn-default" href="{{ route('user.unsetSupervisor', ['id'=>$user->id]) }}" role="button">Remover Supervisor</a>
                @else
                <a class="btn btn-default" href="{{ route('user.setSupervisor', ['id'=>$user->id]) }}" role="button">Tornar Supervisor</a>
                @endif
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
