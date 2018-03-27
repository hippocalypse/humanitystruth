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
        $this->call(AffiliatesTableSeeder::class);
        $this->call(ExcerptTableSeeder::class);
        $this->call(CarrierTableSeeder::class);
        $this->call(Modules\Investigations\Database\Seeders\InvestigationsDatabaseSeeder::class);
        $this->call(Modules\Developers\Database\Seeders\DevelopersDatabaseSeeder::class);
    }
}
