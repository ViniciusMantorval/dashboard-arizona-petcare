@extends('layouts.app')
@section('titulo', 'Painel')

@section('conteudo')
<div class="page-head">
  <div>
    <h1>Painel</h1>
    <p class="sub">Resumo do seu perfil profissional.</p>
  </div>
</div>

<section class="welcome-care" aria-labelledby="welcome-title">
  <div class="welcome-copy">
    <p class="eyebrow">NA COMPANHIA DO CUIDADO</p>
    <h2 id="welcome-title">Olá, {{ \Illuminate\Support\Str::before(auth()->user()->name, ' ') }}.</h2>
    <p>A agenda em dia. O cuidado sempre por perto.</p>
  </div>
  <div class="welcome-pets" aria-hidden="true">
    <span class="welcome-orbit"></span>
    <img class="welcome-dog" src="{{ asset('assets/img/pets/dog.svg') }}" alt="" width="260" height="260">
    <img class="welcome-cat" src="{{ asset('assets/img/pets/cat.svg') }}" alt="" width="200" height="150">
    <span class="welcome-star">✧</span>
  </div>
</section>

<div class="grid-2">
  <section class="card pet-resumo" aria-label="Seu perfil profissional">
    <span class="avatar avatar-grande" aria-hidden="true">{{ auth()->user()->iniciais }}</span>
    <dl>
      <div><dt>Nome</dt><dd>{{ $funcionario->nm_funcionario }}</dd></div>
      <div><dt>E-mail</dt><dd>{{ auth()->user()->email }}</dd></div>
      <div><dt>CRMV</dt><dd>{{ $funcionario->cd_crmv_funcionario ?: '—' }}</dd></div>
      <div><dt>Especialidade</dt><dd>{{ $funcionario->nm_especialidade_funcionario ?: '—' }}</dd></div>
    </dl>
  </section>

  <section class="card" aria-labelledby="clinica-titulo">
    <div class="card-head">
      <h2 id="clinica-titulo">Sua clínica</h2>
    </div>
    @if ($funcionario->clinica)
      <p><strong>{{ $funcionario->clinica->nome }}</strong></p>
    @else
      <p class="vazio">Você ainda não está vinculado a uma clínica.</p>
      <p class="dica">Sua conta está ativa e você pode acessar este painel normalmente.</p>
    @endif
  </section>
</div>
@endsection