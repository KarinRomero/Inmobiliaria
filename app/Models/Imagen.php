<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Imagen extends Model
{
   

    /**
     * El nombre de la tabla asociada al modelo.
     */
    protected $table = 'imagenes';

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'propiedad_id',
        'url_imagen',
    ];

    /**
     * Relación: Una imagen pertenece a una propiedad.
     */
    public function propiedad()
    {
        return $this->belongsTo(Propiedad::class);
    }
}