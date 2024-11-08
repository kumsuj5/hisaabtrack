<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user

        $profilePath = null;
        if($request->hasFile('profile_path')) {
            $profilePath = $request->file('profile_path')->store('profileimage', 'public'); 
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->profile_path= $profilePath;
        $user->password = Hash::make($request->password);
        $user->save();

        $token = $user->createToken('farzi')->accessToken; 

        return response()->json([
            'status' => 'Success',
            'message' => 'User successfully created',
            'data' => [
                'token' => $token,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'profile_path'=> $user->profile_path
    ],
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('farzi')->accessToken; 
        return response()->json([
            'message' => 'Login successful',
            'data' => [
                'token' => $token,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'profile_path'=> $user->profile_path
    ],
        ], 200);
    }
}
