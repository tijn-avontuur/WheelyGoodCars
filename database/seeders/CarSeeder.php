<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\Tag;

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

        Car::factory(250)->create()->each(function ($car) use ($tags, $images) {
            $randomTags = collect($tags)->shuffle()->take(rand(0, 3))->toArray();
            $car->tags()->sync($randomTags);

            // Random image
            $car->image = $images[array_rand($images)];
            $car->save();
        });
    }
}