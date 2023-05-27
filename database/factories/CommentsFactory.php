<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comments>
 */
class CommentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comment' => fake("id")->sentence(3),
            'user_id' => User::where("is_admin", false)->inRandomOrder()->first()->id,
            'news_id' => News::inRandomOrder()->first()->id,
        ];
    }
}
