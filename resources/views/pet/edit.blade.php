<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tutor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-600">
    <form class="flex flex-col bg-white p-6 rounded-2xl gap-1.5" action="{{ route("pets.update",$pet->id_pet) }}" method="post">
        @csrf
        @method('PUT')
        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="{{ $pet->nm_pet }}">

        <label for="especie">Especie:</label>
        <input type="text" name="especie" value="{{ $pet->nm_especie_pet }}">

        <label for="raca">Raça:</label>
        <input type="text" name="raca" value="{{ $pet->nm_raca_pet }}">

        <label for="peso">Peso em quilos</label>
        <input type="text" name="peso" value="{{ $pet->nm_raca_pet }}">

        <button type="submit">Atualizar</button>
    </form>
</body>
</html>