<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Traits\HandlesNotFoundTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;


class AuthController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $token = auth()->user()->createToken('AppName', ['*'])->accessToken;

            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user);
    }

    /**
     * @group User Management
     *
     * APIs for managing users
     */

    public function store(Request $request)
    {
        $user = User::create($request->all());
        return new UserResource($user);
    }

    public function update(Request $request, $id)
    {
        // Check if the user exists
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Validate and get the 'id' from the payload
        $validator = Validator::make($request->all(), [
            'id' => 'nullable|numeric|in:' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Update other fields
        $user->update($request->except(['id', 'password']));

        // Update password if provided in the request
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->input('password'))]);
        }

        return new UserResource($user);
    }

    public function destroy($id)
    {
        // Find the user
        $user = User::find($id);
        // If user is not found, return JSON response
        if (!$user) {
            return response()->json(['error' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }
        // Delete the user
        $user->delete();
        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }

    public function sendPasswordResetEmail(Request $request)
    {
        $response = Password::sendResetLink($request->only('email'));
        // Check the response to handle success or failure
    }

    public function reset(Request $request)
    {

        // Validate the payload
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'old_password' => 'required|string',
            'new_password' => 'required|string|',
        ]);

        //check if fail the validation
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Retrieve the user based on email and old password
        $user = User::where('email', $request->email)->first();

        //tinker
        // $searchTerm = 'eduard';
        // $users = \App\Models\User::where('email', 'like', '%' . $searchTerm . '%')->get();

        if (!$user || !Hash::check($request->old_password, $user->password)) {
            return response()->json(['error' => 'Invalid email or old password'], 401);
        }

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();


        return response()->json(['message' => 'Password reset successfully']);
    }

    public function activate(Request $request, $token)
    {
        $credentials = $request->only('email', 'password', 'password_confirmation'); //'token'

        $user = User::where('id', $token)->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid activation token'], 404);
        }

        $password = request('password');
        $user->password = bcrypt($password);
        $user->save();

        // $user->activate();

        return response()->json(['message' => 'Your account has been activated. You can now log in.']);
    }

    public function logout(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        if ($user && $user->token()) {
            // Revoke the user's access token
            $user->token()->revoke();

            return response()->json(['message' => 'Successfully logged out']);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
