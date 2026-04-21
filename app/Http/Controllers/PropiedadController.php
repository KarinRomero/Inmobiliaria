<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use App\Models\Usuario;
use App\Models\Imagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropiedadController extends Controller
{
    public function index()
    {
        $propiedades = Propiedad::with('imagenPrincipal')->latest()->paginate(9);
        return view('propiedades.index', compact('propiedades'));
    }

    public function create()
    {
        $usuarios = Usuario::all();
        return view('propiedades.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_titulo' => 'required|string|max:255',
            'tipo' => 'required|in:Casa,Departamento,Local,Terreno,Galpón',
            'direccion' => 'required|string|max:255',
            'precio' => 'required|numeric|min:1|max:9999999999.99',
            'estado' => 'required|in:DISPONIBLE,RESERVADA,VENDIDA',
            'descripcion' => 'nullable|string',
            'superficie_m2' => 'nullable|integer|min:0',
            'ambientes' => 'nullable|integer|min:0',
            'responsable_id'=> 'required|exists:usuarios,id',
            'imagenes'=> 'required|array|min:1',
            'imagenes.*'=> 'image|mimes:jpeg,png,jpg,webp,avif|max:4096',
        ], [
            'imagenes.required'=> 'Tenés que subir al menos una imagen de la propiedad.',
            'imagenes.min'=> 'Tenés que subir al menos una imagen de la propiedad.',
            'precio.max'=>'El precio es demasiado alto. Máximo permitido: 9.999.999.999,99',
        ]);

        // Sacamos imagenes porque no es columna de propiedades
        $imagenes = $validated['imagenes'];
        unset($validated['imagenes']);

        $propiedad = Propiedad::create($validated);

        // Guardar archivos físicos
        foreach ($request->file('imagenes') as $imagen) {
            $path = $imagen->store('propiedades', 'public');
            $propiedad->imagenes()->create(['url_imagen' => $path]);
        }

        return redirect()->route('propiedades.index')->with('success', '¡Propiedad creada!');
    }

    public function show(Propiedad $propiedad)
    {
        $propiedad->load('imagenes');
        return view('propiedades.show', compact('propiedad'));
    }

    public function edit(Propiedad $propiedad)
    {
        $propiedad->load('imagenes');
        $usuarios = Usuario::all();
        return view('propiedades.edit', compact('propiedad','usuarios'));
    }

    public function update(Request $request, Propiedad $propiedad)
    {
        $rules = [
            'nombre_titulo' => 'required|string|max:255',
            'tipo' => 'required|in:Casa,Departamento,Local,Terreno,Galpón',
            'direccion' => 'required|string|max:255',
            'estado' => 'required|in:DISPONIBLE,RESERVADA,VENDIDA',
            'descripcion' => 'nullable|string',
            'superficie_m2' => 'nullable|integer|min:0',
            'ambientes' => 'nullable|integer|min:0',
            'responsable_id'=> 'required|exists:usuarios,id',
            'imagenes.*'=> 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:4096'
        ];

        if (auth()->user()->rol === 'ADMINISTRADOR') {
            $rules['precio'] = 'required|numeric|min:1|max:9999999999.99';
        }

        $validated = $request->validate($rules);

        if (auth()->user()->rol !== 'ADMINISTRADOR') {
            unset($validated['precio']);
        }

        $propiedad->update($validated);

        // Borrar imágenes tildadas
        if ($request->has('imagenes_borrar')) {
            $imagenesABorrar = Imagen::whereIn('id', $request->imagenes_borrar)->get();
            foreach ($imagenesABorrar as $img) {
                Storage::disk('public')->delete($img->url_imagen); // Borra archivo físico
                $img->delete(); // Borra registro BD
            }
        }

        // Subir imágenes nuevas
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $path = $imagen->store('propiedades', 'public');
                $propiedad->imagenes()->create(['url_imagen' => $path]);
            }
        }

        return redirect()->route('propiedades.index')->with('success', '¡Propiedad actualizada!');
    }

    public function destroy(Propiedad $propiedad)
    {
        if (auth()->user()->rol !== 'ADMINISTRADOR'){
            abort(403, 'No tenés permisos para eliminar propiedades');
        }

        // Borrar archivos físicos antes de borrar registros
        foreach ($propiedad->imagenes as $imagen) {
            Storage::disk('public')->delete($imagen->url_imagen);
        }
        
        $propiedad->imagenes()->delete();
        $propiedad->delete();
        return redirect()->route('propiedades.index')->with('success', '¡Propiedad eliminada!');
    }
}