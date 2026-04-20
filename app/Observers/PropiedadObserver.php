<?php

namespace App\Observers;

use App\Models\Propiedad;
use App\Models\Auditoria;
use App\Mail\PropiedadCreadaMail;
use Illuminate\Support\Facades\Mail;


class PropiedadObserver
{
    public function created(Propiedad $propiedad): void
    {
        Auditoria::create([
            'user_id' => auth()->id(),
            'accion' => 'Creación de registro',
            'tabla_afectada' => 'propiedades',
            'registro_id' => $propiedad->id,
            'descripcion' => "Se creó propiedad: {$propiedad->nombre_titulo}",
            'valores_anteriores' => null,
            'valores_nuevos' => $propiedad->toArray(),
        ]);

        //Envia Mail
        Mail::to('karinroom91@gmail.com')->send(new PropiedadCreadaMail($propiedad));
    }

    public function updated(Propiedad $propiedad): void
    {
        $cambios = $propiedad->getChanges();
        unset($cambios['updated_at']); // sacamos ruido
        
        if (empty($cambios)) return;

        $original = [];
        foreach ($cambios as $campo => $valorNuevo) {
            $original[$campo] = $propiedad->getOriginal($campo);
        }

        $detalle = collect($cambios)->map(fn($val, $key) => "$key: {$original[$key]} → $val")->implode(', ');

        Auditoria::create([
            'user_id' => auth()->id(),
            'accion' => 'Actualización de datos',
            'tabla_afectada' => 'propiedades',
            'registro_id' => $propiedad->id,
            'descripcion' => "Propiedad {$propiedad->nombre_titulo}: $detalle",
            'valores_anteriores' => $original,
            'valores_nuevos' => $cambios,
        ]);
    }

    public function deleted(Propiedad $propiedad): void
    {
        Auditoria::create([
            'user_id' => auth()->id(),
            'accion' => 'Eliminación de registro',
            'tabla_afectada' => 'propiedades',
            'registro_id' => $propiedad->id,
            'descripcion' => "Propiedad eliminada: {$propiedad->nombre_titulo}",
            'valores_anteriores' => $propiedad->toArray(),
            'valores_nuevos' => null,
        ]);
    }
}
