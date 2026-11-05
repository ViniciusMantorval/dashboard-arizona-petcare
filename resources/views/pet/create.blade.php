<?php
    $tutor = $tutore;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Tutor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-600">
    <form class="flex flex-col bg-white p-6 rounded-2xl gap-1.5" action="{{ route("tutores.pets.store",$tutor) }}" method="post">
        @csrf
        <label for="nome">Nome:</label>
        <input type="text" name="nome">

        <label for="especie">Especie:</label>
        <input type="text" name="especie">

        <label for="raca">Raça:</label>
        <input type="text" name="raca">

        <label for="peso">Peso em quilos</label>
        <input type="text" name="peso">

        <button type="submit">cadastrar</button>
    </form>
</body>
</html>