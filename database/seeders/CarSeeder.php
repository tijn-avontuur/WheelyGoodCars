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

        Car::factory(250)->create()->each(function ($car) use ($tags) {
            $randomTags = collect($tags)->shuffle()->take(rand(0, 3))->toArray();
            $car->tags()->sync($randomTags);
        });
    }
}