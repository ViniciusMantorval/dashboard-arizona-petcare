<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Arizona Petcare' }}</title>
    <link rel="stylesheet" href="{{ asset('css/portal.css') }}">
</head>
<body>
<header><a class="brand" href="{{ route('home') }}">Arizona <span>Petcare</span></a>
<nav aria-label="Navegação principal">
@auth
    <a href="{{ route('dashboard') }}">Meu painel</a>
    <form action="{{ route('logout') }}" method="POST">@csrf<button class="secondary" type="submit">Sair</button></form>
@else
    <a href="{{ route('login') }}">Entrar</a>
@endauth
</nav></header>
<main>
    @if(session('success'))<p class="notice" role="status">{{ session('success') }}</p>@endif
    @if($errors->any())
        <div class="errors" role="alert"><strong>Confira os dados informados:</strong><ul>
        @foreach($errors->all() as $erro)<li>{{ $erro }}</li>@endforeach
        </ul></div>
    @endif
    @yield('conteudo')
</main>
<footer>Arizona Petcare · Gestão de clínicas veterinárias</footer>
</body>
</html>