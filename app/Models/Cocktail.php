<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cocktail extends Model
{
    // Especifica los nombres correctos de tus columnas
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';
    
    protected $fillable = [
        'id',
        'name',
        'description', 
        'tipo',
        'instructions',
        'create_at', // Añade estos campos al fillable
        'update_at'
    ];

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
}