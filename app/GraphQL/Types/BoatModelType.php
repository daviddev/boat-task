<?php

namespace App\GraphQL\Types;

use App\Models\BoatModel;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class BoatModelType extends GraphQLType
{
    /**
     * @var string[] $attributes
     */
    protected $attributes = [
        'name' => 'BoatModel',
        'description' => 'A boat model',
        'model' => BoatModel::class,
    ];

    /**
     * @return array[]
     */
    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the boat model',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the boat model',
            ],
        ];
    }
}
