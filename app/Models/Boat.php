<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $boat_model_id
 * @property string $title
 * @property int $price
 * @property string $condition
 * @property string $description
 * @property int $year
 * @property numeric $length
 * @property numeric $beam
 * @property string $fuel_type
 * @property int $fuel_capacity
 * @property int $horsepower
 * @property int $number_of_engines
 * @property int $persons
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read BoatModel $model
 */
class Boat extends Model
{
    use HasFactory;

    const CONDITION_NEW = 'new';
    const CONDITION_USED = 'used';

    const FUEL_TYPE_DIESEL = 'diesel';
    const FUEL_TYPE_PETROL = 'petrol';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'boat_model_id',
        'title',
        'price',
        'condition',
        'description',
        'year',
        'length',
        'beam',
        'fuel_type',
        'fuel_capacity',
        'horsepower',
        'number_of_engines',
        'persons',
    ];

    /**
     * Get the boat's price.
     *
     * @return Attribute
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->attributes['price'] / 100,
        );
    }

    /**
     * Get boat condition types.
     *
     * @return string[]
     */
    public static function getConditions(): array
    {
        return [
            self::CONDITION_NEW,
            self::CONDITION_USED,
        ];
    }

    /**
     * Get boat fuel types.
     *
     * @return string[]
     */
    public static function getFuelTypes(): array
    {
        return [
            self::FUEL_TYPE_PETROL,
            self::FUEL_TYPE_DIESEL,
        ];
    }

    /**
     * BoatModel model relation
     *
     * @return BelongsTo
     */
    public function model(): BelongsTo
    {
        return $this->belongsTo(BoatModel::class, 'boat_model_id', 'id');
    }

    /**
     * BoatImage model relation
     *
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(BoatImage::class);
    }
}
