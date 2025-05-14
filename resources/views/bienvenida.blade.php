<!DOCTYPE html>
<html>
<head>
    <title>Bienvenida</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/bienvenida.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans:ital,wght@1,700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/bienvenida.js') }}" defer></script>
</head>
<body class="principal">
    <header class="encabezado">
        <a href="/" class="contenedor-logotipo"><img class="logotipo" src="{{ asset('img/logotipo.png') }}" alt="logo"></a>
        <a class="texto-principal" href="{{ route('categorias.conciertos') }}">Conciertos</a>
        <a class="texto-principal" href="{{ route('categorias.teatro') }}">Teatro</a>
        <a class="texto-principal" href="{{ route('categorias.deportes') }}">Deportes</a>
        <a class="texto-principal" href="#">Más <div class="triangulo"></div></a>
        <div class="carrito-container">
            @auth
            <a href="#" class="carrito">
                <img src="{{ asset('img/carrito.png') }}" class="carro2" alt="Carrito">
                <span id="carrito-contador" class="carrito-contador oculto">0</span>
            </a>
            
                <div id="menu-carrito" class="carrito-desplegable oculto">
                    <h3>Carrito de Compras</h3>
                    <div id="items-carrito">
                    </div>
                    <p id="total-carrito" class="carrito-total">Total: $0</p>
                    <button class="carrito-boton-comprar">Iniciar Compra</button>
                </div>
            @else
            <div class="carrito-no-interactivo">
                    <img src="{{ asset('img/carrito.png') }}" class="carro" alt="Carrito (Iniciar Sesión)">
            </div>
            @endauth
        </div>
            <div class="contenedor-perfil">
            <a href="{{ route('login') }}" class="perfil-link">
                <img class="perfil" src="{{ asset('img/perfil.png') }}" alt="Perfil">
            </a>
            @auth
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <a href="{{ route('logout') }}" class="cerrar-sesion"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                        Cerrar Sesión
                    </a>
                </form>
            @endauth
        </div>
  <div class="barra">
    <nav>
        <div class="menu-ciudades" id="botonCiudades">
            <img class="logosg" src="{{ asset('img/location.png') }}" alt="Ubicación">
            <h2 class="ciudad">Ciudad</h2>
            <div class="triangulo1" id="trianguloCiudades"></div>
            <div id="menuCiudades" class="contenido-ciudades oculto">
                <!-- Las ciudades se cargarán dinámicamente con JavaScript -->
            </div>
        </div>
                <div class="divisor">
                    <div class="menu-categorias" id="botonCategorias">
                        <img id="botonCategorias" class="logosg1" src="{{ asset('img/categoria.png') }}" alt="Categoría">
                        <h2 class="categoria">Categoria</h2>
                        <div class="triangulo2" id="miTriangulo"></div>
                        <div id="menuCategorias" class="contenido-categorias">
                            <a class="titulo-categorias" href="{{ route('categorias.conciertos') }}">Conciertos</a>
                            <a class="titulo-categorias" href="{{ route('categorias.deportes') }}">Deportes</a>
                            <a class="titulo-categorias" href="{{ route('categorias.experiencias') }}">Experiencias</a>
                            <a class="titulo-categorias" href="{{ route('categorias.familia') }}">Familia</a>
                            <a class="titulo-categorias" href="{{ route('categorias.festival') }}">Festival</a>
                            <a class="titulo-categorias" href="{{ route('categorias.forosseminarios') }}">Foros, Seminarios y Congresos</a>
                            <a class="titulo-categorias" href="{{ route('categorias.museoexposiciones') }}">Museos y Exposiciones</a>
                            <a class="titulo-categorias" href="{{ route('categorias.teatro') }}">Teatro</a>
                        </div>
                    </div>
                    
                    <div class="divisor2">
                        <img class="logosg3" src="{{ asset('img/calendario.png') }}" alt="Calendario">
                        <h2 class="fecha">Fecha</h2>
                        <div class="triangulo3"></div>
                        <div class="divisor3">
                            <form action="{{ route('eventos.buscar') }}" method="GET">
                                <input type="text" id="input-busqueda" class="buscador" name="query" placeholder="Buscar por evento, Artista...">
                                <img class="lupa" src="{{ asset('img/lupa1.png') }}" alt="Buscar">
                            </form>
                        </div>
                    </div>
                    <img id="icono-buscar" class="lupa2" src="{{ asset('img/lupa2.png') }}" alt="Buscar">
                </div>
            </nav>
        </div>
    </header>
    <div class="fondo">
       <center> <h2 class="titulo-destacados">DESTACADOS</h2></center>
        <div class="contenedor-destacados">
    @foreach ($eventos as $evento)
        <div class="evento-tarjeta">
            <a href="{{ route('comprar.evento', ['id' => $evento->id]) }}" style="text-decoration: none; color: inherit;">
                @if ($evento->imagen)
                    <img src="{{ asset('storage/' . $evento->imagen) }}" class="evento-tarjeta-img-top" alt="Imagen del evento" loading="lazy">
                @endif
                <div class="evento-info">
                    <div class="evento-texto">
                        <h2>{{ $evento->nombre }}</h2>
                        <p><strong>Lugar:</strong> {{ $evento->lugar }}</p>
                        <p><strong>Ciudad:</strong> {{ $evento->ciudad }}</p>
                    </div>
                    @php
                        $fecha = \Carbon\Carbon::parse($evento->fecha);
                    @endphp
                    <div class="fecha-lateral">
                        <div class="dia">{{ $fecha->format('d') }}</div>
                        <div class="mes">{{ strtoupper($fecha->format('M')) }}</div>
                        <div class="dia-semana">{{ strtoupper($fecha->format('D')) }}</div>
                    </div>
                </div>
            </a>
        </div>
            @endforeach
        </div>
    </div>
</div>
        <footer class="pie-pagina">
    <div class="footer-container">
        <!-- Logo y sección izquierda -->
        <div class="footer-logo-section">
            <div class="footer-logo">
                <img src="{{ asset('img/logotipo.png') }}" alt="ReservaYa">
            </div>

            <div class="footer-section">
               
                <p><img src="{{ asset('img/location.png') }}" alt="Ubicación" class="footer-icon">Calle 67B #2B-56</p>
                <p class="call-center">Call Center</p>
                <p><img src="{{ asset('img/phone.png') }}" alt="Teléfono" class="footer-icon">+57 3154588360</p>
            </div>

            <div class="footer-social">
                <a href="#" class="social-link"><img src="{{ asset('img/email.png') }}" alt="Email"></a>
                <a href="#" class="social-link"><img src="{{ asset('img/instagram.png') }}" alt="Instagram"></a>
                <a href="#" class="social-link"><img src="{{ asset('img/twitter.png') }}" alt="Twitter"></a>
                <a href="#" class="social-link"><img src="{{ asset('img/facebook.png') }}" alt="Facebook"></a>
            </div>
        </div>

        <!-- Columnas de información -->
        <div class="footer-info-sections">
            <!-- Columna Categorías -->
            <div class="footer-section">
                <h3>Categorías</h3>
                <p>Conciertos</p>
                <p>Teatro</p>
                <p>Deportes</p>
                <p>Festivales</p>
                <p>Familiar</p>
                <p>Foro</p>
                <p>Experiencias</p>
            </div>

            <!-- Columna Ayuda -->
            <div class="footer-section">
                <h3>Ayuda</h3>
                <p>Contáctanos</p>
                <p class="call-center">Call Center</p>
                <p><img src="{{ asset('img/phone.png') }}" alt="Auriculares" class="footer-icon">+57 3154588360</p>
            </div>

            <!-- Columna Legal -->
            <div class="footer-section">
                <h3>Legal</h3>
                <p>Política de Privacidad</p>
                <p>Términos de uso</p>
            </div>
        </div>

        <!-- Descarga de aplicaciones -->
        <div class="footer-download">
            <p>Descarga tu boleta</p>
            <div class="app-stores">
                <a href="#"><img src="{{ asset('img/appstore.png') }}" alt="App Store" class="store-badge"></a>
                <a href="#"><img src="{{ asset('img/googleplay.png') }}" alt="Google Play" class="store-badge"></a>
            </div>
        </div>

        <!-- Copyright -->
        <div class="footer-copyright">
            <p>©2025 ReservaYa ©. Reservados todos los derechos.</p>
        </div>
    </div>
</footer>

</body>
</html>