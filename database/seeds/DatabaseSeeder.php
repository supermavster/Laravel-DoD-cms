<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        self::truncateTables([
            'demolition_types',
            'questions',
            'roles',
            'status',
            'type_payments'
        ]);

        $this->call(DemolitionTypeSeeder::class);
        $this->call(QuestionsSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(TypePaymentsSeeder::class);
    }

    /**
     *
     * @param array $tables
     */
    public function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
