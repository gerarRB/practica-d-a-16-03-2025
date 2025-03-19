<?php

namespace App\Http\Controllers;

use App\Http\Response\ApiResponse;
use App\Models\MntPersonalInformationUserModel;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Validator;
use Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        // return $request->all();
        $credential = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credential)) {
            return response()->json(['errors' => 'Credenciales invalidas'], 401);
        }

        $user = Auth::user();

        // $userInformation = MntPersonalInformationUserModel::where('user_id', $user->id)->first();

        $customClaims = [
            'user_id' => $user->id,
            'email' => $user->email,
            // 'userInformation' => $userInformation ? $userInformation->toArray() : null, // Asegúrate de convertir a array
            'role' => $user->getRoleNames() // Incluye roles si es necesario
        ];


        // if(!$user->hasRole('Admin')){
        //     return response()->json(['error' => 'not_admin'], 403);
        // }
        $token = JWTAuth::claims($customClaims)->fromUser($user);

        return response()->json(['token' => $token, 'role' => $user->getRoleNames()]);
    }

    public function refresh(Request $request)
    {
        try {
            $currentToken = JWTAuth::getToken();

            if (!$currentToken) {
                return response()->json(['error' => 'Token no proporcionado'], 400);
            }

            try {
                $user = JWTAuth::toUser($currentToken);

            } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                try {
                    // Intentar refrescar el token
                    $currentToken = JWTAuth::refresh($currentToken);

                    $user = JWTAuth::toUser($currentToken);
                } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                    return response()->json(['error' => 'Token no se puede refrescar'], 401);
                }
            }

            $id_user = $user->id ?? $request->user_id;
            $userInformation = MntPersonalInformationUserModel::where('user_id', $id_user)->first();

            $customClaims = [
                'user_id' => $user->id,
                'email' => $user->email,
                'userInformation' => $userInformation ? $userInformation->toArray() : null,
                'role' => $user->getRoleNames()
            ];

            $newToken = JWTAuth::claims($customClaims)->refresh($currentToken);

            return response()->json([
                'token' => $newToken,
                'message' => 'Token actualizado',
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function register(Request $request)
    {
        try {

            FacadesDB::beginTransaction();
            // Valida los datos
            $validator = Validator::make($request->all(), [

                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'repeat_password' => 'required|string|min:8|same:password'
            ], [
                'email.required' => 'El correo es obligatorio.',
                'email.email' => 'El correo no tiene un formato válido.',
                'email.unique' => 'El correo ya está en uso.',
                'password.required' => 'La contraseña es obligatoria.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'repeat_password.same' => 'Las contraseñas no coinciden.',
            ]);

            if ($validator->fails()) {
                return ApiResponse::error($validator->errors()->first(), 400);
            }
            $emailExplode = explode('@', $request->email);
            $name = $emailExplode[0] . Str::random();
            // Crea el usuario
            $user = User::create([
                'name' => $name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Añade el rol al usuario
            $user->assignRole('User');
            DB::commit();
            $data = $this->login(new Request([
                'email' => $request->email,
                'password' => $request->password,
            ]));

            // Personaliza los claims

            return ApiResponse::success('Usuario creado', 200, $data);
            // Obtiene la información del usuario
        } catch (\Exception $th) {
            //throw $th;
            return ApiResponse::error('Error al crear el usuario ' . $th->getMessage(), 404);
        }
    }

    // Logout and invalidate the JWT token
    public function logout()
    {
        try {
            $token = JWTAuth::getToken();

            if (!$token) {
                return response()->json([
                    'message' => 'No token provided',
                    'status' => 400
                ], 400);
            }

            // Registrar el logout del usuario (opcional)
            $user = JWTAuth::authenticate($token);
            $user->update(['is_logged_in' => false]); // Cambia 'is_logged_in' según tu modelo

            return response()->json([
                'message' => 'User logged out successfully',
                'status' => 200
            ], 200);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'message' => 'Error invalidating token: ' . $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }
}
