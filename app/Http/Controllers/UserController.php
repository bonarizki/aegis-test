<?php

namespace App\Http\Controllers;

use App\Events\AdminNotificationEvent;
use App\Events\UserNotificationEvent;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get pagination parameters
        $page = $request->get('page', 1); // Default page = 1
        $perPage = $request->get('length', 10); // Number of items per page
        $offset = ($page - 1) * $perPage; // Calculate the offset for pagination

        // Get sorting parameters
        $sortBy = $request->get('sortBy', 'created_at'); // Default sorting by 'created_at'
        $sortOrder = $request->get('order', 'desc'); // Default order 'desc'

        // Validate the sortBy column to ensure it is allowed
        $allowedSorts = ['name', 'email', 'created_at']; // List of allowed columns for sorting
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at'; // Use 'created_at' if the sortBy value is not valid
        }

        // Query data with pagination, sorting, and search filtering
        $users = User::query()
            ->offset($offset) // Apply the offset for pagination
            ->limit($perPage) // Limit the number of results per page
            ->orderBy($sortBy, $sortOrder); // Order the results by sortBy and sortOrder

        $data = DataTables::eloquent($users) // Use Yajra Datatables with the User query
            ->filter(function ($query) use ($request) {
                // Get the search parameter for filtering
                $search = $request->get('search');

                if ($search) {
                    $query->where(function ($q) use ($search) {
                        // Filter the results by matching 'name' or 'email' with the search term
                        $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                    });
                }
            })
            ->skipPaging(false) // Enable pagination support in Datatables
            ->with([
                'page' => $request->get('page', 1), // Pass the current page to the frontend
            ])
            ->toJson(); // Return the data as JSON
        
        //custom response and return
        return Response()->json([
            "page" => $page,
            "users" => $data->original['data']
        ]);
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

            // Trigger a notification event for the user, to send a notification about a specific activity or update.
            event(new UserNotificationEvent($user));

            // Trigger a notification event for the admin to inform them about an activity related to the user.
            event(new AdminNotificationEvent($user));

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
