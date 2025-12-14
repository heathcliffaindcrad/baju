<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_name',
        'store_address',
        'store_phone',
        'store_email',
        'promo_text',
        'low_stock_threshold'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            cache()->forget('app_settings');
        });
    }

    public static function getSettings()
    {
        return cache()->rememberForever('app_settings', function () {
            return self::first() ?? new self();
        });
    }
}