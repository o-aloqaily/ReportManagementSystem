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
        // DB::table('groups')->insert([
        //     'title' => 'GroupA',
        // ]);

        // DB::table('groups')->insert([
        //     'title' => 'GroupB',
        // ]);

        // $user = App\User::find(1);
        // $user->groups()->attach('GroupA');
        // $user->groups()->attach('GroupB');

        $this->call(UsersTableSeeder::class);

    }
}
