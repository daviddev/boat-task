<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;

/**
 * @property int $id
 * @property string $email
 * @property string $stripe_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static Builder|User whereEmail($email)
 */
class User extends Model
{
    use HasFactory, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'stripe_id',
    ];
}
