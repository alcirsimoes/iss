@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <form class="form" action="{{ route('sample.store') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="InputName">Sample name: </label>
                    <input type="text" name="name" class="form-control" id="inputName" aria-describedby="nameHelp" placeholder="Enter sample name">
                    <small id="nameHelp" class="form-text text-muted">Insert a unique name to the sample.</small>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>

            </form>
        </div>
    </div>
</div>
@endsection
