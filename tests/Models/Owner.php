<?php

namespace JonnyPickett\EloquentSTI\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    public function animals()
    {
        return $this->belongsToMany(Animal::class, 'animals_owners');
    }

    public function dogs()
    {
        return $this->belongsToMany(Dog::class, 'animals_owners', 'owner_id', 'animal_id');
    }

    public function cats()
    {
        return $this->belongsToMany(Cat::class, 'animals_owners', 'owner_id', 'animal_id');
    }

    public function balls()
    {
        return $this->belongsToMany(Ball::class, 'balls_owners');
    }
}