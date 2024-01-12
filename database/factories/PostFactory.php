<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'category_id'=>Category::Factory()->create(),
            'user_id'=>User::Factory()->create(),
            'slug'=>fake()->slug(),
            'title'=>fake()->jobTitle(),
            'exerpts'=> '<p>' . implode('</p><p>',fake()->paragraphs(2)) . '</p>',
            'body'=>'<p>' . implode('</p><p>',fake()->paragraphs(6)) . '</p>'
        ];
    }
}
