<?php

namespace App\Models;

use App\Foundation\WithUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ProductLink
 *
 * @property string $uuid
 * @property string $url
 * @property string $user_uuid
 * @property \Illuminate\Support\Carbon|null $notified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static Builder|ProductLink newModelQuery()
 * @method static Builder|ProductLink newQuery()
 * @method static Builder|ProductLink notNotified()
 * @method static Builder|ProductLink query()
 * @method static Builder|ProductLink whereCreatedAt($value)
 * @method static Builder|ProductLink whereNotifiedAt($value)
 * @method static Builder|ProductLink whereUpdatedAt($value)
 * @method static Builder|ProductLink whereUrl($value)
 * @method static Builder|ProductLink whereUserUuid($value)
 * @method static Builder|ProductLink whereUuid($value)
 * @mixin \Eloquent
 * @mixin Builder
 */
class ProductLink extends Model
{
    use HasFactory, WithUuid;

    public $incrementing = false;

    protected $guarded = ['uuid'];

    protected $keyType = 'string';

    protected $primaryKey = 'uuid';

    protected $dates = ['notified_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope Not Notified
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeNotNotified($query)
    {
        return $query->whereNull('notified_at');
    }
}
