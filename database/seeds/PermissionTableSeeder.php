<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'General Settings',
            'items',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission, 'guard_name' => 'manager']);
            foreach (\App\Models\Manager::get() as $index => $item) {
                $item->givePermissionTo($permission);
            }
        }


    }
}
