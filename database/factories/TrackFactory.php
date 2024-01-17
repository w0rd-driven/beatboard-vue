<?php

namespace Database\Factories;

use App\Models\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Track>
 */
class TrackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'artist_id' => Artist::factory(),
            'spotify_id' => $this->generateRandomString(22),
            'album_spotify_id' => $this->generateRandomString(22),
            'album_name' => $this->faker->company(),
            'album_image_url' => $this->faker->imageUrl(),
            'album_release_date' => $this->faker->dateTimeThisDecade(),
            'album_total_tracks' => $this->faker->numberBetween(1, 20),
            'name' => $this->faker->company(),
            'popularity' => $this->faker->numberBetween(1, 100),
            'duration_ms' => $this->faker->numberBetween(1),
            'searched_at' => $this->faker->dateTimeThisMonth(),
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
