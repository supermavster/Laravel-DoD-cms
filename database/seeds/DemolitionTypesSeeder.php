<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DemolitionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('demolition_types')->insert([
            'id' => 1,
            'name' => 'Kitchens',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        DB::table('demolition_types')->insert([
            'id' => 2,
            'name' => 'Bathrooms',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('demolition_types')->insert([
            'id' => 3,
            'name' => 'Drywall',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('demolition_types')->insert([
            'id' => 4,
            'name' => 'Doors',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('demolition_types')->insert([
            'id' => 5,
            'name' => 'Trim',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('demolition_types')->insert([
            'id' => 6,
            'name' => 'Tile Flooring',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('demolition_types')->insert([
            'id' => 7,
            'name' => 'Carpet',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('demolition_types')->insert([
            'id' => 8,
            'name' => 'Insulation',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('demolition_types')->insert([
            'id' => 9,
            'name' => 'Popcorn ceilings',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        DB::table('demolition_types')->insert([
            'id' => 10,
            'name' => 'Cabinet tops',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        DB::table('demolition_types')->insert([
            'id' => 11,
            'name' => 'Trash',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        DB::table('demolition_types')->insert([
            'id' => 12,
            'name' => 'Shelving',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        DB::table('demolition_types')->insert([
            'id' => 13,
            'name' => 'Docks',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        DB::table('demolition_types')->insert([
            'id' => 14,
            'name' => 'Lifts',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        DB::table('demolition_types')->insert([
            'id' => 15,
            'name' => 'Pavers',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        DB::table('demolition_types')->insert([
            'id' => 16,
            'name' => 'Asphalt',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        DB::table('demolition_types')->insert([
            'id' => 17,
            'name' => 'Concret(non-structural)',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
