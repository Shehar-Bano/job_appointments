<?php
namespace App\Http\Controllers;

use App\Http\Resources\SlotResource;
use App\Services\SlotService;
use Illuminate\Http\Request;

/**
  * @OA\Info(title="Interview Appointment API", version="1.0.0")
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Enter your JWT token to access protected routes."
 * )
 * @OA\Schema(
 *     schema="SlotRequest",
 *     type="object",
 *     required={"start_time", "end_time"},
 *     @OA\Property(property="start_time", type="string", format="time", example="09:00:00"),
 *     @OA\Property(property="end_time", type="string", format="time", example="17:00:00"),
 * )
 *
 * @OA\Schema(
 *     schema="Slot",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="start_time", type="string", format="time"),
 *     @OA\Property(property="end_time", type="string", format="time"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 * )
 *  * @OA\Schema(
 *     schema="PositionRequest",
 *     type="object",
 *     title="Position Request",
 *     description="Schema for creating or updating a job position",
 *     required={"title", "job_type", "requirement", "description", "post_date"},
 *     @OA\Property(property="title", type="string", example="Software Engineer", description="Title of the job position"),
 *     @OA\Property(property="job_type", type="string", example="Full-time", enum={"Full-time", "Part-time", "Contract"}, description="Type of job"),
 *     @OA\Property(
 *         property="requirement",
 *         type="array",
 *         @OA\Items(type="string"),
 *         example={"Bachelor's degree in Computer Science", "3+ years of experience"},
 *         description="List of job requirements"
 *     ),
 *     @OA\Property(property="description", type="string", example="Responsibilities include software development, code reviews, and team collaboration.", description="Description of the job position"),
 *     @OA\Property(property="post_date", type="string", format="date", example="2024-11-20", description="Date when the job position is posted"),
 *     @OA\Property(property="status", type="string", example="open", enum={"open", "close"}, description="Status of the job position (open or closed)")
 * )
 * * @OA\Schema(
 *     schema="Position",
 *     type="object",
 *     title="Position",
 *     description="Position model",
 *     required={"title", "job_type", "requirement", "description", "post_date"},
 *     @OA\Property(property="id", type="integer", example=1, description="ID of the position"),
 *     @OA\Property(property="title", type="string", example="Software Engineer", description="Job title"),
 *     @OA\Property(property="job_type", type="string", example="Full-time", description="Type of job"),
 *     @OA\Property(property="requirement", type="array", @OA\Items(type="string"), example={"Bachelor's degree in Computer Science", "3+ years of experience"}),
 *     @OA\Property(property="description", type="string", example="Job description details here", description="Description of the job position"),
 *     @OA\Property(property="post_date", type="string", format="date", example="2024-01-15", description="Date when the position was posted"),
 *     @OA\Property(property="status", type="string", example="open", description="Status of the job position (e.g., open, closed)"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the position was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the position was last updated")
 * )
 */
class SlotController extends Controller
{
    protected $slot;

    public function __construct(SlotService $slotService)
    {
        $this->slot = $slotService;
        
    }

    /**
     * @OA\Get(
     *     path="/api/slots",
     *     tags={"Slots"},
     *  security={{"bearerAuth": {}}},
     *     summary="List all slots",
     *     @OA\Parameter(
     *         name="start_time",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", format="time"),
     *         description="Start time filter"
     *     ),
     *     @OA\Parameter(
     *         name="end_time",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", format="time"),
     *         description="End time filter"
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         description="Pagination limit"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful retrieval of slots",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="Recode", type="array", @OA\Items(ref="#/components/schemas/Slot")),
     *                 @OA\Property(property="Pagination_Limit", type="integer"),
     *                 @OA\Property(property="Current_Page", type="integer"),
     *                 @OA\Property(property="Total_Recode", type="integer"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No slots found"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');
        $limit = $this->getValue($request->input('limit'));
        $page = $request->get('page', 1);

        

        $slots = $this->slot->fetchData($limit, $start_time, $end_time, $page);

        if (! $slots) {
            return response()->json(['message' => 'No slots found'], 404);
        }

        $data = SlotResource::collection($slots);

        $paginationData = [
            'Recode' => $data,
            'Pagination_Limit' => $data->count(),
            'Current_Page' => $data->currentPage(),
            'Total_Recode' => $data->total(),
        ];

        return response()->json(['data' => $paginationData, 'success' => true], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/slots",
     *     security={{"bearerAuth": {}}},
     *     tags={"Slots"},
     *     summary="Create a new slot",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SlotRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Slot created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Failed to create slot"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $slot = $this->slot->create($validated);
        if (! $slot) {
            return response()->json([
                'message' => 'Failed to create slot',
                'success' => false,
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Slot Created Successfully',
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/slots/{id}",
     *  security={{"bearerAuth": {}}},
     *     tags={"Slots"},
     *     summary="Display a specific slot",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Slot ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful retrieval of slot",
     *         @OA\JsonContent(ref="#/components/schemas/Slot")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Slot not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            $slot = $this->slot->show($id);
            if (! $slot) {
                return response()->json(['message' => 'Slot not found'], 404);
            }
            $data = new SlotResource($slot);

            return response()->json(['data' => $data, 'success' => true], 200)->header('Cache-Control', 'public, max-age=50');
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/slots/{id}",
     *  security={{"bearerAuth": {}}},
     *     tags={"Slots"},
     *     summary="Update a specific slot",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Slot ID"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SlotRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Slot updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Slot not found"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        try {
            $validated = $request->validate([
                'start_time' => 'required',
                'end_time' => 'required',
            ]);
            $slot = $this->slot->update($id, $validated);
            if (! $slot) {
                return response()->json([
                    'message' => 'Slot not found',
                    'success' => false,
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Slot Updated Successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/slots/{id}",
     *   security={{"bearerAuth": {}}},
     *     tags={"Slots"},
     *     summary="Delete a specific slot",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Slot ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Slot deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="success", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Slot not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $deleted = $this->slot->delete($id);
        if (! $deleted) {
            return response()->json(['message' => 'Slot not found'], 404);
        }

        return response()->json([
            'message' => 'Slot Deleted Successfully',
            'success' => true,
        ], 200);
    }
}
