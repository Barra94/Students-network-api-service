<?php

namespace Database\Seeders;

use App\Models\Spot;
use Illuminate\Database\Seeder;

class SpotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Spot::factory()->times(10)->create();
    }
}
