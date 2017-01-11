<?php

namespace JonnyPickett\EloquentSTI;

use PHPUnit_Framework_TestCase;

class SingleTableInheritanceTest extends PHPUnit_Framework_TestCase
{
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
}
