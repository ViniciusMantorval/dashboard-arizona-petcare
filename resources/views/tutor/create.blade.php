<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Tutor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-600">
    <form class="flex flex-col bg-white p-6 rounded-2xl gap-1.5" action="{{ route("tutores.store") }}" method="post">
        @csrf
        <label for="nome">nome:</label>
        <input type="text" name="nome">

        <label for="email">email:</label>
        <input type="email" name="email">

        <label for="endereco">endereço:</label>
        <input type="text" name="endereco">

        <label for="endereco">telefone (padrão: (00) 1111-11110):</label>
        <input type="tel" name="telefone">

        <label for="endereco">CPF:</label>
        <input type="text" name="cpf">

        <button type="submit">cadastrar</button>
    </form>
</body>
</html>