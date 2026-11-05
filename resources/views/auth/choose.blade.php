@extends('layouts.app')
@section('conteudo')
<section class="panel"><p class="eyebrow">Bem-vindo</p><h1>Como você deseja entrar?</h1>
<div class="stack"><a class="button" href="{{ route('login.perfil', 'funcionario') }}">Sou funcionário</a>
<a class="button" href="{{ route('login.perfil', 'dono') }}">Sou dono de clínica</a></div></section>
@endsection

