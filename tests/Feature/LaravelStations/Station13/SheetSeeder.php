<?php

namespace Database\Seeders;

use App\Models\Sheet;
use Illuminate\Database\Seeder;

class SheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = ['A', 'B', 'C'];
        foreach ($rows as $row) {
            for ($i = 1; $i <= 5; $i++) {
                Sheet::create(['row' => $row, 'column' => $i]);
            }
        }
    }
}