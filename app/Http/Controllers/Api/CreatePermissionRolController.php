<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Str;

class CreatePermissionRolController extends Controller
{
    public function store(Request $request){
        DB::beginTransaction();  // start transaction for database operations
        try {
            // Validate request data
            $message = [
                'role_name.required' => 'El nombre del rol es obligatorio.',
                'role_name.string' => 'El nombre del rol debe ser una cadena.',
                'role_name.max' => 'El nombre del rol debe tener un máximo de 255 caracteres.',
                'permissions.required' => 'Los permisos son obligatorios.',
                'permissions.*.required' => 'Los permisos deben ser cadenas.',
                'permissions.*.string' => 'Los permisos deben ser cadenas.',
                'permissions.*.max' => 'Los permisos deben tener un máximo de 255 caracteres.',
            ];

            $validator = Validator::make($request->all(),[
                'role_name' =>'required|string|max:255',
                'permissions' =>'required|array',
                'permissions.*' =>'required|string|max:255',
            ],$message);

            if ($validator->fails()) {
                return ApiResponse::error('Error de validación '.$validator->messages()->first(), 422);
              }

            // crea rol
            $role = Role::create([
                'name' => $request->role_name,
            ]);

            // asigna permisos a rol creado
            $role->givePermissionTo($request->permissions);
            DB::commit(); //
          return ApiResponse::success('Rol creado',200,$role);
        } catch (\Exception $e) {
            //throw $th;
            return ApiResponse::error('Error al crear el rol '.$e->getMessage(), 500);
        }
    }
    public function getRole(){
        try {
            // Obtiene todos los roles
            $roles = Role::get();
            return ApiResponse::success('Roles obtenidos',200,$roles);
        } catch (\Exception $e) {
            //throw $th;
            return ApiResponse::error('Error al obtener los roles '.$e->getMessage(), 500);
        }
    }
    public function createPermissionsAction(Request $request)
    {

        DB::beginTransaction();
        try {
            // Validate request data

            $message = [
                'permissions.required' => 'Los permisos son obligatorios.',

                'permissions.*.string' => 'Los permisos deben ser cadenas.',
                'permissions.*.max' => 'Los permisos deben tener un máximo de 255 caracteres.',
            ];

           $validator = Validator::make($request->all(),[
                'permissions' =>'required|array',
                'permissions.*' =>'required|string|max:255',
            ],$message);
            if($validator->fails()){
                return ApiResponse::error('Error de validación '.$validator->messages()->first(),422);
            }
           // return $request->all();
            // crea permisos
            foreach($request->permissions as $permission){
                Permission::create(['name' => $permission]);
            }

            DB::commit();
            return ApiResponse::success('Permisos creado',200,$request);
        } catch (\Exception $e) {
            //throw $th;
            return ApiResponse::error('Error al crear los permisos'. $e->getMessage(),403);
        }
    }

    public function createUser(Request $request){
        DB::beginTransaction();
        try {
            // Validate request data
            $message = [
                // 'name.required' => 'El nombre es obligatorio.',
                // 'name.string' => 'El nombre debe ser una cadena.',
                // 'name.max' => 'El nombre debe tener un máximo de 255 caracteres.',
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email' => 'El correo electrónico no es válido.',
                'email.max' => 'El correo electrónico debe tener un máximo de 255 caracteres.',
                'password.required' => 'La contraseña es obligatoria.',
                'password.string' => 'La contraseña debe ser una cadena.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                // 'role.required' => 'El rol es obligatorio.',
                // 'role.string' => 'El rol debe ser un texto.',
            ];
            $validator = Validator::make($request->all(),[
                //'name' =>'required|string|max:255',
                'email' =>'required|email|max:255',
                'password' => 'required|string|min:8|confirmed',
                //'role' =>'required|integer',

            ],$message);
            if ($validator->fails()) {
                return ApiResponse::error('Error de validación '.$validator->messages()->first(), 422);
            }

            $dataExplode = explode('@',$request->email);
            $userName = $dataExplode[0].'_'. Str::uuid();

            // crea usuario
            $user = User::create([
                'name' => $userName,
                'email' => $request->email,
                'password' =>  bcrypt($request->password),
            ]);

            // Asigna rol a usuario creado
            $user->assignRole('User');
            DB::commit();
            return ApiResponse::success('Usuario creado',200,$user);
        } catch (\Exception $e) {
            //throw $th;
            return ApiResponse::error('Error al crear el usuario '.$e->getMessage(), 500);

        }
    }
}
