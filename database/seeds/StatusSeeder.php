<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert([
            'id' => 1,
            'name' => 'Requested',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('status')->insert([
            'id' => 2,
            'name' => 'Wait For Visit',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        DB::table('status')->insert([
            'id' => 3,
            'name' => 'Quoted',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        DB::table('status')->insert([
            'id' => 4,
            'name' => 'Scheduled',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('status')->insert([
            'id' => 5,
            'name' => 'Attended',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('status')->insert([
            'id' => 6,
            'name' => 'Paid Out',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        DB::table('status')->insert([
            'id' => 7,
            'name' => 'Cancel',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
