<?php

use Illuminate\Database\Seeder;

class CdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cd1 = \App\Models\CDs::create([
            'user_id' => 1,
            'manager_id' => 1,
            'amount' => 90,
            'status' => false,
        ]);
        $getLastId = (\App\Models\CDs::count() > 0) ? \App\Models\CDs::get()->last()->id : '1';
        $cd1->update([
            'uuid' =>  date('Y') . date('m') . $getLastId
        ]);

        $cd1->payments()->create([
            'amount' => 30,
            'user_id' => 1,
            'type' => \App\Models\Payment::CDS,
        ]);
        $cd1->payments()->create([
            'type' => \App\Models\Payment::CDS,
            'user_id' => 1,
            'amount' => 30,
        ]);
        $cd1->payments()->create([
            'type' => \App\Models\Payment::CDS,
            'user_id' => 1,
            'amount' => 30,
        ]);

        for ($i = 1; $i <= 3; $i++) {
          $cd1 =   \App\Models\CDs::create([
                'user_id' => 1,
                'manager_id' => 1,
                'amount' => $i * 10,
                'status' => false,
            ]);
            $getLastId = (\App\Models\CDs::count() > 0) ? \App\Models\CDs::get()->last()->id : '1';
            $cd1->update([
                'uuid' =>  date('Y') . date('m') . $getLastId
            ]);

        }
    }
}
