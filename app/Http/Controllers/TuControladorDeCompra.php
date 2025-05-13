<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento; // Asegúrate de que el modelo Evento exista

class TuControladorDeCompra extends Controller
{
    
    public function agregar(Request $request, $id)
    {
        $carrito = session()->get('carrito', []);
        $evento = Evento::findOrFail($id);

        $carrito[$id] = [
            'nombre' => $evento->nombre,
            'imagen' => $evento->imagen,
            'precio' => $evento->precio,
            'cantidad' => $request->input('cantidad_entradas'),
            'fecha' => $evento->fecha,
            'edad' => $evento->edad_minima,
        ];

        session()->put('carrito', $carrito);

        return response()->json([
            'mensaje' => 'Evento añadido al carrito',
            'total_items' => count($carrito),
            'carrito' => $carrito
        ]);
    }


    public function obtener(Request $request)
    {
        $carrito = session()->get('carrito', []);
        $totalItems = count($carrito);
        $carritoConUrls = [];

        foreach ($carrito as $itemId => $item) {
            $carritoConUrls[$itemId] = $item;
            $rutaImagen = $item['imagen'];

            // Elimina 'eventos/' del inicio de la ruta si existe
            if ($rutaImagen && str_starts_with($rutaImagen, 'eventos/')) {
                $rutaImagen = substr($rutaImagen, strlen('eventos/'));
            }

            // Verifica si la ruta de la imagen ya comienza con 'http' o '/'
            if ($rutaImagen && !str_starts_with($rutaImagen, 'http') && !str_starts_with($rutaImagen, '/')) {
                $carritoConUrls[$itemId]['imagen'] = asset('storage/eventos/' . $rutaImagen);
            } elseif ($rutaImagen && str_starts_with($rutaImagen, '/storage')) {
                // Si la ruta ya incluye /storage, usa asset() para generar la URL correcta
                $carritoConUrls[$itemId]['imagen'] = asset($rutaImagen);
            } else {
                // Si la ruta ya es una URL absoluta o relativa desde la raíz, la dejamos como está
                $carritoConUrls[$itemId]['imagen'] = $rutaImagen;
            }
        }

        return response()->json(['carrito' => $carritoConUrls, 'total_items' => $totalItems]);
    }

    public function mostrarFormularioCompra($id)
    {
        $evento = Evento::findOrFail($id);
        return view('comprar.formulario', compact('evento')); // Asegúrate de que la vista 'comprar.formulario' exista
    }
}