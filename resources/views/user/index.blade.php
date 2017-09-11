@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ route('user.create') }}" class="btn btn-default">New user</a></div>

                <div class="panel-body">
                    <table class="table">
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a>
                            </td>
                            @if(Auth::user()->isAdmin)
                            <td>
                                <form action="{{ route('user.destroy', $user->id) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger">delete</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
