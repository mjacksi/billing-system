<?php

use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::query()->create([
            'name' => 'client',
            'email' => 'client@gmail.com',
            'password' => bcrypt(123456),
        ]);
    }
}
