<?php

use Illuminate\Database\Seeder;
use App\Affiliate;

class AffiliatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return [
            Affiliate::create(['logo' => 'securedrop.png',        'website' => 'https://securedrop.org/']),
            Affiliate::create(['logo' => 'tails.png',             'website' => 'https://tails.boum.org/']),
            Affiliate::create(['logo' => 'tor.png',               'website' => 'https://www.torproject.org/']),
            Affiliate::create(['logo' => 'bitcoin.png',           'website' => 'https://www.bitcoin.com/']),
            Affiliate::create(['logo' => 'couragefoundation.png', 'website' => 'https://www.couragefound.org/']),
            Affiliate::create(['logo' => 'wikileaks.png',         'website' => 'https://wikileaks.org/']),
            Affiliate::create(['logo' => 'siriusdisclosure.png',  'website' => 'https://siriusdisclosure.com/']),
            Affiliate::create(['logo' => 'etcher.png',            'website' => 'https://etcher.io/']),
            Affiliate::create(['logo' => 'secureteam10.png',      'website' => 'https://www.youtube.com/user/secureteam10']),
            Affiliate::create(['logo' => 'idl_shield.png',        'website' => 'https://internetdefenseleague.org/'])
        ];
    }
}
