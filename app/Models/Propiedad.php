<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    use HasFactory;

    protected $table = 'propiedades'; // Por las dudas, aunque Laravel lo deduce

    protected $fillable = [
        'nombre_titulo',
        'tipo',
        'direccion',
        'precio',
        'descripcion',
        'estado', 
        'superficie_m2',
        'ambientes',
        'responsable_id'
    ];

    public function responsable()
    {
        return $this->belongsTo(Usuario::class, 'responsable_id');
    }
    public function imagenes()
    {
        return $this->hasMany(Imagen::class, 'propiedad_id');
    }
}