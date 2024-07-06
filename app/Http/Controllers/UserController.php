<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Example: Fetch user data
        $user = auth()->user(); // Get the authenticated user
        return view('users.index', compact('user'));
    }

    public function getUserDetails()
    {
        // https://laravel.com/docs/10.x/eloquent-relationships#eager-loading-specific-columns
        $user = auth()->user()->only('id', 'username', 'email', 'profile_picture');

        return response()->json($user);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json(['text' => 'Successfully retrieved user information.', 'data' => $user, 'status' => 200]);
        } catch (Exception $e) {
            return response()->json(['text' => 'There is an error getting user information.', 'error' => $e->getMessage(), 'status' =>  400]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $request->validate([
            'profile_picture' => 'image|mimes:jpeg,png,jpg|max:2048', // Adjust file size and types as needed
        ]);

        try {
            $user = User::findOrFail($id);
            $user->update([
                'username' => $request->username,
                'email' => $request->email
            ]);

            if ($request->has('old_password') && $request->has('new_password') && $request->has('confirm_password')) {
                if (Hash::check($request->old_password, $user->password)) {

                    if ($request->new_password === $request->confirm_password) {
                        $user->update([
                            'password' => $request->new_password,
                        ]);

                        return response()->json(['text' => 'Password updated successfully', 'status' => 200]);
                    } else {
                        return response()->json(['text' => 'New password and confirm password do not match', 'status' => 400]);
                    }
                } else {
                    return response()->json(['text' => 'Old password does not match', 'status' => 400]);
                }
            }

            if ($request->hasFile('profile_picture')) {
                $avatar = $request->file('profile_picture');
                $avatarPath = $avatar->store('profile_pictures', 'public'); // Store the file in the 'avatars' directory within the 'public' disk
                $user->profile_picture = $avatarPath;
            }

            $user->save();

            return response()->json(['text' => 'Successfully updated user information.', 'data' => $user, 'status' => 200]);
        } catch (Exception $e) {
            return response()->json(['text' => 'There is an error updating the user information.', 'error' => $e->getMessage(), 'status' => 400]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
