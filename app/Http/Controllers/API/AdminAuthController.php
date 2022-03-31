<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Validator;
use Illuminate\Support\Facades\Auth;
use Exception;

class AdminAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'email' => 'required|email|max:191|unique:admins,email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $admin = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $admin->createToken($admin->email . '_Token')->plainTextToken;

            return response()->json([
                'status' => 200,
                'username' => $admin->name,
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

        if (Auth::guard('admins')->attempt($credentials)) {
            $request->session()->regenerate();

            return new JsonResponse(['message' => 'ADMIN ログインしました']);
        }

        throw new Exception('ADMIN ログインに失敗しました。再度お試しください');
    }

    public function logout(Request $request)
    {
        logger('admin logout', ['name' => auth()->user()->name]);
        $request->session()->invalidate();
        Auth::guard('admins')->logout();

        return response()->json([
            'status' => 200,
            'message' => 'ADMIN ログアウト成功',
        ]);
    }

    public function me(Request $request)
    {
        logger('me', ['name' => auth()->user()->name]);
        return response()->json([
            'status' => 200,
            'message' => 'ADMIN ME!!!!',
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ]);
    }
}
