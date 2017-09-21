@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $survey->name }} - {{ $sample->name }} - {{ $subject->name }}</div>
            </div>

            @include('layouts.partials.errors')

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
                        <div class="panel-body">
                            <div class="checkbox">
                                <label for="refused_{{ $question->id }}">
                                    <input type="checkbox" id="refused_{{ $question->id }}" name="refused[{{ $question->id }}]" value="1" class="refused_{{ $question->id }}" @if(isset($answer) && $answer->refused)checked="checked"@endif>Se recusou
                                </label>
                            </div>
                            <div class="checkbox">
                                <label for="dontknow_{{ $question->id }}">
                                    <input type="checkbox" id="dontknow_{{ $question->id }}" name="dontknow[{{ $question->id }}]" value="1" class="dontknow_{{ $question->id }}" @if(isset($answer) && $answer->dontknow)checked="checked"@endif>Não sabe
                                </label>
                            </div>
                        </div>
                        @section('scripts')
                            @parent
                            <script type="text/javascript">
                                $('.refused_{{ $question->id }}').click(function () {
                                    $('.dontknow_{{ $question->id }}').prop('checked', false);
                                });

                                $('.dontknow_{{ $question->id }}').click(function () {
                                    $('.refused_{{ $question->id }}').prop('checked', false);
                                });
                            </script>
                        @endsection
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
                <form action="{{ route('form.previous') }}" method="post">
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
        var conditions = {!! json_encode(session('conditions')) !!};

        for (c in conditions){
            $('.refused_'+conditions[c].id).click(function () {
                // alert('91');
            });
            console.log(JSON.stringify(conditions[c].created_at));
            break;
        }
    </script>
@endsection

@endsection
