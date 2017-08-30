@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <form class="form" action="{{ route('survey.store') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="InputName">Survey name: </label>
                    <input type="text" name="name" class="form-control" id="inputName" aria-describedby="nameHelp" placeholder="Enter survey name">
                    <small id="nameHelp" class="form-text text-muted">Insert a unique name to the survey.</small>
                </div>
                <div class="form-group">
                    <label for="InputInitData">Initial date: </label>
                    <input type="date" name="init_at" class="form-control" id="InputInitData" placeholder="Initial date">
                </div>
                <div class="form-group">
                    <label for="InputEndData">End date: </label>
                    <input type="date" name="end_at" class="form-control" id="InputEndData" placeholder="End date">
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" name="active" value="1" class="form-check-input">
                        Active
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>

            </form>
        </div>
    </div>
</div>
@endsection
