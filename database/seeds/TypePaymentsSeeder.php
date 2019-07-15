<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TypePaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_payments')->insert([
            'id' => 1,
            'name' => 'deposit',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('type_payments')->insert([
            'id' => 2,
            'name' => 'payment',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
