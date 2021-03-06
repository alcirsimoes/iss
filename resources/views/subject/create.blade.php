@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if($subject->id)
            <form class="form" action="{{ route('subject.update', $subject->id) }}" method="post">
                {{ method_field('PUT') }}
            @else
            <form class="form" action="{{ route('subject.store') }}" method="post">
            @endif
                {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="sample_id" value="{{ $sample->id }}">
                <input type="hidden" name="redirect" value="{{ request('r') }}">

                <div class="form-group">
                    <label for="InputName">Nome: </label>
                    <input type="text" name="name" class="form-control" id="inputName" aria-describedby="nameHelp" placeholder="Enter subject name" value="{{ $subject->name }}">
                    <small id="nameHelp" class="form-text text-muted">Insert a unique name to the subject.</small>
                </div>
                <div class="form-group">
                    <label for="InputName">Email: </label>
                    <input type="email" name="email" class="form-control" id="inputName" aria-describedby="emailHelp" placeholder="Enter subject email" value="{{ $subject->email }}">
                    <small id="nameHelp" class="form-text text-muted">Insert a unique email to the subject.</small>
                </div>
                <div class="form-group">
                    <label for="">Empresa: </label>
                    <input type="text" name="company" class="form-control" id="" aria-describedby="nameHelp" placeholder="Enter subject company" value="{{ $subject->company }}">
                    <small id="nameHelp" class="form-text text-muted">Empresa do respondente.</small>
                </div>
                <!-- <div class="form-group">
                    <label for="">Endereço: </label>
                    <input type="text" name="address" class="form-control" id="" aria-describedby="nameHelp" placeholder="Enter subject address">
                    <small id="nameHelp" class="form-text text-muted">Endereço do respondente.</small>
                </div>
                <div class="form-group">
                    <label for="">Estado: </label>
                    <input type="text" name="state" class="form-control" id="" aria-describedby="nameHelp" placeholder="Enter subject state">
                    <small id="nameHelp" class="form-text text-muted">Estado do respondente.</small>
                </div>
                <div class="form-group">
                    <label for="">Cidade: </label>
                    <input type="text" name="city" class="form-control" id="" aria-describedby="nameHelp" placeholder="Enter subject city">
                    <small id="nameHelp" class="form-text text-muted">Cidade do respondente.</small>
                </div> -->
                <div class="form-group">
                    <label for="">Cargo: </label>
                    <input type="text" name="ocupation" class="form-control" id="" aria-describedby="nameHelp" placeholder="Enter subject ocupation" value="{{ $subject->ocupation }}">
                    <small id="nameHelp" class="form-text text-muted">Cargo do respondente.</small>
                </div>
                <div class="form-group">
                    <label for="">Telefone: </label>
                    <input type="text" name="telephone" class="form-control" id="" aria-describedby="nameHelp" placeholder="Enter subject telephone" value="{{ $subject->telephone }}">
                    <small id="nameHelp" class="form-text text-muted">Telefone do respondente.</small>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>

            </form>
        </div>
    </div>
</div>
@endsection
