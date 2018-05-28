<?php

use App\Role;
use App\Admin;
use Illuminate\Database\Seeder;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_role = Role::where('slug','admin')->first();
        $admin = new Admin;
        $admin->name = "Md Abu Ahsan Basir";
        $admin->email = "maab.tips@gmail.com";
        $admin->password = Hash::make("Abuahsan91@");
        $admin->active = 1;
        $admin->save();
        $admin->role()->attach($admin_role);
    }
}
