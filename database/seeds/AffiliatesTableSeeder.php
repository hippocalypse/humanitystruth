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
            ['logo' => 'securedrop.png',        'website' => 'https://securedrop.org/'],
            ['logo' => 'tails.png',             'website' => 'https://tails.boum.org/'],
            ['logo' => 'tor.png',               'website' => 'https://www.torproject.org/'],
            ['logo' => 'bitcoin.png',           'website' => 'https://www.bitcoin.com/'],
            ['logo' => 'couragefoundation.png', 'website' => 'https://www.couragefound.org/'],
            ['logo' => 'wikileaks.png',         'website' => 'https://wikileaks.org/'],
            ['logo' => 'siriusdisclosure.png',  'website' => 'https://siriusdisclosure.com/'],
            ['logo' => 'secureteam10.png',      'website' => 'https://www.youtube.com/user/secureteam10']
        ]);
    }
}
