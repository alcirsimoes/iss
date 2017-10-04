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

@if($survey->id == 2)
        function ativar_q9(){
            var array = [];

            if ($('.question_48:checked').val()) array.push(Number($('.question_48:checked').val()));

            $(".question_49:checked").each(function() {
                array.push(Number($(this).val()));
            });

            $(".question_50:checked").each(function() {
                array.push(Number($(this).val()));
            });

            $(".question_51:checked").each(function() {
                array.push(Number($(this).val()));
            });

            $(".question_52:checked").each(function() {
                array.push(Number($(this).val()));
            });

            array = $.unique(array);

            for (i = 106; i < 112; i++){
                if ($.inArray(i, array) == -1){
                    $('.question_54.option_'+i).prop('disabled', true);
                } else {
                    $('.question_54.option_'+i).prop('disabled', false);
                }
            }
        }

        for (i = 106; i < 112; i++){
            $('.question_54.option_'+i).prop('disabled', true);
        }
        for (i = 112; i < 200; i++){
            $('.question_54.option_'+i).remove();
        }
        $('.other_54').remove();

        $('.question_48').click(function(){ativar_q9()});
        $('.question_49').click(function(){ativar_q9()});
        $('.question_50').click(function(){ativar_q9()});
        $('.question_51').click(function(){ativar_q9()});
        $('.question_52').click(function(){ativar_q9()});

        ativar_q9();
@endif

@if($survey->id == 1 && $question->id == 6)
        function ativar_q12(){
            var array = [];

            if ($('.question_6:checked').val()) array.push(Number($('.question_6:checked').val()));

            $(".question_7:checked").each(function() {
                array.push(Number($(this).val()));
            });

            $(".question_8:checked").each(function() {
                array.push(Number($(this).val()));
            });

            $(".question_9:checked").each(function() {
                array.push(Number($(this).val()));
            });

            $(".question_10:checked").each(function() {
                array.push(Number($(this).val()));
            });

            array = $.unique(array);

            for (i = 18; i < 23; i++){
                if ($.inArray(i, array) == -1){
                    $('.question_12.option_'+i).prop('disabled', true);
                } else {
                    $('.question_12.option_'+i).prop('disabled', false);
                }
            }
        }

        for (i = 18; i < 23; i++){
            $('.question_12.option_'+i).prop('disabled', true);
        }
        for (i = 23; i < 100; i++){
            $('.question_12.option_'+i).remove();
        }
        $('.other_12').remove();

        $('.question_6').click(function(){ativar_q12()});
        $('.question_7').click(function(){ativar_q12()});
        $('.question_8').click(function(){ativar_q12()});
        $('.question_9').click(function(){ativar_q12()});
        $('.question_10').click(function(){ativar_q12()});

        ativar_q12();
@endif
    </script>
@endsection

@endsection
