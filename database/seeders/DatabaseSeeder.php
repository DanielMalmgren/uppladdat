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
            'name' => 'Bostadsrättsföreningen Ugglan',
            'shortname' => 'brfugg',
            'infotext' => 'Välkommen till oss, vad trevligt att du vill ladda här!',
            'min_time' => '02:00:00',
            'show_info_page' => false,
        ]);

        DB::table('chargers')->insert([
            'owner_id' => 1,
            'api' => 'ctek',
        ]);

        DB::table('owner_payment_methods')->insert([
            'owner_id' => 1,
            'payment_method' => 'Swish',
            'identifier' => '1231181189',
        ]);

        DB::table('owners')->insert([
            'name' => 'Åhlens Linköping',
            'shortname' => 'linkahl',
            'infotext' => 'Stick och brinn!',
            'min_time' => '04:00:00',
        ]);

        DB::table('chargers')->insert([
            'owner_id' => 2,
            'api' => 'ctek',
        ]);

        DB::table('owner_payment_methods')->insert([
            'owner_id' => 2,
            'payment_method' => 'Swish',
            'identifier' => '1231181189',
        ]);

        \App\Models\User::factory(10)->create();

    }
}
