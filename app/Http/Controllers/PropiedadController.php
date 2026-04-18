<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropiedadController extends Controller
{
    public function index()
    {
        $propiedades = Propiedad::all();//with('responsable')->get();
        return view('propiedades.index', compact('propiedades'));
    }

    public function create()
    {
        return view('propiedades.create');
    }

   public function store(Request $request)
   {
      $request->validate([
        'nombre_titulo' => 'required|string|max:255',
        'tipo' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'precio' => 'required|numeric|min:1',
        'estado' => 'required|in:DISPONIBLE,RESERVADA,VENDIDA',
        'descripcion' => 'required|string',
        'superficie_m2' => 'required|integer|min:1',
        'ambientes' => 'required|integer|min:1',
      ]);

     Propiedad::create([
        'nombre_titulo' => $request->nombre_titulo,
        'tipo' => $request->tipo,
        'direccion' => $request->direccion,
        'precio' => $request->precio,
        'descripcion' => $request->descripcion,
        'estado' => $request->estado,
        'superficie_m2' => $request->superficie_m2,
        'ambientes' => $request->ambientes,
        'responsable_id' => auth()->id(),
      ]);

     return redirect()->route('propiedades.index')->with('success', 'Propiedad creada!');
    }

    public function show(Propiedad $propiedad)
    {
        //
    }

    public function edit(Propiedad $propiedad)
    {
       return view('propiedades.edit', compact('propiedad'));
    }

    public function update(Request $request, Propiedad $propiedad)
    {
      $request->validate([
        'nombre_titulo' => 'required|string|max:255',
        'tipo' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'precio' => 'required|numeric|min:1',
        'estado' => 'required|in:DISPONIBLE,RESERVADA,VENDIDA',
        'descripcion' => 'nullable|string',
        'superficie_m2' => 'nullable|integer|min:1',
        'ambientes' => 'nullable|integer|min:1',
      ]);

      $propiedad->update($request->all());

      return redirect()->route('propiedades.index')->with('success', 'Propiedad actualizada!');
    }

    public function destroy(Propiedad $propiedad)
    {
       $propiedad->delete();
       return redirect()->route('propiedades.index')->with('success', 'Propiedad eliminada!');
    }
}