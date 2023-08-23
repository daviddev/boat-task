<?php

namespace App\GraphQL\Queries\BoatModel;

use App\Models\BoatModel;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\Collection;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class BoatModelsQuery extends Query
{
    /**
     * @var string[] $attributes
     */
    protected $attributes = [
        'name' => 'boat_models',
    ];

    /**
     * @return Type
     */
    public function type(): Type
    {
        return Type::listOf(GraphQL::type('BoatModel'));
    }

    /**
     * @return array[]
     */
    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::string(),
            ]
        ];
    }

    /**
     * @return Collection
     */
    public function resolve(): Collection
    {
        return BoatModel::all();
    }
}
