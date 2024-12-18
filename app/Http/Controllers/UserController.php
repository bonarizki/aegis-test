<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(UserStoreRequest $request): JsonResponse
    {
        // Hash the password before saving it to ensure it is securely stored
        $request->merge(["password" => Hash::make($request->password)]);

        try {
            // Initialize the $user variable to store the created user
            $user = [];

            // Start a database transaction to ensure all operations are performed atomically
            DB::transaction(function () use ($request, &$user) {
                // Create a new user using the request data and save it to the database
                $user = User::create($request->all());
            });



            // Return the created user as a JSON response
            return response()->json($user);
        } catch (\Throwable $th) {
            // If an error occurs, return a JSON response with an error message
            return response()->json([
                'success' => false,  // Indicates the request failed
                'message' => 'Failed to update user data.',  // General error message
                'error' => $th->getMessage(),  // Specific error message from the caught exception
            ], 500);  // HTTP status code 500 indicating a server error
        }
    }

}
