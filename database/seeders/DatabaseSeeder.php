<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Article;
use App\Models\Subscription;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Author::factory(1)->state(function (array $attr) { return [ 'key' => 'key0', 'website' => 'https://website0.test' ]; })
        ->has(Article::factory()->count(3))->create();

        \App\Models\User::factory(1)->state(function (array $attr) { return [ 'name' => 'user0', 'email' => 'user0@userland.test' ]; })->create();


        \App\Models\Author::factory(2)
        ->sequence(fn (Sequence $sequence) => ['key' => 'key'.($sequence->index+1)])
        ->sequence(fn (Sequence $sequence) => ['website' => 'https://website'.($sequence->index+1).'.test'])
        ->has(Article::factory()->count(3))->create();
        
        \App\Models\User::factory(4)
        ->sequence(fn (Sequence $sequence) => ['name' => 'User'.($sequence->index+1)])
        ->sequence(fn (Sequence $sequence) => ['email' => 'user'.($sequence->index+1)."@userland.test"])
        ->has(Subscription::factory()->count(2))->create();
    }
}
