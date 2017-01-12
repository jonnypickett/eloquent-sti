<?php

namespace JonnyPickett\EloquentSTI;

use Illuminate\Database\Eloquent\Model;
use Orchestra\Testbench\TestCase;

class Ball extends Model
{

}

class Animal extends Model
{
    use SingleTableInheritance;
}

class Dog extends Animal
{

}

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

class SingleTableInheritanceTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('eloquent-sti.subclass_field', 'subclass_name');
    }

    /**
     * Test that SingleTableInheritance has all necessary methods
     */
    public function testSingleTableInheritanceHasNecessaryMethods()
    {
        $mock = $this->getMockForTrait(SingleTableInheritance::class);

        $this->assertTrue(
            method_exists($mock, 'isSubclass'),
            'SingleTableInheritance does not have \'isSubclass\' method.'
        );

        $this->assertTrue(
            method_exists($mock, 'hasValidSubclassField'),
            'SingleTableInheritance does not have \'hasValidSubclassField\' method.'
        );

        $this->assertTrue(
            method_exists($mock, 'getSubClassField'),
            'SingleTableInheritance does not have \'getSubClassField\' method.'
        );

        $this->assertTrue(
            method_exists($mock, 'usesSTI'),
            'SingleTableInheritance does not have \'usesSTI\' method.'
        );

        $this->assertTrue(
            method_exists($mock, 'mapData'),
            'SingleTableInheritance does not have \'mapData\' method.'
        );

        $this->assertTrue(
            method_exists($mock, 'newFromBuilder'),
            'SingleTableInheritance does not have \'newFromBuilder\' method.'
        );

        $this->assertTrue(
            method_exists($mock, 'newQuery'),
            'SingleTableInheritance does not have \'newQuery\' method.'
        );

        $this->assertTrue(
            method_exists($mock, 'save'),
            'SingleTableInheritance does not have \'save\' method.'
        );

        $this->assertTrue(
            method_exists($mock, 'update'),
            'SingleTableInheritance does not have \'update\' method.'
        );
    }

    /**
     * Test that Model does not have SingleTableInheritance specific methods
     */
    public function testModelDoesNotHaveSingleTableInheritanceMethods()
    {
        $mock = $this->createMock(Ball::class);

        $this->assertFalse(
            method_exists($mock, 'isSubclass'),
            'Model has \'isSubclass\' method.'
        );

        $this->assertFalse(
            method_exists($mock, 'hasValidSubclassField'),
            'Model has \'hasValidSubclassField\' method.'
        );

        $this->assertFalse(
            method_exists($mock, 'getSubClassField'),
            'Model has \'getSubClassField\' method.'
        );

        $this->assertFalse(
            method_exists($mock, 'usesSTI'),
            'Model has \'usesSTI\' method.'
        );
    }

    /**
     * Test that Parent class is not subclass
     */
    public function testParentIsNotSubclass()
    {
        $animal = new Animal();

        $this->assertFalse($animal->isSubclass());
    }

    /**
     * Test that hasValidSubclassField returns correct value
     */
    public function testHasValidSubclassField()
    {
        $animal = new Animal();
        // This should return true because the default config is set
        $this->assertTrue($animal->hasValidSubclassField());

        $vehicle = new Vehicle();
        // This should return false because the $subclassField property
        // is set to null
        $this->assertFalse($vehicle->hasValidSubclassField());

        $vehicle->setSubclassField('subclass');
        // This should return true because the $subclassField property
        // is now set to a string
        $this->assertTrue($vehicle->hasValidSubclassField());

        config(['eloquent-sti.subclass_field' => null]);
        // This should return false because the config value
        // is set to null
        $this->assertFalse($animal->hasValidSubclassField());
    }

    /**
     * Test that getSubclassField returns correct value
     */
    public function testGetSubclassField()
    {
        $animal = new Animal();
        // This should return 'subclass_name' because the default config is set
        $this->assertEquals('subclass_name', $animal->getSubClassField());

        $vehicle = new Vehicle();
        // This should return null because the $subclassField property
        // is set to null
        $this->assertNull($vehicle->getSubClassField());

        $vehicle->setSubclassField('subclass');
        // This should return 'subclass' because the $subclassField property
        // is now set to a 'subclass'
        $this->assertEquals('subclass', $vehicle->getSubClassField());

        config(['eloquent-sti.subclass_field' => null]);
        // This should return null because the config value
        // is set to null
        $this->assertNull($animal->getSubClassField());
    }

    /**
     * Test that usesSTI returns correct value
     */
    public function testUsesSTI()
    {
        $animal = new Animal();
        // This should return true because hasValidSubclassField returns true
        $this->assertTrue($animal->usesSTI());

        $vehicle = new Vehicle();
        // This should return false because hasValidSubclassField returns false
        $this->assertFalse($vehicle->usesSTI());

        $vehicle->setSubclassField('subclass');
        // This should return true because hasValidSubclassField returns true
        $this->assertTrue($vehicle->usesSTI());

        config(['eloquent-sti.subclass_field' => null]);
        // This should return false because hasValidSubclassField returns false
        $this->assertFalse($animal->usesSTI());
    }

    /**
     * Test that Child is subclass of Parent
     */
    public function testChildIsSubclassOfParent()
    {
        $dog = new Dog();

        $this->assertInstanceOf(Animal::class, $dog);
    }

    /**
     * Test that Child is subclass
     */
    public function testChildIsSubclass()
    {
        $dog = new Dog();

        $this->assertTrue($dog->isSubclass());
    }
}
