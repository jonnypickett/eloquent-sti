<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Subclass Field
    |--------------------------------------------------------------------------
    |
    | Subclass class names will be stored and retrieved from this field.
    | This can be overridden in specific classes by setting the
    | protected property $subclassFiled to a different value
    | in the class definition.
    |
    */

    'subclass_field' => env('ELOQUENT_STI_SUBCLASS_FIELD', 'subclass_name'),
];