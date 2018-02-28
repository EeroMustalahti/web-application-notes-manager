<?php

use Illuminate\Database\Seeder;

class RolesAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Role::create(['name' => 'admin', 'label' => 'Admin of this site']);
        \App\Role::create(['name' => 'moderator', 'label' => 'Moderator of this site']);

        \App\Permission::create(['name' => 'can-edit-notes', 'label' => 'Can edit all users\' notes']);
        \App\Permission::create(['name' => 'can-delete-notes', 'label' => 'Can delete all users\' notes']);
        \App\Permission::create(['name' => 'can-make-modes', 'label' => 'Can give or remove moderator privileges']);
        \App\Permission::create(['name' => 'can-delete-users', 'label' => 'Can delete users']);

        \App\Role::first()->permissions()->attach(\App\Permission::first());
        \App\Role::first()->permissions()->attach(\App\Permission::find(2));
        \App\Role::first()->permissions()->attach(\App\Permission::find(3));
        \App\Role::first()->permissions()->attach(\App\Permission::find(4));

        \App\Role::find(2)->permissions()->attach(\App\Permission::first());
        \App\Role::find(2)->permissions()->attach(\App\Permission::find(2));
    }
}
