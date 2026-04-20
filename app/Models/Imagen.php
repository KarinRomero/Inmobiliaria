<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Imagen extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada al modelo.
     * Laravel buscaría "imagens" por defecto, por eso lo forzamos.
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
    public function propiedad(): BelongsTo
    {
        return $this->belongsTo(Propiedad::class, 'propiedad_id');
    }
}