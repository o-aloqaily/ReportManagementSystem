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

        // DB::table('users')->insert([
        //     'name' => 'User1',
        //     'email' => 'user1@email.com',
        //     'password' => bcrypt('password'),
        // ]);
        // DB::table('users')->insert([
        //     'name' => 'user2',
        //     'email' => 'user2@email.com',
        //     'password' => bcrypt('password'),
        // ]);


        // DB::table('reports')->insert([
        //     'title' => 'report1',
        //     'description' => 'lorem ipsum',
        //     'user_id' => 1,
        // ]);

        // DB::table('reports')->insert([
        //     'title' => 'report2',
        //     'description' => 'lorem ipsum',
        //     'user_id' => 2,
        // ]);

        // DB::table('tags')->insert([
        //     'title' => 'tag1',
        // ]);

        // DB::table('tags')->insert([
        //     'title' => 'tag2',
        // ]);

        DB::table('groups')->insert([
            'title' => 'group1',
        ]);

        DB::table('groups')->insert([
            'title' => 'group2',
        ]);

        // $report = App\Report::find(1);
        // $report->groups()->attach('group1');
        // $report->tags()->attach('tag1');


        // $report = App\Report::find(2);
        // $report->groups()->attach('group2');
        // $report->tags()->attach('tag2');

        $user = App\User::find(1);
        $user->groups()->attach('group1');

    }
}
