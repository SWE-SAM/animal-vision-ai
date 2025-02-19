<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Image;
use App\Models\User;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'file_path' => $this->faker->imageUrl(),
            'uploadDate' => $this->faker->date(),
            'user_ID' => User::factory(), // Ensures user exists
        ];
    }
}
