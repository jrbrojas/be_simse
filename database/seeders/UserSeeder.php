<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $u = new User();
        $u->name = "Admin";
        $u->password = 'secret@1234';
        $u->email = "admin@simse.com";
        $u->role_id = 1;
        $u->save();

        $u = new User();
        $u->name = "Usuario";
        $u->password = 'secret@1234';
        $u->email = "usuario@simse.com";
        $u->role_id = 2;
        $u->save();
    }
}
