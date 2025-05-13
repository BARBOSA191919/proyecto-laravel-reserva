    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Crear Evento</title>
        <link rel="stylesheet" href="{{ asset('css/bienvenida.css') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans:ital,wght@1,700&display=swap" rel="stylesheet">
        <script src="{{ asset('js/bienvenida.js') }}"></script>
        
    </head>
    <body>
        <header class="encabezado">
        <a href="{{ route('bienvenida') }}"><img class="logotipo" src="{{ asset('img/logotipo.png') }}" alt="logo"></a>
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

        <div class="contenedor">
            <h1>Crear Evento</h1>

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

            <form action="{{ route('eventos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="nombre">Nombre del evento:</label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required>

        <label for="categoria" require>Categoría del evento:</label>
        <select name="categoria" id="categoria">
            <option value="Conciertos">Conciertos</option>
            <option value="Deportes">Deportes</option>
            <option value="Experiencias">Experiencias</option>
            <option value="Familia">Familia</option>
            <option value="Festival">Festival</option>
            <option value="Foros, Seminarios y Congresos">Foros, Seminarios y Congresos</option>
            <option value="Museos y Exposiciones">Museos y Exposiciones</option>
            <option value="Teatro">Teatro</option>
        </select>

        <label for="imagen">Imagen:</label>
        <input type="file" name="imagen" id="imagen" accept="image/*" required>

        <label for="lugar">Lugar:</label>
        <input type="text" name="lugar" id="lugar" value="{{ old('lugar') }}" required>

        <label for="ciudad">Ciudad:</label>
        <input type="text" name="ciudad" id="ciudad" value="{{ old('ciudad') }}" required>

        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" id="fecha" min="{{\Carbon\Carbon::now()->format('Y-m-d')}}" value="{{ old('fecha', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>

        <label for="precio">Precio del evento:</label>
        <input type="number" name="precio" id="precio" min="0" value="{{ old('precio', 0) }}" required>

        {{-- Nuevos campos --}}
        <label for="hora_inicio_evento">Hora del evento:</label>
        <input type="time" name="hora_inicio_evento" id="hora_inicio_evento" value="{{ old('hora_inicio_evento') }}" required>

        <label for="hora_apertura">Hora de apertura de puertas:</label>
        <input type="time" name="hora_apertura" id="hora_apertura" value="{{ old('hora_apertura') }}"  required>

        <label for="edad_minima">Edad mínima para entrar:</label>
        <input type="number" name="edad_minima" id="edad_minima" min="0" value="{{ old('edad_minima', 0) }}"  required>

        <button type="submit">Guardar Evento</button>
        </form>
        </div>

        <hr>

        <div class="eventos-existentes">
        <h2>Eventos Existentes</h2>
        @forelse ($eventos as $evento)
            <div class="evento">
                <h3>{{ $evento->nombre }}</h3>
                <p><strong>Categoria:</strong> {{ $evento->categoria }}</p>
                <p><strong>Lugar:</strong> {{ $evento->lugar }}</p>
                <p><strong>Ciudad:</strong> {{ $evento->ciudad }}</p>
                <p><strong>Fecha:</strong> {{ $evento->fecha }}</p>
                @if ($evento->horariosEvento)
                    <p><strong>Hora Inicio:</strong> {{ $evento->horariosEvento->hora_inicio_evento ?? 'No especificada' }}</p>
                @endif
                @if ($evento->aperturaPuerta)
                    <p><strong>Apertura Puertas:</strong> {{ $evento->aperturaPuerta->hora_apertura ?? 'No especificada' }}</p>
                @endif
                @if ($evento->restriccionesEdad)
                    <p><strong>Edad Mínima:</strong> {{ $evento->restriccionesEdad->edad_minima ?? 'Sin restricción' }} años</p>
                @endif

                {{-- Añade esta línea para mostrar el precio --}}
                <p><strong>Precio:</strong> ${{ $evento->precio ?? '' }}</p>

                @if ($evento->imagen)
                    <img src="{{ asset('storage/' . $evento->imagen) }}" class="evento-tarjeta-img-top" alt="Imagen del evento" loading="lazy">
                @endif

                <form action="{{ route('eventos.destroy', $evento->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este evento?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </div>
        @empty
            <p>No hay eventos disponibles.</p>
        @endforelse
    </div>
    </body>
    </html>