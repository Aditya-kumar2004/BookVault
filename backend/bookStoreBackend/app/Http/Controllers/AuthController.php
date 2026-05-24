<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'email' => 'required|email|unique:users', 'password' => 'required|min:8']);
        $user = User::create(['name' => $request->name, 'email' => $request->email, 'password' => bcrypt($request->password), 'role' => 'user']);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token], 201);
    }
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $user = Auth::user();
        if ($user->status === 'Banned') {
            Auth::logout();
            return response()->json(['message' => 'Your account has been banned. Please contact support.'], 403);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:10',
            'bio' => 'nullable|string|max:1000',
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio' => $request->bio,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);
        return response()->json(['message' => 'Profile updated successfully', 'user' => $user]);
    }
    public function index()
    {
        return response()->json(User::all());
    }
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return response()->json(['message' => 'You cannot ban yourself.'], 400);
        }
        $user->status = ($user->status === 'Banned') ? 'Active' : 'Banned';
        $user->save();
        return response()->json([
            'message' => "User status updated to {$user->status} successfully.",
            'user' => $user
        ]);
    }
}
