<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutores</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <form id="filtro-tutores" method="GET" action="{{ route('tutores.index') }}" class="flex flex-wrap gap-2 p-4 bg-purple-100 rounded-2xl mb-4" autocomplete="off">
        <input type="text" name="nome" value="{{ request('nome') }}" placeholder="Nome do tutor">
        <input type="text" name="cpf" value="{{ request('cpf') }}" placeholder="CPF">
        <input type="text" name="email" value="{{ request('email') }}" placeholder="E-mail">
        <input type="text" name="pet" value="{{ request('pet') }}" placeholder="Nome do pet">
        <button type="button" id="limpar-filtro">Limpar</button>
    </form>
    <div id="lista-tutores">
    @if(isset($tutores))
    @include('tutor._lista')
    @else
    <h1>Erro, sem nenhum tutor</h1>
    @endif
    </div>
    <a href="{{ route('tutores.create') }}">adicionar um tutor</a>
</body>
</html>
