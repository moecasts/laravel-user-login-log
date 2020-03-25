<?php

namespace Moecasts\Laravel\UserLoginLog;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Cacher
{
    public static function getCacheKey($loggable)
    {
        return $loggable->getMorphClass() . '-' . $loggable->getKey() . '-login-log';
    }

    public static function getCacheContent($loggable)
    {
        if (!empty($cache = Cache::get(static::getCacheKey($loggable)))) {
            return $cache;
        }

        $cachedAt = Carbon::now();

        return [
            'cachedAt' => $cachedAt,
            'loggable' => $loggable,
        ];
    }

    public static function hasCache($loggable)
    {
        return Cache::has(static::getCacheKey($loggable));
    }

    public static function setCache($loggable, $seconds = null)
    {
        $seconds = $seconds ?? config('loginlog.expire', 60);

        return Cache::put(
            static::getCacheKey($loggable),
            static::getCacheContent($loggable),
            now()->addSeconds($seconds)
        );
    }

    public static function pullCache($loggable)
    {
        return Cache::pull(static::getCacheKey($loggable));
    }
}
