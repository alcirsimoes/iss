<div class="panel-body">
    <?php $other = false ?>
    <table class="table">
        <thead>
            <tr>
                <th>Opções</th>
                <th>{{ $question->name }}</th>

                @foreach($question->questions as $collumn)
                    @forelse($collumn->options as $subCollumn)
                    <th>{{ $subCollumn->statement }}</th>
                    @empty
                    <th>{{ $collumn->name }}</th>
                    @endforelse
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach($question->options as $option)
            <tr>
                <td>{{ $option->statement }}</td>
                <td>
                    <?php $collumn = $question ?>
                    @include('form.partials.collumnField')
                </td>

                @foreach($question->questions as $collumn)
                    @forelse($collumn->options as $subCollumn)
                    <td>
                        @include('form.partials.collumnField')
                    </td>
                    @empty
                    <td>
                        @include('form.partials.collumnField')
                    </td>
                    @endforelse
                @endforeach
            </tr>
            @endforeach

            @if ($question->other)
            <?php $other = true ?>
            <tr>
                <td>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="text" name="question[{{ $question->id }}][other_option]" value="" placeholder="Outra...">
                        </label>
                    </div>
                </td>
                <td>
                    <?php $collumn = $question ?>
                    @include('form.partials.collumnField')
                </td>

                @foreach($question->questions as $collumn)
                <td>
                    @include('form.partials.collumnField')
                </td>
                @endforeach
            </tr>

            @endif
        </tbody>
    </table>
</div>
