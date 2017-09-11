<div class="panel-body">
    @switch($question->type)
        @case(1)
            <input type="hidden" name="question[{{ $question->id }}]" value="empty">
            @if ($question->format == 1)
            <select class="form-control" name="question[{{ $question->id }}]">
                @foreach($question->options as $option)
                <option value="{{ $option->id }}">{{ $option->statement }}</option>
                @endforeach
            </select>
                @if ($question->other)
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="text" name="other[{{ $question->id }}]" placeholder="Outra...">
                    </label>
                </div>
                @endif
            @endif

            @if ($question->format == 2 || is_null($question->format))
                @foreach($question->options as $key => $option)
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="question[{{ $question->id }}]" value="{{ $option->id }}">
                        {{ $option->statement }}
                    </label>
                </div>
                @endforeach
                @if ($question->other)
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="text" name="other[{{ $question->id }}]" placeholder="Outra...">
                    </label>
                </div>
                @endif
            @endif
            @break

        @case(2)
            @if ($question->format == 2 || is_null($question->format) || $question->other)
                @foreach($question->options as $option)
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="question[{{ $question->id }}][{{ $option->id }}]" value="1">
                        {{ $option->statement }}
                    </label>
                </div>
                @endforeach
                @if ($question->other)
                <div class="form-group">
                    <label class="form-label">
                        <input class="form-control" type="text" name="other[{{ $question->id }}]" placeholder="Outra...">
                    </label>
                </div>
                @endif
            @endif
            @break

        @case(3)
            @forelse ($question->options as $option)
            <div class="form-group">
                <label for="question{{ $question->id }}">{{ $option->statement }}</label>
                <textarea name="question[{{ $question->id }}][{{ $option->id }}]" class="form-control" id="question{{ $question->id }}" rows="3"></textarea>
            </div>
            @empty
                <div class="form-group">
                    <textarea name="question[{{ $question->id }}]" class="form-control" rows="3"></textarea>
                </div>
            @endforelse
            @break

        @case(4)
            @foreach($question->options as $option)
            <div class="form-group row">
                <label for="" class="col-sm-6 col-form-label">{{ $option->statement }}</label>
                <div class="col-sm-3">
                    <select class="form-control question_{{ $question->id }}" name="question[{{ $question->id }}][{{ $option->id }}]">
                        <option value="">Ordem...</option>
                        @for($i = 1; $i <= count($question->options); $i ++)
                        <option value="{{ $i }}">{{ $i }}°</option>
                        @endfor
                    </select>
                </div>
            </div>
            @endforeach

            @section('scripts')
                @parent
                <script type="text/javascript">
                    var original_{{ $question->id }} = _.range({{ count($question->options)+1 }});
                    var question_{{ $question->id }} = _.range({{ count($question->options)+1 }});
                    var previous_{{ $question->id }};

                    $('.question_{{ $question->id }}').on('focus', function () {
                        previous_{{ $question->id }} = this.value;
                    }).change(function() {
                        var option = $(this).children();
                        var val = $(this).val();
                        var selected, temp;

                        getCurrentOptions({{ $question->id }});
                        temp = question_{{ $question->id }}.slice();

                        makeOptions({{ $question->id }});
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
            @foreach($question->options as $option)
            <div class="form-group row">
                <label for="" class="col-sm-6 col-form-label">{{ $option->statement }}</label>
                <div class="col-sm-3">
                    <select class="form-control" name="question[{{ $question->id }}][{{ $option->id }}]">
                        <option value="">Nota...</option>
                        @for($i = 1; $i < 11; $i ++))
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            @endforeach
            @break

        @default
            Invalid question type...
    @endswitch
</div>
