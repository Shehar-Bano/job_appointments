<?php

namespace App\Observers;

use App\Models\Position;
use Illuminate\Support\Facades\Cache;

class PositionObserver
{
    /**
     * Handle the Position "created" event.
     */
    public function created(Position $position): void
    {
        $cacheKey = "slots";
        Cache::forget($cacheKey);
    }

    /**
     * Handle the Position "updated" event.
     */
    public function updated(Position $position): void
    {
        $cacheKey = "slots_{$position->id}";
        Cache::forget($cacheKey);
    }

    /**
     * Handle the Position "deleted" event.
     */
    public function deleted(Position $position): void
    {
        $cacheKey = "slots_{$position->id}";
        Cache::forget($cacheKey);
    }

    /**
     * Handle the Position "restored" event.
     */
    public function restored(Position $position): void
    {
        //
    }

    /**
     * Handle the Position "force deleted" event.
     */
    public function forceDeleted(Position $position): void
    {
        //
    }
}
