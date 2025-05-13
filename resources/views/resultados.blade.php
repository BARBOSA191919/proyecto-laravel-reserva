<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de búsqueda</title>
</head>
<body>
    <h1>Resultados para: "{{ $query }}"</h1>

    @if($eventos->isEmpty())
        <p>No se encontraron eventos que coincidan con tu búsqueda.</p>
    @else
        @foreach($eventos as $evento)
            <div style="margin-bottom: 20px; border: 1px solid #ccc; padding: 10px;">
                <h2>{{ $evento->nombre }}</h2>

                @if ($evento->imagen)
                    <img src="{{ asset('storage/' . $evento->imagen) }}" alt="Imagen del evento" width="150">
                @endif

                <p><strong>Lugar:</strong> {{ $evento->lugar }}</p>
                <p><strong>Ciudad:</strong> {{ $evento->ciudad }}</p>
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</p>
            </div>
        @endforeach
    @endif

    <br>
    <a href="{{ url('/') }}">← Volver al inicio</a>
</body>
</html>