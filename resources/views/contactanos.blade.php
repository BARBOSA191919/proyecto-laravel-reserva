<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contáctanos</title>
    <link rel="stylesheet" href="{{ asset('css/contactanos.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans:ital,wght@1,700&display=swap" rel="stylesheet">
</head>
<body class="principal">
    <header class="encabezado">
        <a href="{{ route('bienvenida') }}"><img class="logotipo" src="{{ asset('img/logotipo.png') }}" alt="Logo"></a>
        <nav class="nav-links">
            <a href="{{ route('categorias.conciertos') }}">Conciertos</a>
            <a href="{{ route('categorias.deportes') }}">Deportes</a>
            <a href="{{ route('categorias.experiencias') }}">Experiencias</a>
            <a href="{{ route('bienvenida') }}">Todos los eventos</a>
            <a href="{{ route('contactanos') }}" class="texto-principal1">Contáctanos</a>
        </nav>
        <div class="auth-links">
            <a href="{{ route('carrito.obtener') }}"><img class="carrito" src="{{ asset('img/carrito.png') }}" alt="Carrito"></a>
            @auth
                <form action="{{ route('logout') }}" method="POST" class="auth-form">
                    @csrf
                    <button type="submit" class="boton-auth">Cerrar Sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}"><button class="boton-auth">Iniciar Sesión</button></a>
                <a href="{{ route('register') }}"><button class="boton-auth">Registrarte</button></a>
            @endauth
        </div>
    </header>

    <div class="container">
        <h2><i class="fas fa-envelope"></i> Contáctanos</h2>
        <p>Estamos aquí para ayudarte. ¡Envíanos un mensaje a <a href="mailto:info@eventos.com" class="contact-link">info@eventos.com</a>!</p>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h4>Sobre Nosotros</h4>
                <p>Explora los mejores eventos en nuestra plataforma. ¡Vive experiencias únicas!</p>
            </div>
            <div class="footer-section">
                <h4>Enlaces Rápidos</h4>
                <ul>
                    <li><a href="{{ route('bienvenida') }}">Todos los eventos</a></li>
                    <li><a href="{{ route('categorias.conciertos') }}">Conciertos</a></li>
                    <li><a href="{{ route('categorias.deportes') }}">Deportes</a></li>
                    <li><a href="{{ route('contactanos') }}">Contacto</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contacto</h4>
                <ul>
                    <li>Email: info@eventos.com</li>
                    <li>Teléfono: +34 912 345 678</li>
                    <li>Dirección: Av. Principal 123, Madrid</li>
                </ul>
            </div>
        </div>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
        <div class="copyright">
            © {{ date('Y') }} Plataforma de Eventos. Todos los derechos reservados.
        </div>
    </footer>
</body>
</html>