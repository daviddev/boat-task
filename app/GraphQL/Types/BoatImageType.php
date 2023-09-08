<?php

namespace App\GraphQL\Types;

use App\Models\BoatImage;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class BoatImageType extends GraphQLType
{
    /**
     * @var string[] $attributes
     */
    protected $attributes = [
        'name' => 'BoatImage',
        'description' => 'A boat image',
        'model' => BoatImage::class,
    ];

    /**
     * @return array[]
     */
    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the boat image',
            ],
            'url' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The url of the boat image',
            ],
        ];
    }
}
