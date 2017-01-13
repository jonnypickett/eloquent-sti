<?php

namespace JonnyPickett\EloquentSTI\Models;

use Illuminate\Database\Eloquent\Model;
use JonnyPickett\EloquentSTI\SingleTableInheritance;

class Vehicle extends Model
{
    use SingleTableInheritance;

    protected $subclassField = null;

    /**
     * @param null $subclassField
     */
    public function setSubclassField($subclassField)
    {
        $this->subclassField = $subclassField;
    }
}
