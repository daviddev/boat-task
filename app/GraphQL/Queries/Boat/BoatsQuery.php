<?php

namespace App\GraphQL\Queries\Boat;

use App\Models\Boat;
use GraphQL\Type\Definition\Type;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class BoatsQuery extends Query
{
    /**
     * @var string[] $attributes
     */
    protected $attributes = [
        'name' => 'boats',
    ];

    /**
     * @return Type
     */
    public function type(): Type
    {
        return GraphQL::paginate('Boat');
    }

    /**
     * @return array[]
     */
    public function args(): array
    {
        return [
            'model' => [
                'name' => 'model',
                'type' => Type::int(),
                'rules' => ['integer', 'exists:boat_models,id'],
            ],
            'condition' => [
                'name' => 'condition',
                'type' => Type::string(),
                'rules' => ['string', Rule::in(Boat::getConditions())],
            ],
            'fuel_type' => [
                'name' => 'fuel_type',
                'type' => Type::string(),
                'rules' => ['string', Rule::in(Boat::getFuelTypes())],
            ],
            'sort_by_field' => [
                'name' => 'sort_by_field',
                'type' => Type::string(),
                'rules' => ['string', 'in:title,condition,fuel_type,model_name'],
            ],
            'sort_by_type' => [
                'name' => 'sort_by_type',
                'type' => Type::string(),
                'rules' => ['required_with:sort_by_field', 'string', 'in:asc,desc'],
            ],
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
                'rules' => ['integer', 'min:1'],
            ],
            'page' => [
                'name' => 'page',
                'type' => Type::int(),
                'rules' => ['integer', 'min:1'],
            ],
        ];
    }

    /**
     * @param $root
     * @param array $args
     * @return LengthAwarePaginator
     */
    public function resolve($root, array $args): LengthAwarePaginator
    {
        return Boat::query()
            ->withAggregate('model', 'name')
            ->when(
                isset($args['model']),
                fn($q) => $q->whereBoatModelId($args['model'])
            )
            ->when(
                isset($args['condition']),
                fn($q) => $q->whereCondition($args['condition'])
            )
            ->when(
                isset($args['fuel_type']),
                fn($q) => $q->whereFuelType($args['fuel_type'])
            )
            ->when(
                isset($args['sort_by_field']),
                fn($q) => $q->orderBy($args['sort_by_field'], $args['sort_by_type'])
            )
            ->paginate($args['limit'] ?? 20, ['*'], 'page', $args['page'] ?? 1);
    }
}
