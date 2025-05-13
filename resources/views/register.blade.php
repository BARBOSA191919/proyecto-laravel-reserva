<!DOCTYPE html>
<html>
<head>
    <title>Gestor de Eventos</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans:ital,wght@1,700&display=swap" rel="stylesheet">
    <script src="{{ asset('js/bienvenida.js') }}"></script>

</head>
<header class="encabezado">
       <a href="{{ route('bienvenida') }}"><img class="logotipo" src="{{ asset('img/logotipo.png') }}" alt="logo"></a>
        <img class="carrito" src="{{ asset('img/carrito.png') }}" onclick="window.location.href='{{ route('register') }}'">
        
        @auth
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit">Cerrar Sesión</button>
            </form>
        @else
            <button class="sesion" onclick="window.location.href='{{ route('login') }}'">Iniciar Sesión</button>
            <button class="registrate" onclick="window.location.href='{{ route('register') }}'">Registrarte</button>
        @endauth
    </header>

    <div class="contenedor">
        <h1>REGÍSTRATE</h1>

        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            <ul class="error">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <label for="name">Nombre de usuario:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>

            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>

            <label for="celular">Celular (opcional):</label>
            <input type="text" name="celular" id="celular" value="{{ old('celular') }}">

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>

            <label for="password_confirmation">Confirmar contraseña:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>

            <label>Selecciona tu rol:</label>
            <div>
                <input type="radio" name="role" id="organizador" value="organizador" {{ old('role') == 'organizador' ? 'checked' : '' }} required>
                <label for="organizador">Organizador</label>
                <input type="radio" name="role" id="cliente" value="cliente" {{ old('role') == 'cliente' ? 'checked' : '' }} required>
                <label for="cliente">Cliente</label>
            </div>

            <button type="submit">Registrarte</button>
        </form>
    </div>
    
</body>
</html>