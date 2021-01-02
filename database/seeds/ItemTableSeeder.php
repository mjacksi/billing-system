<?php

use Illuminate\Database\Seeder;

class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 3; $i++){
            \App\Models\Item::create([
                'name' => 'item' . $i,
                'unit' => 'unit' . $i,
                'cost_before' =>  $i + 1,
                'cost_after' =>  $i + 10,
                'number' =>  $i + 5,
                'hasNumber' =>  true,
            ]);
        }
    }
}
