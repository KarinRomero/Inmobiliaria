<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    
    protected $fillable = [
        'nombre', 
        'email', 
        'password', 
        'rol'
    ];
    
    protected $hidden = [
        'password', 
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function propiedades()
    {
        return $this->hasMany(Propiedad::class, 'responsable_id');
    }
}