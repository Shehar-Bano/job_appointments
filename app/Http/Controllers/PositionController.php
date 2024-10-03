<?php

namespace App\Http\Controllers;

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
        return response()->json(['message'=> 'Data stored successfully'], 200);
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
            return response()->json('Job updated successfully',200);
        } else {
            return response()->json('Failed to update job', 500);  // Return a 500 error if the update fails
        }
    }
    public function destroy(string $id)
    {
        $updated = $this->job->delete($id);
        if ($updated) {
            return response()->json('Job deleted successfully',200);
        } else {
            return response()->json('Failed to delete job', 500);  // Return a 500 error if the update fails
        }
    }
}
