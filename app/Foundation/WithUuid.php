<?php

declare(strict_types=1);

namespace App\Foundation;

use Illuminate\Database\Eloquent\Model;
use Str;

trait WithUuid
{
    public static function bootWithUuid()
    {
        static::creating(function (Model $user) {
            if (!$user->uuid) {
                $user->uuid = (string) Str::orderedUuid();
            }
        });
    }
}
