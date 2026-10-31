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
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($funcionarios as $funcionario)
                <tr>
                    <td>{{ $funcionario->id_funcionario }}</td>
                    <td>{{ $funcionario->nm_funcionario }}</td>
                    <td>{{ $funcionario->nm_email_funcionario }}</td>
                    <td>{{ $funcionario->nm_especialidade_funcionario }}</td>
                    <td>
                        <a href="{{ route('funcionarios.edit', $funcionario) }}">Editar</a>

                        <form action="{{ route('funcionarios.destroy', $funcionario) }}" method="POST"
                              style="display:inline"
                              onsubmit="return confirm('Tem certeza que deseja excluir?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Nenhum funcionário cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection