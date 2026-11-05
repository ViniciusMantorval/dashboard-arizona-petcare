<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pets</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div>
        @foreach ($pets as $pet)
            <div>
                <a href="{{ route("pets.show",$pet->id_pet) }}">{{ $pet->nm_pet }}</a>
                <p>{{ $pet->nm_especie_pet }}</p>
                <p>{{ $pet->nm_raca_pet }}</p>
                <p>{{ $pet->qt_peso_pet }}</p>
                <a href="{{ route('pets.edit',$pet->id_pet) }}">Editar</a>
                <form method="post" action="{{ route('pets.destroy',$pet->id_pet) }}">
                    @csrf
                    @method("DELETE")
                    <button type="submit">Remover</button>
                </form>
            </div>
            <br>
        @endforeach
    </div>
    <a href="{{ route('tutores.index') }}">Voltar aos Tutores</a>
</body>
</html>
