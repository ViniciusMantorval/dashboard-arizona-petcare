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
                <p>{{ $tutor->nm_tutor }}</p>
                <p>{{ $tutor->nm_email_tutor }}</p>
                <p>{{ $tutor->nm_endereco_tutor }}</p>
                <p>{{ $tutor->cd_telefone_tutor }}</p>
                <p>{{ $tutor->cd_cpf_tutor }}</p>
                <a href="{{ route('tutores.edit',$tutor->id_tutor) }}">Editar</a>
            </div>
    </div>
    <a href="{{ route('tutores.index') }}">Mostrar todos os Tutores</a>
</body>
</html>
