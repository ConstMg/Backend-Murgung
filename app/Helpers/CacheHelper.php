<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    // ========== IMAGES ==========
    public static function registerImageCacheKey(string $key): void
    {
        $cacheKeys = Cache::get('images_cache_keys', []);
        $cacheKeys[$key] = true;
        Cache::forever('images_cache_keys', $cacheKeys);
    }

    public static function forgetAllImageCaches(): void
    {
        $cacheKeys = Cache::get('images_cache_keys', []);
        foreach ($cacheKeys as $key => $_) {
            Cache::forget($key);
        }
        Cache::forget('images_cache_keys');
    }

    // ========== PROJECTS ==========
    public static function registerProjectCacheKey(string $key): void
    {
        $cacheKeys = Cache::get('projects_cache_keys', []);
        $cacheKeys[$key] = true;
        Cache::forever('projects_cache_keys', $cacheKeys);
    }

    public static function forgetAllProjectCaches(): void
    {
        $cacheKeys = Cache::get('projects_cache_keys', []);
        foreach ($cacheKeys as $key => $_) {
            Cache::forget($key);
        }
        Cache::forget('projects_cache_keys');
    }
}
