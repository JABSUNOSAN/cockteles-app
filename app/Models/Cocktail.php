<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cocktail extends Model
{
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';
    
    protected $fillable = [
        'id',
        'name',
        'description', 
        'tipo',
        'instructions',
        'image_url',
        'create_at',
        'update_at'
    ];

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
}