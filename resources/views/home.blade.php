@extends('layouts.app')
@section('conteudo')
<section class="hero"><p class="eyebrow">Cuidado que começa com organização</p>
<h1>Um espaço para cuidar<br>de quem cuida.</h1>
<p>Acesse sua área para acompanhar sua rotina na clínica.</p>
@auth
<a class="button" href="{{ route('dashboard') }}">Acessar meu painel</a>
@else
<div class="cards">
<article class="card"><span class="tag">Equipe</span><h2>Sou funcionário</h2><p>Entre com seu e-mail e senha ou crie sua conta profissional.</p><a class="button" href="{{ route('login.perfil', 'funcionario') }}">Entrar como funcionário</a><a href="{{ route('register', 'funcionario') }}">Cadastrar funcionário</a></article>
<article class="card"><span class="tag">Gestão</span><h2>Sou dono de clínica</h2><p>Reúna suas clínicas em um só lugar e acompanhe seus cadastros.</p><a class="button" href="{{ route('login.perfil', 'dono') }}">Entrar como dono</a><a href="{{ route('register', 'dono') }}">Cadastrar dono e clínica</a></article>
</div>
@endauth
</section>
@endsection

