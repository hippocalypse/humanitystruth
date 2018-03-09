<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AffiliatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('affiliates')->delete();
        DB::table('affiliates')->insert([
            ['name' => 'a1', 'logo' => '1520476793.jpg', 'website' => 'https://humanitystruth.com'],
            ['name' => 'a2', 'logo' => '1520476849.jpg', 'website' => 'https://humanitystruth2.com'],
            ['name' => 'a3', 'logo' => '1520476867.jpg', 'website' => 'https://humanitystruth3.com'],
            ['name' => 'a4', 'logo' => '1520476882.jpg', 'website' => 'https://humanitystruth4.com'],
            ['name' => 'a5', 'logo' => '1520476892.jpg', 'website' => 'https://humanitystruth5.com'],
            ['name' => 'a6', 'logo' => '1520476901.jpg', 'website' => 'https://humanitystruth6.com'],
            ['name' => 'a7', 'logo' => '1520476911.jpg', 'website' => 'https://humanitystruth7.com'],
            ['name' => 'a8', 'logo' => '1520476921.jpg', 'website' => 'https://humanitystruth8.com'],
            ['name' => 'a9', 'logo' => '1520476980.jpg', 'website' => 'https://humanitystruth9.com'],
            ['name' => 'a10', 'logo' => '1520476990.jpg', 'website' => 'https://humanitystruth10.com'],
            ['name' => 'a11', 'logo' => '1520476999.jpg', 'website' => 'https://humanitystruth11.com'],
            ['name' => 'a12', 'logo' => '1520477050.jpg', 'website' => 'https://humanitystruth12.com']
        ]);
    }
}
