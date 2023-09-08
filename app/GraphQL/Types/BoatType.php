<?php

namespace App\GraphQL\Types;

use App\Models\Boat;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class BoatType extends GraphQLType
{
    /**
     * @var string[] $attributes
     */
    protected $attributes = [
        'name' => 'Boat',
        'description' => 'A boat',
        'model' => Boat::class,
    ];

    /**
     * @return array[]
     */
    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the boat',
            ],
            'model' => [
                'type' => GraphQL::type('BoatModel'),
                'description' => 'The model of the boat',
            ],
            'images' => [
                'type' => Type::listOf(GraphQL::type('BoatImage')),
                'description' => 'Images of the boat',
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the boat',
            ],
            'price' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The price of the boat',
            ],
            'condition' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The condition of the boat',
            ],
            'description' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The description of the boat',
            ],
            'year' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The year of the boat',
            ],
            'length' => [
                'type' => Type::nonNull(Type::float()),
                'description' => 'The length of the boat',
            ],
            'beam' => [
                'type' => Type::nonNull(Type::float()),
                'description' => 'The beam of the boat',
            ],
            'fuel_type' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The fuel type of the boat',
            ],
            'fuel_capacity' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The fuel capacity of the boat',
            ],
            'horsepower' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The horsepower of the boat',
            ],
            'number_of_engines' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Number of boat engines',
            ],
            'persons' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Number of people in the boat',
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The created at date',
            ],
        ];
    }
}
