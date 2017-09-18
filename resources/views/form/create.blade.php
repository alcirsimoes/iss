@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $survey->name }} - {{ $sample->name }} - {{ $subject->name }}</div>
            </div>

            <form action="{{ route('form.next') }}" method="post">
                {{ csrf_field() }}
                @if($question->format != 3 && $question->father->isEmpty())
                <div class="panel panel-default">
                    <div class="panel-heading">{!! $question->statement !!}</div>
                @endif

                @if($question->format == 3)
                <div class="panel panel-default">
                    <div class="panel-heading">{!! $question->statement !!}</div>
                    @foreach($question->questions as $collumn)
                        @if($collumn->statement)
                        <div class="panel-heading">{!! $collumn->statement !!}</div>
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

                <input type="hidden" name="previous" value="{{ $question->order }}">
                <input type="hidden" name="next" value="{{ $question->order +1 }}">

                <button type="submit" class="btn btn-primary">Próxima</button>
            </form>
            @if(isset($previous))
            <hr>
                @if(isset($previous))
                <form action="{{ route('form.next') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="next" value="{{ $previous->order }}">
                    <button type="submit" class="btn btn-danger">Anterior</button>
                </form>
                @endif
            @endif
        </div>
    </div>
</div>

@section('scripts')
    @parent
    <script type="text/javascript">
        @if($answer)
        var answers = {!! json_encode($answer->toArray()) !!};
        @endif
    </script>
@endsection

@endsection
