<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eventos de Festival</title>
    <link rel="stylesheet" href="{{ asset('css/tu_estilo.css') }}"> </head>
<body>
    <header>
        <h1>Eventos de Festival</h1>
        <a href="{{ route('bienvenida') }}">Volver a todos los eventos</a>
    </header>

    <div class="filtros">
        <h2>Filtros</h2>
        <div class="filtro-activo">
            Festival <a href="{{ route('categorias.festival.remover') }}">X</a>
        </div>
    </div>

    <div class="lista-de-eventos">
        @forelse ($festival as $evento)
            <div class="evento">
                <h3>{{ $evento->nombre }}</h3>
                <p>Lugar: {{ $evento->lugar }}</p>
                <p>Fecha: {{ $evento->fecha }}</p>
                @if ($evento->imagen)
                    <img src="{{ asset('storage/' . $evento->imagen) }}" alt="Imagen del evento" style="max-width: 300px;">
                @endif
            </div>
        @empty
            <p>No hay eventos disponibles en Festival.</p>
        @endforelse
    </div>

    <footer>
        </footer>
</body>
</html>