<?php

namespace Database\Seeders;

use App\Models\BoatModel;
use Illuminate\Database\Seeder;

class BoatModelSeeder extends Seeder
{
    /**
     * List of boat models.
     *
     * @var array $models
     */
    private array $models = [
        'Bayliner',
        'Custom',
        'Freeman',
        'Larson',
        'Monterey',
        'Oceanmaster',
        'Parker',
        'Ribcraft',
        'Ring',
        'Rinker',
        'Sea Ray',
        'Sea-Doo',
        'Zodiac',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insertData = [];
        foreach ($this->models as $model) {
            $insertData[] = [
                'name' => $model,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        BoatModel::insert($insertData);
    }
}
