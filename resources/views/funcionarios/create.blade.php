@extends('layouts.app')

@section('conteudo')

<h1>Novo funcionário</h1>

@if($errors->any())
<ul class="text-red">

    @foreach($errors->all() as $erro)
        <li> {{ $erro }}</li>
    @endforeach
</ul>
@endif

<form action="{{ route('funcionario.store') }}" method="POST">
@csrf


<p>
    <label for="nm_funcionario">Nome</label>
    <input type="text" name="nm_funcionario" id="nm_funcionario" value="{{ old('nm_funcionario') }}">
</p>


<p>
    <label for="nm_email_funcionario">Email</label>
    <input type="text" name="nm_email_funcionario" id="nm_email_funcionario" value="{{ old('nm_email_funcionario') }}">
</p>

<p>
    <label for="cd_cpf_funcionario">CPF</label>
    <input type="text" name="cd_cpf_funcionario" id="cd_cpf_funcionario" value="{{ old('cd_cpf_funcionario') }}">
</p>

<p>
    <label for="cd_telefone_funcionario">Telefone</label>
    <input type="text" name="cd_telefone_funcionario" id="cd_telefone_funcionario" value="{{ old('cd_telefone_funcionario') }}">
</p>
<p>
    <label for="nm_especialidade_funcionario">Especialidade</label>
    <input type="text" name="nm_especialidade_funcionario" id="nm_especialidade_funcionario" value="{{ old('nm_especialidade_funcionario') }}">
</p>

<button type="submit">Enviar</button>
<a href="{{ route('funcionarios.index') }}">Volte ao Index!</a>
</form>