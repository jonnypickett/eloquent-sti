# Eloquent Single Table Inheritance

[![Built For Laravel][ico-built-for]][link-built-for]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-style-ci]][link-style-ci]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)

Single Table Inheritance for Laravel's Eloquent ORM.

## Install

Via Composer

``` bash
$ composer require jonnypickett/eloquent-sti
```

After updating composer, add the ServiceProvider to the providers array in config/app.php

``` php
JonnyPickett\EloquentSTI\ServiceProvider::class,
```

## Usage

Use the SingleTableInheritance trait in any Eloquent model to take advantage of Single Table Inheritance in Laravel with the model's subclasses.

A table taking advantage of Single Table Inheritance needs to store subclass names. By default, this package uses a field named `subclass_name`, so add this field, or the field name you choose (configuration is shown later), to your table.

```php
Schema::table('animals', function(Blueprint $table)
{
    $table->string('subclass_name');
}
```

Once this field is added to your database table, you will need to add the `SingleTableInheritance` trait, make sure to specify the table property, and add the subclass name field to the `$fillable` array all on the parent model definition

``` php
class Animal extends Model
{
    use SingleTableInheritance;
    
    protected $table = 'animals';
    
    protected $fillable = [
        'subclass_name',
        ...
    ];
    
    protected $noise = '';
    
    /**
     * @return string
     */
    public function speak()
    {
        return $this->noise;
    }
}
```

Now just extend the parent model with any child models

```php
class Dog extends Animal
{
    protected $noise = 'ruff';
}
    
class Cat extends Animal
{
    protected $noise = 'meow';
}
```

That's it. Now the entries in your table, `animals` for our example, will always be returned as an instance of a specific subclass. When retrieving a collection, the collection will be a collection of various subclass instances. 

## Configuration

By default, the subclass names will be stored in a field named `subclass_name`. This can be changed project wide by updating your .env file
 
```php
ELOQUENT_STI_SUBCLASS_FIELD=your_subclass_field_name_here
```

or publishing and updating the package configuration file in app/config/eloquent-sti.php

```bash
php artisan vendor:publish --provider="JonnyPickett\EloquentSTI\ServiceProvider"
```

```php
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

    'subclass_field' => env('ELOQUENT_STI_SUBCLASS_FIELD', 'your_subclass_field_name_here'),
];

```

or can be changed on a per model basis by adding a `$subclassNameField` property to your parent model

```php
class Animal extends Model
{
    protected $subclassField = 'your_subclass_field_name_here'
}
```

## Credit

Inspiration for this package came way back when I came across [this Laravel.io forum post][link-laravelio-post] by [Shawn McCool][link-shawn-mccool]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/jonnypickett/eloquent-sti.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/jonnypickett/eloquent-sti/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/:vendor/:package_name.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/:vendor/:package_name.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/jonnypickett/eloquent-sti.svg?style=flat-square
[ico-built-for]: https://img.shields.io/badge/built%20for-laravel-blue.svg
[ico-style-ci]: https://styleci.io/repos/45497055/shield?style=flat

[link-packagist]: https://packagist.org/packages/jonnypickett/eloquent-sti
[link-travis]: https://travis-ci.org/jonnypickett/eloquent-sti
[link-scrutinizer]: https://scrutinizer-ci.com/g/:vendor/:package_name/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/:vendor/:package_name
[link-downloads]: https://packagist.org/packages/jonnypickett/eloquent-sti
[link-author]: https://github.com/jonnypickett
[link-contributors]: ../../contributors
[link-built-for]: http://laravel.com
[link-style-ci]: https://styleci.io/repos/78478485
[link-laravelio-post]: http://laravel.io/forum/02-17-2014-eloquent-single-table-inheritance
[link-shawn-mccool]: https://github.com/ShawnMcCool
