<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([

        	'name' 			=> 'Admin',
        	'slug' 			=> 'admin',
        	'created_at' 	=> now(),
        	'updated_at' 	=> now(),
        ]);

        Role::create([

        	'name' 			=> 'Modarator',
        	'slug' 			=> 'modarator',
        	'created_at' 	=> now(),
        	'updated_at' 	=> now(),
        ]);

        Role::create([

        	'name' 			=> 'Customer',
        	'slug' 			=> 'customer',
        	'created_at' 	=> now(),
        	'updated_at' 	=> now(),
        ]);

        Role::create([

        	'name' 			=> 'User',
        	'slug' 			=> 'user',
        	'created_at' 	=> now(),
        	'updated_at' 	=> now(),
        ]);
    }
}
