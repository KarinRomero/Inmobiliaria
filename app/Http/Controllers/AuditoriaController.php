<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auditoria;

class AuditoriaController extends Controller
{
    public function index()
    {
        $auditorias = Auditoria::with('usuario')
           ->where('tabla_afectada', 'propiedades')
           ->latest()
           ->paginate(15);
        
        return view('auditorias.index', compact('auditorias'));
    }
}
