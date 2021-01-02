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
            'recipients',
            'accountants',
            'users',
            'bills',
            'expenses',
            'cds',//creditor_debtor
            'cds2',//creditor_debtor
            'payments',
        ];

   $permissions_client = [
            'General Settings',
            'bills',
//            'cds',//creditor_debtor
            'payments',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission, 'guard_name' => 'manager']);
            \Spatie\Permission\Models\Permission::create(['name' => $permission, 'guard_name' => 'accountant']);
            foreach (\App\Models\Manager::get() as $index => $item) {
                $item->givePermissionTo($permission);
            }

            foreach (\App\Models\Accountant::get() as $index => $item) {
                $item->givePermissionTo($permission);
            }
        }


    foreach ($permissions_client as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission, 'guard_name' => 'client']);
            foreach (\App\Models\User::get() as $index => $item) {
                $item->givePermissionTo($permission);
            }
        }


    }
}
