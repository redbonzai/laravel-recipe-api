<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $table = 'steps';
    
    protected $fillable = [
        'recipe_id',
        'step_order',
        'description'
    ];
    
    protected $casts = [
        'recipe_id' => 'integer',
        'step_order' => 'integer',
        'description' => 'string'
    ];
    
    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id', 'id');
    }
}
