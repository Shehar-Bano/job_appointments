<?php
namespace App\Services;
use App\Models\Slot;

class SlotService
{
    public function fetchData($limit,$start_time,  $end_time){

        $slots= Slot::whereTime($start_time,  $end_time)
        ->paginate($limit);
        if(!$slots){
            return false;

        }
        return $slots;
    }

    public function create( $validated)
    {
        return Slot::create($validated);

    }
    public function show($id){
        $slot= Slot::find($id);
        if(!$slot){
            return false;
        }
        return $slot;

    }
   public function update($id,$validated){
    $slot = Slot::find($id);
    if(!$slot){
        return false;
    }
    return $slot->update($validated);
    }
   


    public function delete($id)
    {
        try {
            $slot = Slot::find($id);
    
            if ($slot) {
                $slot->delete();
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

  
    }

