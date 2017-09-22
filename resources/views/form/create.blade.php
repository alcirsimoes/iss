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
        @if(false)var conditions = {!! json_encode(session('conditions')) !!};@endif

        function ativar_q9(){
            var array = [];

            if ($('.question_3:checked').val()) array.push(Number($('.question_3:checked').val()));

            $(".question_4:checked").each(function() {
                array.push(Number($(this).val()));
            });

            $(".question_5:checked").each(function() {
                array.push(Number($(this).val()));
            });

            $(".question_6:checked").each(function() {
                array.push(Number($(this).val()));
            });

            $(".question_7:checked").each(function() {
                array.push(Number($(this).val()));
            });

            array = $.unique(array);

            for (i = 5; i < 11; i++){
                if ($.inArray(i, array) == -1){
                    $('.question_9.option_'+i).prop('disabled', true);
                } else {
                    $('.question_9.option_'+i).prop('disabled', false);
                }
            }
        }

        $('.question_3').click(function(){ativar_q9()});
        $('.question_4').click(function(){ativar_q9()});
        $('.question_5').click(function(){ativar_q9()});
        $('.question_6').click(function(){ativar_q9()});
        $('.question_7').click(function(){ativar_q9()});

        for (i = 5; i < 11; i++){
            $('.question_9.option_'+i).prop('disabled', true);
        }
        for (i = 11; i < 100; i++){
            $('.question_9.option_'+i).remove();
        }

        $('.other_9').remove();
    </script>
@endsection

@endsection
