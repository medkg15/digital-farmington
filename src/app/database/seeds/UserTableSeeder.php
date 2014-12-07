<?php

class UserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();
        User::create(array(
            'name'     => 'Admin',
            'username' => 'admin',
            'email'    => 'admin@stanleywhitman.org',
            'password' => Hash::make(admin_password),
        ));
    }

}