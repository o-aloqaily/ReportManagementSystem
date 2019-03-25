<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = App\Role::firstOrCreate(['role' => 'Admin'], ['role' => 'Admin']);
        $roleUser = App\Role::firstOrCreate(['role' => 'User'], ['role' => 'Admin']);        

        $user = App\User::firstOrCreate(['id' => 1], ['name' => 'Admin', 'email' => 'admin@rms.com', 'password' => Hash::make('secret')]);
        $user->roles()->attach($roleAdmin);

        $group = App\Group::firstOrCreate(['title' => 'Default Group']);
        $user->groups()->attach($group);

        // $this->call(UsersTableSeeder::class);

        // factory(App\Report::class, 25)->create()->each(function ($report) {
        //     $report->user()->associate(App\User::find(1));
        //     $report->tags()->save(App\Tag::firstOrCreate('testAddingTag'));
        // });


    }
}
