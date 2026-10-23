<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutores</title>
</head>
<body>
    <div>
        @foreach ($tutores as $tutor)
            <div>
                <p>{{ $tutor->nm_tutor }}</p>
                <p>{{ $tutor->nm_email_tutor }}</p>
                <p>{{ $tutor->nm_endereco_tutor }}</p>
                <p>{{ $tutor->cd_telefone_tutor }}</p>
                <p>{{ $tutor->cd_cpf_tutor }}</p>
                <a href="{{ route('tutores.edit',$tutor->id_tutor) }}">Editar</a>
                <form method="post" action="{{ route('tutores.destroy',$tutor->id_tutor) }}">
                    @csrf
                    @method("DELETE")
                    <button type="submit">Remover</button>
                </form>
            </div>
            <br>
        @endforeach
    </div>
    <a href="{{ route('tutores.create') }}">adicionar um tutor</a>
</body>
</html>
