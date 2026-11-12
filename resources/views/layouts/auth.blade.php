<!DOCTYPE html>
<html lang="pt-BR">
<head>
    @include('partials.head')
</head>
<body class="auth">
<main id="conteudo" class="auth-card">
    @if (session('success'))
        <div class="alerta alerta-sucesso" role="status">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alerta alerta-erro" role="alert">{{ session('error') }}</div>
    @endif

    @yield('conteudo')
</main>

</body>
</html>