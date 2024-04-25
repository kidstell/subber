<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Authors>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $company = strtolower(fake()->unique()->company());
        return [
            'key' => preg_replace('/\W/','', $company),
            'website' => preg_replace('/^((\w*){1,2}).*/', 'https://$1.com', $company),
        ];
    }
}
