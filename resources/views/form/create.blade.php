@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $survey->name }} - {{ $sample->name }} - {{ $subject->name }}</div>
            </div>

            <div class="jumbotron">
                <p class="lead">{!! $survey->intro !!}</p>
            </div>

            <form action="{{ route('form.store', [$survey->id, $subject->id]) }}" method="post">
                {{ csrf_field() }}
                    @foreach($questions as $question)
                        @if($question->format != 3 && $question->father->isEmpty())
                        <div class="panel panel-default">
                            <div class="panel-heading"><strong>{{ $question->name }}</strong> {!! $question->statement !!}</div>
                        @endif

                        @if($question->format == 3)
                        <div class="panel panel-default">
                            <div class="panel-heading"><strong>{{ $question->name }}</strong> {!! $question->statement !!}</div>
                            @foreach($question->questions as $collumn)
                                @if($collumn->statement)
                                <div class="panel-heading"><strong>{{ $collumn->name }}</strong> {!! $collumn->statement !!}</div>
                                @endif
                            @endforeach
                        @endif

                        @if($question->format != 3 && ($question->father->isEmpty() && $question->questions->isEmpty()))
                            @include('form.partials.simple')
                            </div>
                        @elseif($question->format == 3)
                            @include('form.partials.table')
                            </div>
                        @endif
                    @endforeach

                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>

    @section('scripts')
        @parent
        <script type="text/javascript">
            var answers = {!!$answers = json_encode($answers->toArray()) !!};
        </script>
    @endsection

@endsection
