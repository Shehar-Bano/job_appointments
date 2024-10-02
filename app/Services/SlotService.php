<?php
namespace App\Services;
use App\Models\Slot;

class SlotService
{
    public function all(){
        return Slot::get();
    }

    public function create(Slot $slot)
    {
        return Slot::create($slot);

    }
}
