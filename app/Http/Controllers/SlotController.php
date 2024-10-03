<?php

namespace App\Http\Controllers;

use App\Http\Resources\SlotResource;
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
    public function index(Request $request)
    {
       
        $start_time=$request->input('start_time');
        $end_time=$request->input('end_time');
        $limit = $this->getValue($request->input('limit'));
     

        $slots = $this->slot->fetchData($limit, $start_time,  $end_time );

        if(!$slots) {
            return response()->json(['message' => 'No slots found'], 404);
        }

        $data=SlotResource::collection($slots);

        $paginationData=[
            'Recode'=> $data,
            'Pagination_Limit'=>$data->count(),
            
            'Current_Page'=> $data->currentPage(),

            'Total_Recode'=> $data->total(),
        ];
        return response()->json(["data"=>  $paginationData, "success"=>true],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
            'start_time'=>'required',
            'end_time'=>'required',

        ]);

    
        $slot = $this->slot->create($validated);
        if(!$slot){
            return response()->json([
                "message"=>"Failed to create slot",
                "success"=>false
                ],400);
        }
        return response()->json([
      
            "success"=>true,
            "message"=> "Slot Created Successfully"
            ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $slot = $this->slot->show($id);
        if(!$slot) {
            return response()->json(['message' => 'Slot not found'], 404);
            }
            $data = new SlotResource($slot);
            return response()->json(["data"=>  $data, "success"=>true],200);
        }
        catch(\Exception $e){
            return response()->json(['message' =>  $e->getMessage(),], 500);
            }
  }
        
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
     try{
        $validated=$request->validate([
            'start_time'=>'required',
            'end_time'=>'required',
            ]);
            $slot = $this->slot->update($id,$validated);
            if(!$slot){
                return response()->json([
                    "message"=>"Slot not found",
                    "success"=>false
                    ],404);
                }
                
                return response()->json([
                    "success"=>true,
                    "message"=>"Slot Updated Successfully"
                    ],200);

     }
     catch(\Exception $e){
        return response()->json([
            "message"=>$e->getMessage(),
            "success"=>false
            ],500);
            }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       
        $deleted = $this->slot->delete($id);
    
        if ($deleted) {

            return response()->json(["message" => "Slot Deleted Successfully","success" => true
            ], 200);
        } else {
           
            return response()->json(["message" => "Slot Not Found", "success" => false], 404);
        }
    }


}
