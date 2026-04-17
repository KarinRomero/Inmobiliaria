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
        //
    }

    public function show(Propiedad $propiedad)
    {
        //
    }

    public function edit(Propiedad $propiedad)
    {
        //
    }

    public function update(Request $request, Propiedad $propiedad)
    {
        //
    }

    public function destroy(Propiedad $propiedad)
    {
        //
    }
}