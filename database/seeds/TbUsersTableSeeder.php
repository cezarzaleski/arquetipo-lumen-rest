<?php

use Illuminate\Database\Seeder;

class TbUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TbUser::class, 10)->create();
    }
}
