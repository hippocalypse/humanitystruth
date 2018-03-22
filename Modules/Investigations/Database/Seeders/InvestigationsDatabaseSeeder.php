<?php

namespace Modules\Investigations\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Investigations\Entities\Investigation;

class InvestigationsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Investigation::class, 20)->create();
    }
}
