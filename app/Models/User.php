<?php

namespace App\Models;

use App\Foundation\WithUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property string $uuid
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $username
 * @property int $telegram_user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductLink[] $productLinks
 * @property-read int|null $product_links_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User whereTelegramUserId($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUsername($value)
 * @method static Builder|User whereUuid($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, WithUuid;

    public $incrementing = false;

    protected $guarded = ['uuid'];

    protected $keyType = 'string';

    protected $primaryKey = 'uuid';

    public static function findByTelegramId($id): ?User
    {
        return static::where('telegram_user_id', $id)->first();
    }

    public function productLinks(): HasMany
    {
        return $this->hasMany(ProductLink::class);
    }
}
