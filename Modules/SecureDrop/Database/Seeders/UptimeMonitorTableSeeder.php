<?php
namespace Modules\SecureDrop\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SecureDrop\Entities\UptimeMonitor;

class UptimeMonitorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return [
            /*
             * SecureDrop Application Server
             */
            UptimeMonitor::create(['url' => '10.20.2.2']),
            
            /*
             * SecureDrop Monitor Server
             */
            UptimeMonitor::create(['url' => '10.20.3.2']),
            
            /*
             * Web Server
             */
            UptimeMonitor::create(['url' => 'humanitystruth.com'])
        ];
    }
}
