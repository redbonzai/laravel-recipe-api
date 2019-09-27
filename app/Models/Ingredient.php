<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $table = 'ingredients';
    protected $fillable = [
        'recipe_id',
        'name',
        'quantity'
    ];
    
    protected $casts = [
        'recipe_id' => 'integer',
        'name' => 'string',
        'quantity' => 'integer'
    ];
    
    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id', 'id');
    }
}
