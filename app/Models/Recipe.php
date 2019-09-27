<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'recipes';
    protected $fillable = [
        'user_id',
        'title',
        'description',
    ];
    
    protected $casts = [
        'user_id' => 'integer',
        'title' => 'string',
        'description' => 'string',
    ];
    
    public function ingredients()
    {
        return $this->hasMany(Ingredient::class, 'recipe_id', 'id');
    }
    
    public function steps()
    {
        return $this->hasMany(Step::class, 'recipe_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
}
