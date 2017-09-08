<div class="panel-body">
    @switch($question->type)
        @case(1)
            @if ($question->format == 1)
            <select class="form-control" name="question[{{ $question->id }}]">
                @foreach($question->options as $option)
                <option value="{{ $option->id }}">{{ $option->statement }}</option>
                @endforeach
            </select>
                @if ($question->other)
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="text" name="question[{{ $question->id }}]" value="other" placeholder="Outra...">
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
                        <input class="form-check-input" type="text" name="question[{{ $question->id }}][other]" value="other" placeholder="Outra...">
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
                        <input class="form-control" type="text" name="question[{{ $question->id }}][other]" placeholder="Outra...">
                    </label>
                </div>
                @endif
            @endif
            @break

        @case(3)
            @if($question->options)
                @foreach($question->options as $option)
                <div class="form-group">
                    <label for="question{{ $question->id }}">{{ $option->statement }}</label>
                    <textarea name="question[{{ $question->id }}][{{ $option->id }}]" class="form-control" id="question{{ $question->id }}" rows="3"></textarea>
                </div>
                @endforeach
            @else
                <div class="form-group">
                    <textarea name="question[{{ $question->id }}]" class="form-control" rows="3"></textarea>
                </div>
            @endif
            @break

        @case(4)
            @foreach($question->options as $option)
            <div class="form-group">
                <label for="">{{ $option->statement }}</label>
                <select class="form-control" name="question[{{ $question->id }}][{{ $option->id }}]">
                    <option value="">Ordem...</option>
                    @for($i = 1; $i <= count($question->options); $i ++))
                    <option value="{{ $i }}">{{ $i }}°</option>
                    @endfor
                </select>
            </div>
            @endforeach
            @break

        @case(5)
            @foreach($question->options as $option)
            <div class="form-group">
                <label for="">{{ $option->statement }}</label>
                <select class="form-control" name="question[{{ $question->id }}][{{ $option->id }}]">
                    <option value="">Nota...</option>
                    @for($i = 1; $i < 11; $i ++))
                    <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            @endforeach
            @break

        @default
            Invalid question type...
    @endswitch
</div>
