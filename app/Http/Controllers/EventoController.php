<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\HorariosEvento;
use App\Models\AperturaPuerta;
use App\Models\RestriccionesEdad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class EventoController extends Controller
{
    /**
     * Display the form for creating a new event and list existing events.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
    $eventos = Evento::all();
    return view('eventos.create', compact('eventos'));
    }
    public function getCiudades()
    {
        $ciudades = Evento::distinct()->pluck('ciudad')->sort()->values();
        return response()->json($ciudades);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
{


    $request->validate([
        'nombre' => 'required|string|max:255',
        'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'lugar' => 'required|string|max:255',
        'ciudad' => 'required|string|max:255',
        'fecha' => 'required|date',
        'categoria' => 'nullable|string|max:255', // El nombre del select
        'hora_inicio_evento' => 'nullable|date_format:H:i',
        'hora_apertura' => 'nullable|date_format:H:i',
        'edad_minima' => 'nullable|integer|min:0',
        'precio' => 'required|integer|min:0', // ¡Añade la validación para el precio!
    ]);

    $evento = new Evento();
    $evento->nombre = $request->nombre;
    $evento->lugar = $request->lugar;
    $evento->ciudad = $request->ciudad;
    $evento->fecha = $request->fecha;
    $evento->precio = $request->precio; // ¡Añade esta línea para guardar el precio!

    if ($request->hasFile('imagen')) {
        $imagenPath = $request->file('imagen')->store('eventos', 'public');
        $evento->imagen = $imagenPath;
    }

    // Guardar la categoría directamente en la columna 'categoria'
    if ($request->filled('categoria')) {
        $evento->categoria = $request->categoria;
    }

    $evento->save();

    if ($request->filled('hora_inicio_evento')) {
        HorariosEvento::create(['evento_id' => $evento->id, 'hora_inicio_evento' => $request->hora_inicio_evento]);
    }

    if ($request->filled('hora_apertura')) {
        AperturaPuerta::create(['evento_id' => $evento->id, 'hora_apertura' => $request->hora_apertura]);
    }

    if ($request->filled('edad_minima')) {
        RestriccionesEdad::create(['evento_id' => $evento->id, 'edad_minima' => $request->edad_minima]);
    }

    return redirect()->route('eventos.create')->with('success', 'Evento creado exitosamente!');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Evento $evento)
{
    // Eliminar la imagen del storage si existe
    if ($evento->imagen) {
        Storage::delete('public/' . $evento->imagen);
    }

    $evento->horariosEvento()->delete(); // Eliminar relaciones HasOne si existen
    $evento->aperturaPuerta()->delete();
    $evento->restriccionesEdad()->delete();

    $evento->delete();

    return redirect()->route('eventos.create')->with('success', 'Evento eliminado exitosamente.');
}

    /**
     * Show the welcome page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showBienvenida(): View
    {
        $eventos = Evento::all();
        return view('bienvenida', compact('eventos'));
    }

    /**
     * Search for events.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function buscar(Request $request): View
    {
        $query = $request->input('query');
        $eventos = Evento::where('nombre', 'like', "%$query%")
                         ->orWhere('descripcion', 'like', "%$query%")
                         ->orWhere('ubicacion', 'like', "%$query%")
                         ->orWhere('lugar', 'like', "%$query%")
                         ->orWhere('ciudad', 'like', "%$query%")
                         ->get();

        return view('resultados', compact('eventos', 'query'));
    }

    public function mostrarPorCiudad($ciudad)
{
    $eventos = Evento::where('ciudad', $ciudad)->get();
    return view('resultados', compact('eventos', 'ciudad'));
}

public function mostrarConciertos()
{
    $conciertos = Evento::where('categoria', 'Conciertos')->paginate(6);
    return view('categorias.conciertos', compact('conciertos'));
}

    public function mostrarDeportes()
{
    $deportes = Evento::where('categoria', 'Deportes')->paginate(6);
    return view('categorias.deportes', compact('deportes'));
}

    public function mostrarExperiencias()
{
    $experiencias = Evento::where('categoria', 'Experiencias')->paginate(6);
    return view('categorias.experiencias', compact('experiencias'));
}

    public function mostrarFamilia()
{
    $familia = Evento::where('categoria', 'Familia')->paginate(6);
    return view('categorias.familia', compact('familia'));
}

    public function mostrarFestival()
{
    $festival = Evento::where('categoria', 'Festival')->get();
    return view('categorias.festival', compact('festival'));
}

    public function mostrarForosseminarios()
{
    $forosseminarios = Evento::where('categoria', 'Forosseminarios')->get();
    return view('categorias.forosseminarios', compact('forosseminarios'));
}


public function mostrarMuseoexposiciones()
{
    $museoexposiciones = Evento::where('categoria', 'Museoexposiciones')->get();
    return view('categorias.museoexposiciones', compact('museoexposiciones'));
}

public function mostrarTeatro()
{
    $teatro = Evento::where('categoria', 'Teatro')->get();
    return view('categorias.teatro', compact('teatro'));
}

public function removerFiltroConciertos()
{
    // Redirige a la página donde se muestran todos los eventos.
    // Asumiendo que esta es la ruta 'eventos.create'. Ajusta si es diferente.
    return redirect()->route('bienvenida');
}


public function removerFiltroDeportes()
{
    // Redirige a la página donde se muestran todos los eventos.
    // Asumiendo que esta es la ruta 'eventos.create'. Ajusta si es diferente.
    return redirect()->route('bienvenida');
}


public function removerFiltroExperiencias()
{
    // Redirige a la página donde se muestran todos los eventos.
    // Asumiendo que esta es la ruta 'eventos.create'. Ajusta si es diferente.
    return redirect()->route('bienvenida');
}


public function removerFiltroFamilia()
{
    // Redirige a la página donde se muestran todos los eventos.
    // Asumiendo que esta es la ruta 'eventos.create'. Ajusta si es diferente.
    return redirect()->route('bienvenida');
}


public function removerFiltroFestival()
{
    // Redirige a la página donde se muestran todos los eventos.
    // Asumiendo que esta es la ruta 'eventos.create'. Ajusta si es diferente.
    return redirect()->route('bienvenida');
}


public function removerFiltroForosseminarios()
{
    // Redirige a la página donde se muestran todos los eventos.
    // Asumiendo que esta es la ruta 'eventos.create'. Ajusta si es diferente.
    return redirect()->route('bienvenida');
}


public function removerFiltroMuseoexposiciones()
{
    // Redirige a la página donde se muestran todos los eventos.
    // Asumiendo que esta es la ruta 'eventos.create'. Ajusta si es diferente.
    return redirect()->route('bienvenida');
}


public function removerFiltroTeatro()
{
    // Redirige a la página donde se muestran todos los eventos.
    // Asumiendo que esta es la ruta 'eventos.create'. Ajusta si es diferente.
    return redirect()->route('bienvenida');
}



    // ... (otros métodos como show, edit, update)
}