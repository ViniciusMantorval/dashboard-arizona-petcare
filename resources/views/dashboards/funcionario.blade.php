@extends('layouts.app')
@section('conteudo')
<p class="eyebrow">Painel do funcionário</p><h1>Olá, {{ auth()->user()->name }}.</h1>
<div class="cards"><section class="card"><h2>Seu perfil profissional</h2><dl>
<dt>E-mail</dt><dd>{{ auth()->user()->email }}</dd>
<dt>CRMV</dt><dd>{{ $funcionario->crmv }}</dd>
<dt>Especialidade</dt><dd>{{ $funcionario->nm_especialidade_funcionario }}</dd>
</dl></section>
<section class="card"><h2>Sua clínica</h2>
@if($funcionario->clinica)<p>{{ $funcionario->clinica->nome }}</p>
@else<p>Você ainda não está vinculado a uma clínica.</p><p class="hint">Sua conta está ativa e você pode acessar este painel normalmente.</p>@endif
</section></div>
@endsection

