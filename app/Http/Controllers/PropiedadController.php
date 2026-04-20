<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropiedadController extends Controller
{
    public function index()
    {
        $propiedades = Propiedad::with('responsable')->get();
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
        'tipo' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'precio' => 'required|numeric|min:1|max:9999999999.99',
        'estado' => 'required|in:DISPONIBLE,RESERVADA,VENDIDA',
        'descripcion' => 'required|string',
        'superficie_m2' => 'required|integer|min:1',
        'ambientes' => 'required|integer|min:1',
        'responsable_id'=> 'required|exists:usuarios,id',
        'imagenes'=> 'nullable|array',
        'imagenes.*'=> 'nullable|url',
      ], [
        'precio.max'=>'El precio es demasiado alto. Maximo permitido: 9.999.999.999,99',
      ]);

      // Sacamos imagenes porque no es una columna de la tabla propiedades
        $imagenes = $validated['imagenes'] ?? [];
        unset($validated['imagenes']);

      $propiedad = Propiedad::create($validated);
      //Guardar imagenes si mandan
      if ($request->filled('imagenes')) {
        foreach ($request->imagenes as $url) {
            if ($url) { // Solo si no está vacío
                $propiedad->imagenes()->create(['url_imagen' => $url]);
            }
        }
      }

     return redirect()->route('propiedades.index')->with('success', '¡Propiedad creada!');
    }

    public function show(Propiedad $propiedad)
    {
        return view('propiedades.show', compact('propiedad'));
    }

    public function edit(Propiedad $propiedad)
    {
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
        'superficie_m2' => 'required|integer|min:1',
        'ambientes' => 'required|integer|min:1',
        'responsable_id'=> 'required|exists:usuarios,id',
        'imagenes'=> 'nullable|array',
        'imagenes.*'=> 'nullable|url',
      ];


      // Solo valida el precio si es ADMINISTRADOR
      if (auth()->user()->rol === 'ADMINISTRADOR') {
        $rules['precio'] = 'required|numeric|min:1';
      }else{
        //si no es administrador lo sacamos de las reglas para que no haya problema
        unset($rules['precio']);
      }

       $validated = $request->validate($rules);
 
      // Si NO es admin, no le dejamos pisar el precio aunque inspeccione el HTML
      if (auth()->user()->rol !== 'ADMINISTRADOR') {
        unset($validated['precio']);
    }
    
    $imagenes = $validated['imagenes']??[];
    unset($validated['imagenes']);



      $propiedad->update($validated);

     // Sincronizar imágenes: borramos las viejas y creamos las nuevas
      $propiedad->imagenes()->delete();
      if ($request->filled('imagenes')) {
        foreach ($request->imagenes as $url) {
            if ($url) {
              $propiedad->imagenes()->create(['url_imagen' => $url]);
            }
        }
      }


      return redirect()->route('propiedades.index')->with('success', '¡Propiedad actualizada!');
    }

    public function destroy(Propiedad $propiedad)
    {
      if (auth()->user()->rol !== 'ADMINISTRADOR'){
        abort(403, 'No tenés permisos para eliminar propiedades');
      }
      $propiedad->imagenes()->delete(); //borra las imagenes relacionadas
      $propiedad->delete();
      return redirect()->route('propiedades.index')->with('success', '¡Propiedad eliminada!');
    }
}