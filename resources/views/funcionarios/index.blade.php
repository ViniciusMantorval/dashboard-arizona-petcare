@extends('layouts.app')

@section('conteudo')
    <h1>Funcionários</h1>

    <a href="{{ route('funcionarios.create') }}">Novo funcionário</a>

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Especialidade</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($funcionarios as $funcionario)
                <tr>
                    <td>{{ $funcionario->id_funcionario }}</td>
                    <td>{{ $funcionario->nm_funcionario }}</td>
                    <td>{{ $funcionario->nm_email_funcionario }}</td>
                    <td>{{ $funcionario->nm_especialidade_funcionario }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Nenhum funcionário cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection