<?php

namespace JonnyPickett\EloquentSTI\Models;

use Illuminate\Database\Eloquent\Model;
use JonnyPickett\EloquentSTI\SingleTableInheritance;

class Animal extends Model
{
    use SingleTableInheritance;

    protected $table = 'animals';

    public function owners()
    {
        return $this->belongsToMany(Owner::class);
    }
}