<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutores</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div>
            <div>
                <h1>{{ $pet->nm_pet }}</h1> 
                <h1>{{ $pet->nm_especie_pet }}</h1> 
                <h1>{{ $pet->nm_raca_pet }}</h1> 
                <h1>{{ $pet->qt_peso_pet }}</h1> 
                <a href="{{ route('pets.edit',$pet->id_pet) }}">Editar</a>
            </div>
    </div>
    <a href="{{ route('tutores.index') }}">Mostrar todos os Tutores</a>
</body>
</html>
