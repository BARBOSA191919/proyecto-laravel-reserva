<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eventos de Familia</title>
    <link rel="stylesheet" href="{{ asset('css/familia.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <h1>Eventos de Familia</h1>
        <nav>
            <a href="{{ route('categorias.conciertos') }}">Conciertos</a>
            <a href="{{ route('categorias.deportes') }}">Deportes</a>
            <a href="{{ route('categorias.experiencias') }}">Experiencias</a>
            <a href="{{ route('bienvenida') }}">Volver a todos los eventos</a>
        </nav>
    </header>

    <div class="filtros">
        <h2>Filtros</h2>
        <form action="{{ route('eventos.buscar') }}" method="GET">
            <input type="text" name="query" placeholder="Buscar eventos..." class="busqueda">
            <button type="submit" class="boton-busqueda">Buscar</button>
        </form>
        <div class="filtro-activo">
            Familia <a href="{{ route('categorias.familia.remover') }}">X</a>
        </div>
    </div>

    <div class="lista-de-eventos">
        @forelse ($familia as $evento)
            <div class="evento">
                <h3>{{ $evento->nombre }}</h3>
                <p>Lugar: {{ $evento->lugar }}</p>
                <p>Fecha: {{ $evento->fecha }}</p>
                @if ($evento->imagen)
                    <img src="{{ asset('storage/' . $evento->imagen) }}" alt="Imagen del evento">
                @else
                    <div class="imagen-placeholder">Sin imagen</div>
                @endif
                <a href="{{ route('comprar.evento', $evento->id) }}" class="boton-detalle">Ver Detalles</a>
            </div>
        @empty
            <p>No hay eventos disponibles en Familia.</p>
        @endforelse
        <div class="paginacion">{{ $familia->links() }}</div>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h4>Sobre Nosotros</h4>
                <p>Disfruta de eventos familiares llenos de diversión para todas las edades. ¡Crea recuerdos juntos!</p>
            </div>
            <div class="footer-section">
                <h4>Enlaces Rápidos</h4>
                <ul>
                    <li><a href="{{ route('bienvenida') }}">Todos los eventos</a></li>
                    <li><a href="{{ route('categorias.experiencias') }}">Experiencias</a></li>
                    <li><a href="{{ route('categorias.teatro') }}">Teatro</a></li>
                    <li><a href="{{ route('contactanos') }}">Contacto</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contacto</h4>
                <ul>
                    <li>Email: info@familiaeventos.com</li>
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
            © {{ date('Y') }} Plataforma de Familia. Todos los derechos reservados.
        </div>
    </footer>
</body>
</html>