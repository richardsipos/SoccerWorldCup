<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $eventValues = ['gól', 'öngól', 'sárga lap','piros lap'];

        return [
            'type' => $eventValues[rand(0,3)],
            'minute'=>rand(0,90)
        ];
    }
}
