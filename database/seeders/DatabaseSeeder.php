<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('owners')->insert([
            'name' => 'Bostadsrättsföreningen Uggland',
            'shortname' => 'brfugg',
            'infotext' => 'Välkommen till oss, vad trevligt att du vill ladda här!',
            'min_time' => '02:00:00',
        ]);

        DB::table('chargers')->insert([
            'owner_id' => 1,
            'api' => 'ctek',
        ]);

        \App\Models\User::factory(10)->create();

    }
}
