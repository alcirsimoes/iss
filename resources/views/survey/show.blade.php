@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>{{ $survey->name }}</h3>

            <a class="btn btn-primary" href="{{ route('question.create', ['id'=>$survey->id]) }}" role="button">New question</a>

            <div class="panel-body">
                  <table>
                  @foreach($survey->questions as $question)
                  <tr>
                      <td>
                          <a href="{{ route('question.show', $question->id) }}">{{ $question->name }}</a>
                      </td>
                      <td>
                          <a href="{{ route('question.edit', $question->id) }}" class="btn btn-default">edit</a>
                      </td>
                      <td>
                          <form action="{{ route('question.destroy', $question->id) }}" method="post">
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
@endsection
