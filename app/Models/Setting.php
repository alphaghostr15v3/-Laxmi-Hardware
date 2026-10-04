<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    protected static $cache = null;

    public static function get(string $key, $default = null)
    {
        if (static::$cache === null) {
            static::$cache = static::pluck('value', 'key')->all();
        }
        return static::$cache[$key] ?? $default;
    }

    public static function set(string $key, $value, string $group = 'general')
    {
        $setting = static::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
        if (static::$cache !== null) {
            static::$cache[$key] = $value;
        }
        return $setting;
    }

    public static function getAllSettings(): array
    {
        if (static::$cache === null) {
            static::$cache = static::pluck('value', 'key')->all();
        }
        return static::$cache;
    }
}
