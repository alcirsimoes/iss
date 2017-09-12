@extends('layouts.app')

@section('content')
<div class="container">
    <h2>MUITO OBRIGADO(A) PELA SUA PARTICIPAÇÃO, SUAS INFORMAÇÕES FORAM MUITO IMPORTANTES PARA A MELHORIA DOS PRODUTOS E SERVIÇOS OFERECIDOS PELA KRONES.</h2>

    <h3>Pesquisa Finalizada em {{ $finish }}</h3>

    <a href="{{ route('form.index', $survey->id) }}" class="btn btn-primary">Ir para pesquisa</a>
</div>
@endsection
