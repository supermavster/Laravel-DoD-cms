<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        DB::table('roles')->insert([
            'id' => 2,
            'name' => 'client',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
