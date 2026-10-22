<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tutor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-600">
    <form class="flex flex-col bg-white p-6 rounded-2xl gap-1.5" action="{{ route("tutores.update",$tutor->id_tutor) }}" method="post">
        @csrf
        @method('PUT')

        <label for="nome">Nome:{{ $tutor->nm_tutor }}</label>
        <input type="text" name="nome" value="{{ $tutor->nm_tutor }}">

        <label for="email">email:</label>
        <input type="email" name="email" value="{{ $tutor->nm_email_tutor }}">

        <label for="endereco">endereço:</label>
        <input type="text" name="endereco" value="{{ $tutor->nm_endereco_tutor }}">

        <label for="endereco">telefone (padrão: (00) 1111-11110):</label>
        <input type="tel" name="telefone" value="{{ $tutor->cd_telefone_tutor }}">

        <label for="endereco">CPF:</label>
        <input type="text" name="cpf" value="{{ $tutor->cd_cpf_tutor }}">

        <button type="submit">Atualizar</button>
    </form>
</body>
</html>