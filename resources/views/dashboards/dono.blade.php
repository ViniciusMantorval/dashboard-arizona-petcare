@extends('layouts.app')
@section('conteudo')
<p class="eyebrow">Painel do dono de clínica</p><h1>Olá, {{ auth()->user()->name }}.</h1>
<p>Gerencie as clínicas pelas quais você é responsável.</p>
<div class="cards"><section class="card"><h2>Minhas clínicas</h2>
@forelse($clinicas as $clinica)
<article class="clinic"><h3>{{ $clinica->nome }}</h3><p>Responsável: {{ auth()->user()->name }}</p><small>{{ $clinica->funcionarios_count }} funcionário(s) vinculado(s)</small></article>
@empty<p>Você ainda não tem clínicas cadastradas.</p>@endforelse
</section>
<section class="card"><h2>Adicionar clínica</h2><form class="stack" action="{{ route('clinicas.store') }}" method="POST">@csrf
<label for="nome">Nome da clínica</label><input id="nome" name="nome" value="{{ old('nome') }}" required maxlength="255">
<button type="submit">Cadastrar clínica</button></form></section></div>
@endsection

