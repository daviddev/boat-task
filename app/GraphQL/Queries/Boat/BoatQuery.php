<?php

namespace App\GraphQL\Queries\Boat;

use App\Models\Boat;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class BoatQuery extends Query
{
    /**
     * @var string[] $attributes
     */
    protected $attributes = [
        'name' => 'boat',
    ];

    /**
     * @return Type
     */
    public function type(): Type
    {
        return GraphQL::type('Boat');
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
                'rules' => ['required', 'integer', 'exists:boats,id'],
            ]
        ];
    }

    /**
     * @param $root
     * @param array $args
     * @return Boat
     */
    public function resolve($root, array $args): Boat
    {
        return Boat::findOrFail($args['id']);
    }
}
