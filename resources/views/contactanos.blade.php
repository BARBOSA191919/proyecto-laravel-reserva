<!DOCTYPE html>
<html>
<head>
    <title>Contáctanos</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/bienvenida.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans:ital,wght@1,700&display=swap" rel="stylesheet">
    </head>
    <body class="principal">
    <header class="encabezado">
    <a href="/"><img class="logotipo" src="{{ asset('img/logotipo.png') }}" alt="logo"></a>
        <img class="carrito" src="{{ asset('img/carrito.png') }}">
        <a class="texto-principal1" href="{{ route('contactanos') }}">Contáctanos</a>
        @auth
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit">Cerrar Sesión</button>
            </form>
        @else
            <a href="{{ route('login') }}"><button>Iniciar Sesión</button></a>
            <a href="{{ route('register') }}"><button>Registrarte</button></a>
        @endauth
    </header>

    <div>
        <h2>Contáctanos</h2>
        <p>Estamos aquí para ayudarte. ¡Envíanos un mensaje!</p>
        <!-- Puedes añadir un formulario de contacto aquí -->
    </div>
</body>
</html>
