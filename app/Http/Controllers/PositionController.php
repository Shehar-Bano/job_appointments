<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Helpers\ResponseHelper;
use App\Http\Requests\PositionStoreRequest;
use App\Repositories\PositionRepositoryInterface;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $job ;
    public function __construct(public PositionRepositoryInterface $jobs)
    {
        $this->job = $jobs;
    }
    public function index(){
        return $this->job->index();

    }
    public function store( PositionStoreRequest  $request)
    {
        $data = [
        'title' => $request->input('title'),
        'job_type' => $request->input('job_type'),
        'requirement' => json_encode($request->input('requirement')),
        'description' => $request->input('description'),
        'post_date' => $request->input('post_date'), // Ensure this is included
    ];
        $this->job->create($data);
        return ResponseHelper::success("data stored successfully",200);
    }
    public function show(string $id)
    {
        return $this->job->show($id);
    }
    public function update( PositionStoreRequest  $request, string $id)
    {
        $data = [
            'title' => $request->input('title'),
            'job_type' => $request->input('job_type'),
            'requirement' => json_encode($request->input('requirement')),  // Convert requirement array to JSON
            'description' => $request->input('description'),
            'post_date' => $request->post_date
        ];
        $updated = $this->job->update($id, $data);
        if ($updated) {
            return ResponseHelper::successMessage('Job updated successfully',200);
        } else {
            return ResponseHelper::error('Something went wrong', 500);
        }
    }
    public function destroy(string $id)
    {
        $updated = $this->job->delete($id);
        if ($updated) {
            return ResponseHelper::successMessage('Job deleted successfully',200);
        } else {
            return ResponseHelper::error('Failed to delete job', 500);  // Return a 500 error if the update fails
        }
    }
    public function changeStatus($id){
        $position=Position::find($id);
        if(!$position){
            return false;
            }
            $position->status=$position->status=='open'?'close':'open';
            $position->save();
            return $position;
    }
}
