<?php

use Illuminate\Database\Seeder;

class AccountantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 3; $i++) {
            \App\Models\Accountant::query()->create([
                'name' => 'accountant' . $i,
                'email' => 'accountant'. $i .'@gmail.com',
                'password' => bcrypt(123456),
            ]);
        }
    }
}
