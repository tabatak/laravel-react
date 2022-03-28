<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Validator;

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
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $admin = Admin::where('email', $request->email)->first();
            if (!$admin || !Hash::check($request->password, $admin->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => '入力情報が不正です',
                ]);
            } else {
                $token = $admin->createToken($admin->email . '_Token')->plainTextToken;
                $request->session()->regenerate();

                return response()->json([
                    'status' => 200,
                    'username' => $admin->name,
                    'token' => $token,
                    'message' => 'ログインに成功しました。'
                ]);
            }
        }
    }

    public function logout(Request $request)
    {
        logger('admin logout', ['name' => auth()->user()->name]);
        $request->session()->invalidate();

        return response()->json([
            'status' => 200,
            'message' => 'ログアウト成功',
        ]);
    }
}
