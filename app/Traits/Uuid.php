<?php

namespace App\Traits;

use Illuminate\Support\Str;

/**
 * Trait Uuid.
 */
trait Uuid
{

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
}
