<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parametros invalidos y/o faltantes'
            ], 422);
        }

        $user = User::where('email', $request['email'])->first();

        if (!$user) {
            return response()->json([
                'message' => 'Usuario y/o contraseña invalido/s'
            ], 401);
        }

        if (!Hash::check($request['password'], $user->password)) {
            return response()->json([
                'message' => 'Usuario y/o contraseña invalido/s'
            ], 401);
        }

        $token = $user->createToken("token")->plainTextToken;

        return response()->json([
            'token' => $token,
            'type' => 'Bearer',
            'expire_date' => Carbon::now()->addMinutes(30)->format("d/m/Y H:i:s")
        ]);
    }
}
