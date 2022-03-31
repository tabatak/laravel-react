<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Validator;
use Illuminate\Support\Facades\Auth;
use Exception;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken($user->email . '_Token')->plainTextToken;

            return response()->json([
                'status' => 200,
                'username' => $user->name,
                'token' => $token,
                'message' => 'Registerd Successfully'
            ]);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        if (Auth::guard('users')->attempt($credentials)) {
            $request->session()->regenerate();

            return new JsonResponse(['message' => 'ログインしました']);
        }

        throw new Exception('ログインに失敗しました。再度お試しください');
    }

    public function logout(Request $request)
    {
        logger('logout', ['name' => auth()->user()->name]);
        $request->session()->invalidate();
        Auth::guard('users')->logout();
        return response()->json([
            'status' => 200,
            'message' => 'ログアウト成功',
        ]);
    }


    public function me(Request $request)
    {
        logger('me', ['name' => auth()->user()->name]);
        return response()->json([
            'status' => 200,
            'message' => 'ME!!!!',
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ]);
    }
}
