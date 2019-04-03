<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            'name' => 'Joe Bloggs',
            'email' => 'joe.bloggs9999@gmail.com',
            'password' => bcrypt('secret'),
            'role' => 'ROLE_USER_ADMIN',
        ]);
        DB::table('suppliers')->insert([
            'name' => 'John Smith',
            'email' => 'john.smith9999@gmail.com',
            'password' => bcrypt('secret'),
            'role' => 'ROLE_SUPPLIER_ADMIN',
        ]);
    }
}
