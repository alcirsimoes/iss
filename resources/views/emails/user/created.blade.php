@component('mail::message')
# Bem vindo

Você foi adicionado como novo membro no nosso portal de pesquisas.

- seu e-mail de acesso: {{ $user->email }}
- sua senha de acesso: {{ $pass }}

@component('mail::button', ['url' => route('home')])
Acesse aqui
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
