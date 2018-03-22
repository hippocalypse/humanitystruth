<?php

namespace Modules\Developers\Database\Seeders;

use Illuminate\Database\Seeder;

class DevelopersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory seed the forums
        $this->call(Modules\Developers\Database\factories\DevelopersModuleFactory::class);

        // $this->call("OthersTableSeeder");
    }
}
