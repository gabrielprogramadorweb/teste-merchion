<?php

    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\Hash;
    use App\Models\User;

    class UserSeeder extends Seeder
    {
        public function run(): void
        {
            User::create([
                'name' => 'Usuario 01',
                'email' => 'usuario01@flowtask.com',
                'password' => Hash::make('@Flowtask123'),
            ]);

            User::create([
                'name' => 'Usuario 02',
                'email' => 'usuario02@flowtask.com',
                'password' => Hash::make('@Flowtask123'),
            ]);

            User::create([
                'name' => 'Admin',
                'email' => 'admin@flowtask.com',
                'password' => Hash::make('@Flowtask123'),
            ]);
        }
    }
