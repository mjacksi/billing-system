<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(ManagerTableSeeder::class);
         $this->call(AccountantsTableSeeder::class);
         $this->call(ClientTableSeeder::class);
         $this->call(ItemTableSeeder::class);
         $this->call(PermissionTableSeeder::class);



        $this->call(SettingsSeeder::class);
//        $this->call(CategoryTableSeeder::class);

//        $this->call(ISeedOauthPersonalAccessClientsTableSeeder::class);
//        $this->call(ISeedOauthClientsTableSeeder::class);

    }
}
