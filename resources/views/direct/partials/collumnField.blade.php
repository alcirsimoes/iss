@switch($collumn->type)
    @case(1)
        <div class="form-check">
            <label class="form-check-label">
                @if($other)
                <input class="form-check-input other_{{ $collumn->id }}" type="radio" name="other[unique][{{ $collumn->id }}]" value="1">
                @else
                    @if(isset($answer) && isset($checked_ids[$collumn->id]) && in_array($option->id, $checked_ids[$collumn->id]))
                    <input class="form-check-input question_{{ $collumn->id }}" type="radio" name="question[{{ $collumn->id }}]" value="{{ $option->id }}" checked="checked" required>
                    @else
                    <input class="form-check-input question_{{ $collumn->id }}" type="radio" name="question[{{ $collumn->id }}]" value="{{ $option->id }}" required>
                    @endif
                @endif
            </label>
        </div>
        @if($other)
            @section('scripts')
                @parent
                <script type="text/javascript">
                    $('.question_{{ $collumn->id }}').click(function () {
                        $('.other_{{ $collumn->id }}').prop('checked', false);
                    });

                    $('.other_{{ $collumn->id }}').click(function () {
                        $('.question_{{ $collumn->id }}').prop('checked', false);
                    });
                </script>
            @endsection
        @endif
        @break

    @case(2)
        <div class="form-check">
            <label class="form-check-label">
                @if($other)
                <input class="form-check-input question_{{ $collumn->id }}" type="checkbox" name="other[multiple][{{ $collumn->id }}]" value="1">
                @else
                    @if(isset($answer) && isset($checked_ids[$collumn->id]) && in_array($option->id, $checked_ids[$collumn->id]))
                    <input class="form-check-input question_{{ $collumn->id }}" type="checkbox" name="question[{{ $collumn->id }}][{{ $option->id }}]" value="{{ $option->id }}" checked="checked" required>
                    @else
                    <input class="form-check-input question_{{ $collumn->id }}" type="checkbox" name="question[{{ $collumn->id }}][{{ $option->id }}]" value="{{ $option->id }}" required>
                    @endif
                @endif
            </label>
        </div>
        @break

    @case(3)
        <input class="form-control question_{{ $collumn->id }}" type="text" name="question[{{ $collumn->id }}][{{ $option->id }}]" required>
        @break

    @case(4)
        @if($other)
        <select class="form-control question_{{ $collumn->id }}" name="other[ordering][{{ $collumn->id }}]">
        @else
        <select class="form-control question_{{ $collumn->id }}" name="question[{{ $collumn->id }}][{{ $option->id }}]" required>
        @endif
            <option value="">Ordem...</option>
            @for($i = 1; $i <= count($question->options); $i ++)
                @if(isset($text_values[$collumn->id][$option->id]) && $text_values[$collumn->id][$option->id] == $i)
                <option value="{{ $i }}" selected="selected">{{ $i }}°</option>
                @else
                <option value="{{ $i }}">{{ $i }}°</option>
                @endif
            @endfor
        </select>

        @section('scripts')
            @parent
            <script type="text/javascript">
                var original_{{ $collumn->id }} = _.range({{ count($collumn->options)+1 }});
                var question_{{ $collumn->id }} = _.range({{ count($collumn->options)+1 }});
                var previous_{{ $collumn->id }};

                $('.question_{{ $collumn->id }}').on('focus', function () {
                    previous_{{ $collumn->id }} = this.value;
                }).change(function() {
                    var option = $(this).children();
                    var val = $(this).val();
                    var selected, temp;

                    getCurrentOptions({{ $collumn->id }});
                    temp = question_{{ $collumn->id }}.slice();

                    makeOptions({{ $collumn->id }});
                    $(this).children().remove();

                    if (val && !_.some(temp, val)) {
                        temp.push(Number(val));
                        temp.sort();
                    }

                    for(n in temp){
                        selected = null;
                        if (val == temp[n]) var selected = " selected='selected'";
                        if (temp[n] == 0)
                            $(this).append("<option value=''"+selected+">Ordem...</option>")
                        else
                            $(this).append("<option value='"+temp[n]+"'"+selected+">"+temp[n]+"°</option>")
                    }

                });

                function makeOptions(id){
                    $(".question_"+id).each(function() {
                        var option = $(this).children();
                        var val = $(this).val();
                        var selected;
                        var temp = window['question_'+id].slice();

                        $(option).remove();

                        if (val && !_.some(temp, val)) {
                            temp.push(Number(val));
                            temp.sort();
                        }

                        for(n in temp){
                            selected = null;
                            if (val == temp[n]) var selected = " selected='selected'";
                            if (temp[n] == 0)
                                $(this).append("<option value=''"+selected+">Ordem...</option>")
                            else
                                $(this).append("<option value='"+temp[n]+"'"+selected+">"+temp[n]+"°</option>")
                        }
                    });
                }

                function getCurrentOptions(id){
                    var array = [];
                    var variable = window['original_'+id].slice();
                    var original = window['original_'+id];

                    $(".question_"+id).each(function() {
                        array.push(Number($(this).val()));
                    });

                    for(n in array){
                        if (array[n]) variable = variable.filter(function(item) {
                            return item != array[n];
                        })
                    }
                    window['question_'+id] = variable;
                }
            </script>
        @endsection

        @break

    @case(5)
        @if($other)
        <select class="form-control other_{{ $collumn->id }} option_{{ $option->id }}" name="other[grade][{{ $collumn->id }}]">
        @else
            @if(isset($subCollumn))
            <select class="form-control question_{{ $collumn->id }} option_{{ $option->id }}" name="question[{{ $collumn->id }}][{{ $option->id }}][{{ $subCollumn->id }}]" required>
            @else
            <select class="form-control question_{{ $collumn->id }} option_{{ $option->id }}" name="question[{{ $collumn->id }}][{{ $option->id }}]" required>
            @endif
        @endif
            <option value="">Nota...</option>
            @for($i = 1; $i < 11; $i ++)
                @if(!$other && isset($subCollumn) && isset($text_values[$collumn->id][$option->id][$subCollumn->id]) && $text_values[$collumn->id][$option->id][$subCollumn->id] == $i)
                <option value="{{ $i }}" selected="selected">{{ $i }}</option>
                @elseif(!$other && isset($text_values[$collumn->id][$option->id]) && $text_values[$collumn->id][$option->id] == $i)
                <option value="{{ $i }}" selected="selected">{{ $i }}</option>
                @else
                <option value="{{ $i }}">{{ $i }}</option>
                @endif
            @endfor
        </select>
        @break

    @default
        Invalid question type...
@endswitch
