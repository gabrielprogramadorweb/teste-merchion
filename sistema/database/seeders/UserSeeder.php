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
                'name' => 'Contratante 01',
                'email' => 'contratante01@flowtask.com',
                'password' => Hash::make('123'),
            ]);

            User::create([
                'name' => 'Freelancer 01',
                'email' => 'freelancer01@flowtask.com',
                'password' => Hash::make('123'),
            ]);

            User::create([
                'name' => 'Admin',
                'email' => 'admin@flowtask.com',
                'password' => Hash::make('123'),
            ]);
        }
    }
