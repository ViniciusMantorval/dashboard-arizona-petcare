@extends('layouts.auth')
@section('titulo', 'Entrar')

@section('conteudo')
<img class="auth-logo" src="{{ asset('assets/img/logo-marrom.png') }}" alt="Arizona Pet Care" width="150" height="54">
<h1>Entrar</h1>
<p class="sub">Acesse o painel como {{ config('painel.perfis')[$perfil] ?? $perfil }}.</p>

<form class="form" method="POST" action="{{ route('login.store', $perfil) }}">
  @csrf
  <div class="campo">
    <label for="email">E-mail</label>
    <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username">
    @error('email')<small class="erro">{{ $message }}</small>@enderror
  </div>
  <div class="campo">
    <label for="password">Senha</label>
    <input id="password" name="password" type="password" required autocomplete="current-password">
    @error('password')<small class="erro">{{ $message }}</small>@enderror
  </div>
  <button class="btn btn-primario btn-bloco" type="submit">Entrar</button>
</form>

<p class="divisor"><span>ou</span></p>
<a class="btn btn-secundario btn-bloco" href="{{ route('register', $perfil) }}">Criar conta</a>
<a class="link" href="{{ route('login') }}">Escolher outro perfil</a>
@endsection