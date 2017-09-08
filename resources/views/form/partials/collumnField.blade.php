@switch($collumn->type)
    @case(1)
        <div class="form-check">
            <label class="form-check-label">
                @if($other)
                <input class="form-check-input" type="radio" name="question[{{ $collumn->id }}][other]" value="1">
                @else
                <input class="form-check-input" type="radio" name="question[{{ $collumn->id }}][{{ $option->id }}]" value="1">
                @endif
            </label>
        </div>
        @break

    @case(2)
        <div class="form-check">
            <label class="form-check-label">
                @if($other)
                <input class="form-check-input" type="checkbox" name="question[{{ $collumn->id }}][other]" value="1">
                @else
                <input class="form-check-input" type="checkbox" name="question[{{ $collumn->id }}][{{ $option->id }}]" value="1">
                @endif
            </label>
        </div>
        @break

    @case(3)
        <input class="form-control" type="text" name="question[{{ $collumn->id }}][{{ $option->id }}]">
        @break

    @case(4)
        @if($other)
        <select class="form-control" name="question[{{ $collumn->id }}][other]">
        @else
        <select class="form-control" name="question[{{ $collumn->id }}][{{ $option->id }}]">
        @endif
            <option value="">Nota...</option>
            @for($i = 1; $i <= count($collumn->options); $i ++))
            <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
        @break

    @case(5)
        @if($other)
        <select class="form-control" name="question[{{ $collumn->id }}][other]">
        @else
        <select class="form-control" name="question[{{ $collumn->id }}][{{ $option->id }}]">
        @endif
            <option value="">Nota...</option>
            @for($i = 1; $i < 11; $i ++)
            <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
        @break

    @default
        Invalid question type...
@endswitch
