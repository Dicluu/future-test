<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Contact::factory(100)->create();

        Contact::factory()->create([
           'full_name' => 'Test name',
           'company_name' => 'Test company',
           'phone' => 'test_phone', // специальное значение, которое будет использовано в тестах.
           'email' => 'test_email',
           'date_of_birth' => '2000-01-01',
           'img_url' => 'test_url_img'
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
