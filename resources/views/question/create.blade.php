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
                            <input type="radio" name="format" value="1" class="form-check-input">
                            Unique field
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" name="format" value="2" class="form-check-input">
                            Multiple fields
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" name="format" value="3" class="form-check-input">
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
                    <label for="InputOption4">Option value: </label>
                    <input type="text" name="option[]" class="form-control" id="InputOption4" placeholder="Enter option value">
                </div>
                <div class="form-group">
                    <label for="InputOption5">Option value: </label>
                    <input type="text" name="option[]" class="form-control" id="InputOption5" placeholder="Enter option value">
                </div>
                <div class="form-group">
                    <label for="InputOption6">Option value: </label>
                    <input type="text" name="option[]" class="form-control" id="InputOption6" placeholder="Enter option value">
                </div>
                <div class="form-group">
                    <label for="InputOption7">Option value: </label>
                    <input type="text" name="option[]" class="form-control" id="InputOption7" placeholder="Enter option value">
                </div>
                <div class="form-group">
                    <label for="InputOption8">Option value: </label>
                    <input type="text" name="option[]" class="form-control" id="InputOption8" placeholder="Enter option value">
                </div>
                <div class="form-group">
                    <label for="InputOption9">Option value: </label>
                    <input type="text" name="option[]" class="form-control" id="InputOption9" placeholder="Enter option value">
                </div>
                <div class="form-group">
                    <label for="InputOption10">Option value: </label>
                    <input type="text" name="option[]" class="form-control" id="InputOption10" placeholder="Enter option value">
                </div>
                <div class="form-group">
                    <label for="InputOption11">Option value: </label>
                    <input type="text" name="option[]" class="form-control" id="InputOption11" placeholder="Enter option value">
                </div>
                <div class="form-group">
                    <label for="InputOption3">Other: </label>
                    <input type="checkbox" name="other" class="form-control" id="InputOption3" value='1'>
                </div>

                <div class="form-group">
                    <label for="InputCollumn1">Collumn value: </label>
                    <input type="text" name="collumn[]" class="form-control" id="InputCollumn1" placeholder="Enter collumn value">
                    <label for="InputType1">Collumn type: </label>
                    <select name="collumnType[]">
                        <option value="1">Unique</option>
                        <option value="2">Multiple</option>
                        <option value="3">Open</option>
                        <option value="4">Ordering</option>
                        <option value="5">Grade</option>
                    </select>
                    <label for="InputStatement1">Collumn statement: </label>
                    <textarea name="collumnStatement[]" class="form-control" id="InputStatement1" placeholder="Enter question statement" rows="8" cols="80"></textarea>
                    <div class="form-group">
                        <label for="CollumnOption1">Option value: </label>
                        <input type="text" name="collumnOption0[]" class="form-control" id="CollumnOption1" placeholder="Enter option value">
                    </div>
                    <div class="form-group">
                        <label for="CollumnOption2">Option value: </label>
                        <input type="text" name="collumnOption0[]" class="form-control" id="CollumnOption2" placeholder="Enter option value">
                    </div>
                    <div class="form-group">
                        <label for="CollumnOption3">Option value: </label>
                        <input type="text" name="collumnOption0[]" class="form-control" id="CollumnOption3" placeholder="Enter option value">
                    </div>
                    <div class="form-group">
                        <label for="CollumnOption4">Option value: </label>
                        <input type="text" name="collumnOption0[]" class="form-control" id="CollumnOption4" placeholder="Enter option value">
                    </div>
                    <div class="form-group">
                        <label for="CollumnOption5">Option value: </label>
                        <input type="text" name="collumnOption0[]" class="form-control" id="CollumnOption5" placeholder="Enter option value">
                    </div>
                    <div class="form-group">
                        <label for="CollumnOption6">Option value: </label>
                        <input type="text" name="collumnOption0[]" class="form-control" id="CollumnOption6" placeholder="Enter option value">
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputCollumn1">Collumn value: </label>
                    <input type="text" name="collumn[]" class="form-control" id="InputCollumn1" placeholder="Enter collumn value">
                    <label for="InputType1">Collumn type: </label>
                    <select name="collumnType[]">
                        <option value="1">Unique</option>
                        <option value="2">Multiple</option>
                        <option value="3">Open</option>
                        <option value="4">Ordering</option>
                        <option value="5">Grade</option>
                    </select>
                    <label for="InputStatement1">Collumn statement: </label>
                    <textarea name="collumnStatement[]" class="form-control" id="InputStatement1" placeholder="Enter question statement" rows="8" cols="80"></textarea>
                </div>
                <div class="form-group">
                    <label for="InputCollumn1">Collumn value: </label>
                    <input type="text" name="collumn[]" class="form-control" id="InputCollumn1" placeholder="Enter collumn value">
                    <label for="InputType1">Collumn type: </label>
                    <select name="collumnType[]">
                        <option value="1">Unique</option>
                        <option value="2">Multiple</option>
                        <option value="3">Open</option>
                        <option value="4">Ordering</option>
                        <option value="5">Grade</option>
                    </select>
                    <label for="InputStatement1">Collumn statement: </label>
                    <textarea name="collumnStatement[]" class="form-control" id="InputStatement1" placeholder="Enter question statement" rows="8" cols="80"></textarea>
                </div>
                <div class="form-group">
                    <label for="InputCollumn1">Collumn value: </label>
                    <input type="text" name="collumn[]" class="form-control" id="InputCollumn1" placeholder="Enter collumn value">
                    <label for="InputType1">Collumn type: </label>
                    <select name="collumnType[]">
                        <option value="1">Unique</option>
                        <option value="2">Multiple</option>
                        <option value="3">Open</option>
                        <option value="4">Ordering</option>
                        <option value="5">Grade</option>
                    </select>
                    <label for="InputStatement1">Collumn statement: </label>
                    <textarea name="collumnStatement[]" class="form-control" id="InputStatement1" placeholder="Enter question statement" rows="8" cols="80"></textarea>
                </div>
                <div class="form-group">
                    <label for="InputCollumn1">Collumn value: </label>
                    <input type="text" name="collumn[]" class="form-control" id="InputCollumn1" placeholder="Enter collumn value">
                    <label for="InputType1">Collumn type: </label>
                    <select name="collumnType[]">
                        <option value="1">Unique</option>
                        <option value="2">Multiple</option>
                        <option value="3">Open</option>
                        <option value="4">Ordering</option>
                        <option value="5">Grade</option>
                    </select>
                    <label for="InputStatement1">Collumn statement: </label>
                    <textarea name="collumnStatement[]" class="form-control" id="InputStatement1" placeholder="Enter question statement" rows="8" cols="80"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>

            </form>
        </div>
    </div>
</div>
@endsection
