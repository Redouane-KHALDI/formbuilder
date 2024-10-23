<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\FormField;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@payd.io',
        ]);

        $countries = [
            ['name' => 'United Kingdom', 'code' => 'UK'],
            ['name' => 'Canada', 'code' => 'CA'],
            ['name' => 'Australia', 'code' => 'AU'],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }

        $fields = [
            ['country_id' => 1, 'name' => 'fullname', 'type' => 'text', 'required' => '1', 'category' => 'general'],
            ['country_id' => 1, 'name' => 'email', 'type' => 'email', 'required' => '1', 'category' => 'general'],
            ['country_id' => 1, 'name' => 'password', 'type' => 'password', 'required' => '1', 'category' => 'general'],
        ];

        foreach ($fields as $field) {
            FormField::create($field);
        }
    }
}
