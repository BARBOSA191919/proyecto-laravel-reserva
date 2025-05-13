<!DOCTYPE html>
<html>
<head>
    <title>Gestor de Eventos</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans:ital,wght@1,700&display=swap" rel="stylesheet">

</head>
<body class="principal">
    <header class="encabezado">
    <a href="{{ route('bienvenida') }}"><img class="logotipo" src="{{ asset('img/logotipo.png') }}" alt="logo"><a>

        <a class="texto-principal">Conciertos</a>
        <a class="texto-principal">Teatro</a>
        <a class="texto-principal">Deportes</a>
        <a class="texto-principal">Más <div class="triangulo"></div></a>
        <img class="carrito" src="{{ asset('img/carrito.png') }}">
        <a class="texto-principal1">Contáctanos</a>
        <a><img class="perfil" src="{{ asset('img/perfil.png') }}"></a>
        
    </header>

    <div class="fondo">
    <div class="login-header">
            <h1>¡HOLA! BIENVENIDO A TU RESERVAYA</h1>
            <p>INICIA SESIÓN PARA COMPRAR ENTRADAS O DESCARGARLAS DESDE TU CUENTA PERSONAL (INGRESA EL EMAIL Y CONTRASEÑA CON LOS QUE HICISTE LA COMPRA)</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>

            <div class="remember-me">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Sigue conectado</label>
            </div>

            <div class="forgot-password">
                <a href="{{ route('password.request') }}">¿Olvidaste la contraseña?</a>
            </div>

            <button type="submit">CONTINUA</button>

            <div class="create-account">
                <a href="{{ route('register') }}">Crea una cuenta nueva</a>
            </div>
        </form>
    </div>
    </div>
    
</body>
</html>