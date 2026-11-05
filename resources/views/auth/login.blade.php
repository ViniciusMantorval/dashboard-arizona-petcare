@extends('layouts.app')
@section('conteudo')
<section class="panel"><p class="eyebrow">{{ $perfil === 'dono' ? 'Área do dono' : 'Área do funcionário' }}</p>
<h1>Entrar na sua conta</h1>
<form class="stack" action="{{ route('login.store', $perfil) }}" method="POST">
@csrf
<label for="email">E-mail</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" autofocus>
<label for="password">Senha</label><input id="password" name="password" type="password" required autocomplete="current-password">
<button type="submit">Entrar</button>
</form>
<p>Ainda não tem conta? <a href="{{ route('register', $perfil) }}">Cadastre-se</a></p>
<a href="{{ route('login') }}">Escolher outro perfil</a></section>
@endsection

