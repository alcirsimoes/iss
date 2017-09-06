@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ route('survey.create') }}" class="btn btn-default">New survey</a></div>

                <div class="panel-body">
                    <table>
                        @foreach($surveys as $survey)
                        <tr>
                            <td>
                                <a href="{{ route('survey.show', $survey->id) }}">{{ $survey->name }}</a>
                            </td>
                            <td>
                                <a href="{{ route('survey.edit', $survey->id) }}" class="btn btn-default">edit</a>
                            </td>
                            <td>
                                <form action="{{ route('survey.destroy', $survey->id) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger">delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
