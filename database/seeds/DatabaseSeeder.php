<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->adminUserSeed();
        Model::reguard();
    }

    private function adminUserSeed()
    {
        $users = User::where('email', 'admin@example.com')->first();
        if (is_null($users)) {
            User::create([
                'name' => 'admin',
                'email' => 'admin@example.com',
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm' //secret
            ]);
        }
    }
}
