@extends('layouts.app')
@section('conteudo')
<section class="panel"><p class="eyebrow">Novo cadastro</p>
<h1>{{ $perfil === 'dono' ? 'Dono de clínica' : 'Funcionário' }}</h1>
<form class="stack" action="{{ route('register.store', $perfil) }}" method="POST">
@csrf
<label for="name">Seu nome</label><input id="name" name="name" value="{{ old('name') }}" required maxlength="255" autocomplete="name">
<label for="email">E-mail</label><input id="email" name="email" type="email" value="{{ old('email') }}" required maxlength="255" autocomplete="email">
@if($perfil === 'funcionario')
<label for="crmv">CRMV</label><input id="crmv" name="crmv" value="{{ old('crmv') }}" required maxlength="255">
<label for="cd_cpf_funcionario">CPF (somente números)</label><input id="cd_cpf_funcionario" name="cd_cpf_funcionario" value="{{ old('cd_cpf_funcionario') }}" required inputmode="numeric" pattern="[0-9]{11}" maxlength="11">
<label for="cd_telefone_funcionario">Telefone com DDD (11 dígitos)</label><input id="cd_telefone_funcionario" name="cd_telefone_funcionario" value="{{ old('cd_telefone_funcionario') }}" required inputmode="tel" pattern="[0-9]{11}" maxlength="11">
<label for="nm_especialidade_funcionario">Especialidade</label><input id="nm_especialidade_funcionario" name="nm_especialidade_funcionario" value="{{ old('nm_especialidade_funcionario') }}" required maxlength="255">
<label for="clinica_id">Clínica (opcional)</label><select name="clinica_id" id="clinica_id"><option value="">Sem vínculo com clínica</option>
@foreach($clinicas as $clinica)<option value="{{ $clinica->id }}" @selected(old('clinica_id') == $clinica->id)>{{ $clinica->nome }}</option>@endforeach
</select>
@else
<label for="nome_clinica">Nome da primeira clínica</label><input id="nome_clinica" name="nome_clinica" value="{{ old('nome_clinica') }}" required maxlength="255">
<p class="hint">Você será o responsável. Outras clínicas poderão ser cadastradas no seu painel.</p>
@endif
<label for="password">Senha (mínimo de 8 caracteres)</label><input id="password" name="password" type="password" required minlength="8" maxlength="72" autocomplete="new-password">
<label for="password_confirmation">Confirmar senha</label><input id="password_confirmation" name="password_confirmation" type="password" required minlength="8" maxlength="72" autocomplete="new-password">
<button type="submit">Criar conta</button>
</form>
<p>Já tem conta? <a href="{{ route('login.perfil', $perfil) }}">Entrar</a></p></section>
@endsection

