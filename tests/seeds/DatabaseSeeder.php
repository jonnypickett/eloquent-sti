<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('owners')->insert([
            'name' => 'Steve',
        ]);

        DB::table('animals')->insert([
            'subclass_name' => \JonnyPickett\EloquentSTI\Models\Dog::class,
        ]);

        DB::table('animals')->insert([
            'subclass_name' => \JonnyPickett\EloquentSTI\Models\Cat::class,
        ]);

        DB::table('animals_owners')->insert([
            'animal_id' => 1,
            'owner_id'  => 1,
        ]);

        DB::table('animals_owners')->insert([
            'animal_id' => 2,
            'owner_id'  => 1,
        ]);

        DB::table('balls')->insert([
            'color' => 'red',
        ]);

        DB::table('balls_owners')->insert([
            'ball_id'  => 1,
            'owner_id' => 1,
        ]);
    }
}
