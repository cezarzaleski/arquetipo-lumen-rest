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
        DB::table('tb_users')->insert([
            'name' => 'arquetipo',
            'email' => 'arquetipo@email.com',
            'password' => password_hash('123456', PASSWORD_BCRYPT),
        ]);
        factory(App\TbUser::class, 10)->create();
    }
}
