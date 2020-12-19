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
        \App\Models\Accountant::query()->create([
            'name' => 'admin',
            'email' => 'accountant@gmail.com',
            'password' => bcrypt(123456),
        ]);
    }
}
