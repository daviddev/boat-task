<?php

namespace Database\Seeders;

use App\Models\Boat;
use App\Models\BoatImage;
use Illuminate\Database\Seeder;

class BoatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Boat::factory(100)->create()->each(
            fn($item) => $item->images()->saveMany(
                BoatImage::factory(rand(2, 3))->make([
                    'url' => fake()->imageUrl(640, 400, "Boat {$item->id}", null, 'Image')
                ])
            )
        );
    }
}
