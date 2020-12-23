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
        for ($i = 1; $i <= 3; $i++){
            \App\Models\User::query()->create([
                'name' => 'client' . $i,
                'email' => 'client'. $i .'@gmail.com',
                'password' => bcrypt(123456),
            ]);
        }

    }
}
