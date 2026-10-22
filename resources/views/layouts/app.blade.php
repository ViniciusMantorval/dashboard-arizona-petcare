<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{isset($title) ? $title . ' - Arizona Petcare' : 'Arizona Petcare' }}</title>
</head>
<body>
    <nav>
        <a href="{{ route('funcionarios.index') }}">Funcionários</a>
    </nav>

    <main>
        @if (session('success'))
            <p class="text-green">{{ session('success') }}</p>
        @endif

        @yield('conteudo')
    </main>
</body>
</html>