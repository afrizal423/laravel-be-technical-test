<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // print_r(User::where("is_admin", true)->inRandomOrder()->first());
        return [
            'title' => fake("id")->sentence(3),
            'content' => fake("id")->paragraphs(5, true),
            'image_banner' => fake("id")->image(null, 640, 480),
            'user_id' => User::where("is_admin", true)->inRandomOrder()->first()->id
        ];
    }
}
