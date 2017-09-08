@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <form class="form" action="{{ route('subject.store') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="sample_id" value="{{ $sample->id }}">
                <input type="hidden" name="redirect" value="{{ request('r') }}">
                <div class="form-group">
                    <label for="InputName">Name: </label>
                    <input type="text" name="name" class="form-control" id="inputName" aria-describedby="nameHelp" placeholder="Enter subject name">
                    <small id="nameHelp" class="form-text text-muted">Insert a unique name to the subject.</small>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>

            </form>
        </div>
    </div>
</div>
@endsection
