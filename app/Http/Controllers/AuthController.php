<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="API Endpoints for user authentication"
 * )
 * /**
 * @OA\Schema(
 *     schema="UserRegisterRequest",
 *     type="object",
 *     title="User Registration Request",
 *     description="Request body for registering a new user",
 *     required={"name", "email", "password"},
 *     @OA\Property(property="name", type="string", example="John Doe", description="Name of the user"),
 *     @OA\Property(property="email", type="string", format="email", example="johndoe@example.com", description="Email of the user"),
 *     @OA\Property(property="password", type="string", format="password", example="password123", description="Password for the user account")
 * )
 * /**
 * @OA\Schema(
 *     schema="UserLoginRequest",
 *     type="object",
 *     title="User Login Request",
 *     description="Request body for logging in a user",
 *     required={"email", "password"},
 *     @OA\Property(property="email", type="string", format="email", example="johndoe@example.com", description="Email of the user"),
 *     @OA\Property(property="password", type="string", format="password", example="password123", description="Password for the user account")
 * )
  * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *     description="User model",
 *     required={"name", "email", "password"},
 *     @OA\Property(property="id", type="integer", example=1, description="ID of the user"),
 *     @OA\Property(property="name", type="string", example="John Doe", description="Name of the user"),
 *     @OA\Property(property="email", type="string", format="email", example="johndoe@example.com", description="Email of the user"),
 *     @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true, description="Timestamp when the user's email was verified"),
 *     @OA\Property(property="password", type="string", example="password123", description="Password of the user"),
 *     @OA\Property(property="remember_token", type="string", nullable=true, description="Token used for remembering the user"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the user was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the user was last updated")
 * )
 */

 


class AuthController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/auth/list",
     *     tags={"Auth"},
     *     summary="Get a list of all users",
     *     @OA\Response(response=200, description="List of all users retrieved successfully"),
     * )
     */
    public function index()
    {
        $user = User::get();

        return response()->json([
            'message' => 'all users',
            'data' => $user,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/signup",
     *     tags={"Auth"},
     *     summary="Register a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(response=201, description="User registered successfully"),
     *     @OA\Response(response=400, description="Bad Request"),
     * )
     */
    public function register(Request $request)
    {
        $validatedata = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        $user = User::create([
            'name' => $validatedata['name'],
            'email' => $validatedata['email'],
            'password' => bcrypt($validatedata['password']),
        ]);

        $token = auth('api')->login($user);

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Auth"},
     *     summary="Login a user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(response=200, description="User logged in successfully"),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        $credentials = $request->only('email', 'password');
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'The provided credentials do not match our records.',
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Get(
     *     path="/api/auth/me",
     *     tags={"Auth"},
     *     summary="Get the authenticated user",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="Authenticated user retrieved successfully"),
     * )
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     tags={"Auth"},
     *     summary="Logout a user",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="Successfully logged out"),
     * )
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/refresh",
     *     tags={"Auth"},
     *     summary="Refresh token",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="Token refreshed successfully"),
     * )
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * @OA\Get(
     *     path="/api/auth/refresh",
     *     tags={"Auth"},
     *     summary="Get new token after refresh",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="New access token retrieved successfully"),
     * )
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
    }
}
