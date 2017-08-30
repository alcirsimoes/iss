@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <form class="form" action="{{ route('question.store') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="survey_id" value="{{ $survey->id }}">
                <div class="form-group">
                    <label for="InputName">Question name: </label>
                    <input type="text" name="name" class="form-control" id="InputName" aria-describedby="nameHelp" placeholder="Enter question name">
                    <small id="nameHelp" class="form-text text-muted">Insert a unique name to the question.</small>
                </div>
                <div class="form-group">
                    <label for="InputStatement">Question statement: </label>
                    <textarea name="statement" class="form-control" id="InputStatement" aria-describedby="nameHelp" placeholder="Enter question statement" rows="8" cols="80"></textarea>
                    <small id="nameHelp" class="form-text text-muted">Insert a statement to the question.</small>
                </div>
                <div class="form-group">
                    <label for="InputStatement">Question type: </label>

                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" name="type" value="1" class="form-check-input">
                            Unique choice
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" name="type" value="2" class="form-check-input">
                            Multiple choice
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" name="type" value="3" class="form-check-input">
                            Open
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="InputStatement">Format: </label>

                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" name="type" value="1" class="form-check-input">
                            Unique field
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" name="type" value="2" class="form-check-input">
                            Multiple fields
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" name="type" value="3" class="form-check-input">
                            Composite table
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="InputOption1">Option value: </label>
                    <input type="text" name="option[]" class="form-control" id="InputOption1" placeholder="Enter option value">
                </div>
                <div class="form-group">
                    <label for="InputOption2">Option value: </label>
                    <input type="text" name="option[]" class="form-control" id="InputOption2" placeholder="Enter option value">
                </div>
                <div class="form-group">
                    <label for="InputOption3">Option value: </label>
                    <input type="text" name="option[]" class="form-control" id="InputOption3" placeholder="Enter option value">
                </div>

                <div class="form-group">
                    <label for="InputCollumn1">Collumn value: </label>
                    <input type="text" name="collumn[]" class="form-control" id="InputCollumn1" placeholder="Enter collumn value">
                    <label for="InputType1">Collumn type: </label>
                    <input type="text" name="collumnType[]" class="form-control" id="InputType1" placeholder="Enter collumn type">
                    <label for="InputStatement1">Collumn statement: </label>
                    <textarea name="statement" class="form-control" id="InputStatement1" placeholder="Enter question statement" rows="8" cols="80"></textarea>
                </div>
                <div class="form-group">
                    <label for="InputCollumn1">Collumn value: </label>
                    <input type="text" name="collumn[]" class="form-control" id="InputCollumn1" placeholder="Enter collumn value">
                    <label for="InputType1">Collumn type: </label>
                    <input type="text" name="collumnType[]" class="form-control" id="InputType1" placeholder="Enter collumn type">
                    <label for="InputStatement1">Collumn statement: </label>
                    <textarea name="statement" class="form-control" id="InputStatement1" placeholder="Enter question statement" rows="8" cols="80"></textarea>
                </div>
                <div class="form-group">
                    <label for="InputCollumn1">Collumn value: </label>
                    <input type="text" name="collumn[]" class="form-control" id="InputCollumn1" placeholder="Enter collumn value">
                    <label for="InputType1">Collumn type: </label>
                    <input type="text" name="collumnType[]" class="form-control" id="InputType1" placeholder="Enter collumn type">
                    <label for="InputStatement1">Collumn statement: </label>
                    <textarea name="statement" class="form-control" id="InputStatement1" placeholder="Enter question statement" rows="8" cols="80"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>

            </form>
        </div>
    </div>
</div>
@endsection
