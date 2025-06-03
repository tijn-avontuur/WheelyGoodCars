<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\Tag;
use App\Models\User;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $tags = Tag::all()->pluck('id')->toArray();
        $images = [
            'car_photos/car1.jpg',
            'car_photos/car2.jpg',
            'car_photos/car3.jpg',
            'car_photos/car4.jpg',
            'car_photos/car5.jpg',
        ];

        // Seed 250 random cars
        Car::factory(250)->create()->each(function ($car) use ($tags, $images) {
            $randomTags = collect($tags)->shuffle()->take(rand(0, 3))->toArray();
            $car->tags()->sync($randomTags);

            if (rand(1, 20) === 1) {
                $car->image = null;
            } else {
                $car->image = $images[array_rand($images)];
            }
            $car->save();
        });

        $testUsers = [
            ['email' => 'testuser1@example.com'],
            ['email' => 'testuser2@example.com'],
        ];

        foreach ($testUsers as $userData) {
            $user = User::where('email', $userData['email'])->first();
            if ($user) {
                $car = Car::factory()->create([
                    'user_id' => $user->id,
                    'image' => $images[array_rand($images)],
                ]);
                $randomTags = collect($tags)->shuffle()->take(rand(0, 3))->toArray();
                $car->tags()->sync($randomTags);
            }
        }
    }
}