<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    use HasFactory;

    protected $table = 'propiedades'; // Por las dudas, aunque Laravel lo deduce

    protected $fillable = [
        'titulo',
        'descripcion', 
        'direccion',
        'precio',
        'responsable_id'
    ];

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
}