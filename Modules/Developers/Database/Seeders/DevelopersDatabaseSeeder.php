<?php

namespace Modules\Developers\Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;
use Modules\Developers\Entities\Thread;
use Modules\Developers\Entities\Channel;
use Modules\Developers\Entities\Reply;

class DevelopersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 20)->create();
        factory(Thread::class, 20)->create();
        factory(Channel::class, 20)->create();
        factory(Reply::class, 20)->create();
    }
}
