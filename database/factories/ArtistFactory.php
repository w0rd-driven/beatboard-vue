<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artist>
 */
class ArtistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'spotify_id' => $this->generateRandomString(22),
            'name' => $this->faker->company(),
            'image_url' => $this->faker->imageUrl(),
            'follower_count' => $this->faker->numberBetween(1),
            'last_searched_at' => $this->faker->dateTimeThisMonth(),
        ];
    }

    // Taken from https://github.com/JonPurvis/faker-stripe/blob/main/src/Stripe.php, I didn't want the whole provider for an ascii randomizer
    private function generateRandomString($length = 24, $numericOnly = false): string
    {
        if ($numericOnly) {
            $characters = '0123456789';
        } else {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        $string = '';
        $max = strlen($characters) - 1;

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, $max)];
        }

        return $string;
    }
}
