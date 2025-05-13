<!DOCTYPE html>
<html>
<head>
    <title>Comprar {{ $evento->nombre }}</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/comprar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bienvenida.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans:ital,wght@1,700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/comprar.js') }}" defer></script>
</head>
<body>
    <header class="encabezado">
        <a href="/" class="contenedor-logotipo"><img class="logotipo" src="{{ asset('img/logotipo.png') }}" alt="logo"></a>
        <a class="texto-principal" href="#">Conciertos</a>
        <a class="texto-principal" href="#">Teatro</a>
        <a class="texto-principal" href="#">Deportes</a>
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
        <a href="{{ route('contactanos') }}" class="texto-principal1">Contáctanos</a>
        <a href="{{ route('login') }}" class="contenedor-perfil"><img class="perfil" src="{{ asset('img/perfil.png') }}" alt="Perfil"></a>
        <div class="barra">
            <nav>
                <img class="logosg" src="{{ asset('img/location.png') }}" alt="Ubicación">
                <h2 class="ciudad">Ciudad</h2>
                <div class="triangulo1"></div>
                <div class="divisor">
                    <div class="menu-categorias" id="botonCategorias">
                        <img id="botonCategorias" class="logosg1" src="{{ asset('img/categoria.png') }}" alt="Categoría">
                        <h2 class="categoria">Categoria</h2>
                        <div class="triangulo2" id="miTriangulo"></div>
                        <div id="menuCategorias" class="contenido-categorias">
                            <a class="titulo-categorias" href="#">Conciertos</a>
                            <a class="titulo-categorias" href="#">Deportes</a>
                            <a class="titulo-categorias" href="#">Experiencias</a>
                            <a class="titulo-categorias" href="#">Familia</a>
                            <a class="titulo-categorias" href="#">Festival</a>
                            <a class="titulo-categorias" href="#">Foros, Seminarios y Congresos</a>
                            <a class="titulo-categorias" href="#">Museos y Exposiciones</a>
                            <a class="titulo-categorias" href="#">Teatro</a>
                        </div>
                    </div>
                    <div class="divisor2">
                        <img class="logosg3" src="{{ asset('img/calendario.png') }}" alt="Calendario">
                        <h2 class="fecha">Fecha</h2>
                        <div class="triangulo3"></div>
                        <div class="divisor3">
                            <form action="{{ route('eventos.buscar') }}" method="GET">
                                <input type="text" id="input-busqueda" class="buscador2" name="query" placeholder="Buscar por evento, Artista...">
                                <img class="lupa" src="{{ asset('img/lupa1.png') }}" alt="Buscar">
                            </form>
                        </div>
                    </div>
                    <img id="icono-buscar" class="lupa3" src="{{ asset('img/lupa2.png') }}" alt="Buscar">
                </div>
            </nav>
        </div>
    </header>
    <div class="contenido-principal">
    <div class="contenedor-compra">
    <h1>Comprar Boletos para {{ $evento->nombre }}</h1>

    @if ($evento->imagen)
        <img src="{{ asset('storage/' . $evento->imagen) }}" alt="Imagen de {{ $evento->nombre }}">
    @endif

    <div class="detalles-evento">
        <p><strong>Lugar:</strong> {{ $evento->lugar }}</p>
        <p><strong>Ciudad:</strong> {{ $evento->ciudad }}</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($evento->fecha)->format('d M Y') }}</p>
        <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($evento->hora)->format('h:i A') }}</p>
        @if ($evento->precio)
            <p><strong>Precio por entrada:</strong> ${{ $evento->precio }}</p>
        @endif
        @if ($evento->apertura_puertas)
            <div class="info-adicional">
                <img src="{{ asset('img/horario.png') }}" alt="Apertura de Puertas" class="icono-info">
                <p><strong>Apertura de Puertas:</strong> {{ \Carbon\Carbon::parse($evento->apertura_puertas)->format('h:i A') }}</p>
            </div>
        @endif
        @if ($evento->edad_minima)
            <div class="info-adicional">
                <img src="{{ asset('img/edad.png') }}" alt="Edad Mínima" class="icono-info">
                <p><strong>Edad Mínima:</strong> {{ $evento->edad_minima }} Años</p>
            </div>
        @endif
    </div>

    <form id="form-agregar-carrito" action="{{ route('carrito.agregar', $evento->id) }}" method="POST">
    @csrf
    <input type="hidden" name="evento_id" value="{{ $evento->id }}">
    <div class="cantidad-entradas">
        <label for="cantidad_entradas">Cantidad de Entradas:</label>
        <input type="number" id="cantidad_entradas" name="cantidad_entradas" value="1" min="1" class="input-cantidad">
    </div>
    @auth
    <button type="submit" class="boton-agregar-carrito" id="agregar-al-carrito-js">Añadir al Carrito</button>
    @else
        <a href="{{ route('login') }}" class="boton-agregar-carrito">Inicia sesión para añadir al carrito</a>
   @endauth
</form>
</div>


</body>
</html>