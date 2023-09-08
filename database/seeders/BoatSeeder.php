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
            function ($item) {
                $count = rand(2, 5);
                for ($i = 1; $i <= $count; $i++) {
                    $item->images()->save(
                        BoatImage::factory()->make([
                            'url' => fake()->imageUrl(640, 400, "Boat {$item->id}", null, "Image {$i}")
                        ])
                    );
                }
            }
        );
    }
}
