<?php

namespace App\Observers;

use App\Models\Slot;
use Illuminate\Support\Facades\Cache;

class SlotObserver
{
    /**
     * Handle the Slot "created" event.
     */
    public function created(Slot $slot): void
    {
        $cacheKey = "slots";
        Cache::forget($cacheKey);

    }

    /**
     * Handle the Slot "updated" event.
     */
    public function updated(Slot $slot): void
    {
        $cacheKey = "slot_{$slot->id}";
        Cache::forget($cacheKey);
        $cacheKey = "slots";
        Cache::forget($cacheKey);

    }

    /**
     * Handle the Slot "deleted" event.
     */
    public function deleted(Slot $slot): void
    {
        $cacheKey = "slot_{$slot->id}";
        Cache::forget(key: $cacheKey);
        $cacheKey = "slots";
        Cache::forget($cacheKey);

    }

    /**
     * Handle the Slot "restored" event.
     */
    public function restored(Slot $slot): void
    {
        //
    }

    /**
     * Handle the Slot "force deleted" event.
     */
    public function forceDeleted(Slot $slot): void
    {
        $cacheKey = "slot_{$slot->id}";
        Cache::forget($cacheKey);
    }
}
