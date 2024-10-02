<?php

namespace App\Http\Controllers;

use App\Services\SlotService;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    protected $slot;
    public function __construct(SlotService $slotService)
    {
        $this->slot = $slotService;
        }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slots = $this->slot->all();
        return response()->json([
            "data"=> $slots,
            "success"=>true
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
