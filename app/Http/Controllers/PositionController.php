<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\PositionStoreRequest;
use App\Models\Position;
use App\Repositories\PositionRepositoryInterface;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

/**
 * @OA\Tag(
 *     name="Positions",
 *     description="API Endpoints for managing job positions"
 * )
 */
    protected $job;

    public function __construct(public PositionRepositoryInterface $jobs)
    {
        $this->job = $jobs;
    }

    /**
     * @OA\Get(
     *     path="/api/positions",
     *  security={{"bearerAuth": {}}},
     *     tags={"Position"},
     *     summary="Get a list of job positions",
     *     @OA\Response(response=200, description="List of job positions retrieved successfully"),
     * )
     */
    public function index()
    {
        return $this->job->index();

    }
     /**
     * @OA\Post(
     *     path="/api/positions",
     * security={{"bearerAuth": {}}},
     *     tags={"Position"},
     *     summary="Store a new job position",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "job_type", "requirement", "description", "post_date"},
     *             @OA\Property(property="title", type="string", example="Software Engineer"),
     *             @OA\Property(property="job_type", type="string", example="Full-time"),
     *             @OA\Property(property="requirement", type="array", @OA\Items(type="string"), example={"Bachelor's degree in Computer Science", "3+ years of experience"}),
     *             @OA\Property(property="description", type="string", example="Responsible for developing applications."),
     *             @OA\Property(property="post_date", type="string", format="date", example="2024-10-10")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Job position stored successfully"),
     *     @OA\Response(response=400, description="Bad Request"),
     * )
     */
    public function store(PositionStoreRequest $request)
    {
        $data = [
            'title' => $request->input('title'),
            'job_type' => $request->input('job_type'),
            'requirement' => json_encode($request->input('requirement')),
            'description' => $request->input('description'),
            'post_date' => $request->input('post_date'), // Ensure this is included
        ];
        $this->job->create($data);

        return ResponseHelper::success('data stored successfully', 201);
    }
     
     /**
     * @OA\Get(
     *     path="/api/positions/{id}",
     * security={{"bearerAuth": {}}},
     *     tags={"Position"},
     *     summary="Get job position details",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", example="1")),
     *     @OA\Response(response=200, description="Job position retrieved successfully"),
     *     @OA\Response(response=404, description="Job position not found"),
     * )
     */
    public function show(string $id)
    {
        return $this->job->show($id);
    }
      /**
     * @OA\Put(
     *     path="/api/positions/{id}",
     * security={{"bearerAuth": {}}},
     *     tags={"Position"},
     *     summary="Update a job position",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", example="1")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "job_type", "requirement", "description", "post_date"},
     *             @OA\Property(property="title", type="string", example="Senior Software Engineer"),
     *             @OA\Property(property="job_type", type="string", example="Full-time"),
     *             @OA\Property(property="requirement", type="array", @OA\Items(type="string"), example={"Master's degree in Computer Science", "5+ years of experience"}),
     *             @OA\Property(property="description", type="string", example="Responsible for leading development teams."),
     *             @OA\Property(property="post_date", type="string", format="date", example="2024-10-10")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Job position updated successfully"),
     *     @OA\Response(response=404, description="Job position not found"),
     * )
     */
    public function update(PositionStoreRequest $request, string $id)
    {
        $data = [
            'title' => $request->input('title'),
            'job_type' => $request->input('job_type'),
            'requirement' => json_encode($request->input('requirement')),  // Convert requirement array to JSON
            'description' => $request->input('description'),
            'post_date' => $request->post_date,
        ];
        $updated = $this->job->update($id, $data);
        if ($updated) {
            return ResponseHelper::successMessage('Job updated successfully', 200);
        } else {
            return ResponseHelper::error('Something went wrong', 500);
        }
    }
     /**
     * @OA\Delete(
     *     path="/api/positions/{id}",
     * security={{"bearerAuth": {}}},
     *     tags={"Position"},
     *     summary="Delete a job position",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", example="1")),
     *     @OA\Response(response=200, description="Job position deleted successfully"),
     *     @OA\Response(response=404, description="Job position not found"),
     * )
     */
    public function destroy(string $id)
    {
        $updated = $this->job->delete($id);
        if ($updated) {
            return ResponseHelper::successMessage('Job deleted successfully', 200);
        } else {
            return ResponseHelper::error('Failed to delete job', 500);  // Return a 500 error if the update fails
        }
    }
 /**
     * @OA\Post(
     *     path="/api/positions/change-status/{id}",
     * security={{"bearerAuth": {}}},
     *     tags={"Position"},
     *     summary="Change the status of a job position",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", example="1")),
     *     @OA\Response(response=200, description="Job position status changed successfully"),
     *     @OA\Response(response=404, description="Job position not found"),
     * )
     */
    public function changeStatus($id)
    {
        $position = Position::find($id);
        if (! $position) {
            return false;
        }
        $position->status = $position->status == 'open' ? 'close' : 'open';
        $position->save();

        return $position;
    }
}
