<?php

namespace App\Http\Controllers\Api;
use App\Http\Response\ApiResponse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CtlCategoria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class CtlCategoriaController extends Controller
{
    //
    public function index(Request $request){
        try {
                $categoria = CtlCategoria::select(['id','nombre']);

                if($request->has('nombre')){
                    $categoria->where('nombre','ILIKE','%'.$request->nombre.'%');
                }
                $categoria = $categoria->paginate(10);
                $pagination = [
                    'per_page'=>$categoria->perPage(),
                    'current_page'=>$categoria->currentPage(),
                    'total'=>$categoria->total(),

                ];
                $categoriaFormated= $categoria->map(function($c){
                    return [
                        'nombre'=>$c->nombre,
                        'id'=>$c->id
                    ];
                });

            return ApiResponse::success(
                'Categorias obtenidas correctamente',
                200,
                $categoriaFormated,
                $pagination);
        } catch (\Exception $e) {
            //throw $th;
            return ApiResponse::error('Error al cargar las categorias'.$e->getMessage(),401);
        }
    }

    public function store(Request $request){
        try {
            //code...

            $message=[
                'nombre.required'=>'Nombre es requerido',
                'nombre.un ique'=>'Nombre de la categoria ya existe',
                'nombre.max'=>'Nombre de la categoria no debe exceder de 255 caracteres'
            ];
            $Validators = Validator::make($request->all(),[
                'nombre'=>'required|max:255|unique:ctl_categoria,nombre'
            ],$message);

            if ($Validators->fails()) {
                return response()->json([
                    'errors' => $Validators->errors()
                ], 422);
            }
            DB::beginTransaction();
                $categoria = new CtlCategoria();
                $categoria->nombre = $request->nombre;
            DB::commit();
            if($categoria->save()){

                return ApiResponse::success('categoria creada',200,$categoria);
            }

        } catch (\Exception $e) {
            //throw $th;
            return ApiResponse::error('Error al crear categoría',401);
        }
    }
    public function update(Request $request,$id){
        try {
            //code...
            $message=[
                'nombre.required'=> 'Nombre es requerido',
                'nombre.unique'=>'El nombre de la categoria ya existe',
            ];
            $validator = Validator::make($request->all(),[
                'nombre'=> 'required|unique:ctl_categoria,nombre'
                ],$message);

            if ($validator->fails()) {
                return response()->json([
                    'errors'=> $validator->errors()
                    ],422);
                }
            // DB::beginTransaction();
                $categoria = CtlCategoria::find($id);
                $categoria->nombre = $request->nombre;
            // DB::commit();
            if($categoria->save()){
                return ApiResponse::success('Categoria actualizada',200,$categoria);
            }
        } catch (\Exception $e) {
            //throw $th;
            return ApiResponse::error('Error al actualizar la categoria'.$e->getMessage(),422);
        }
    }
    public function categoriaProductos(){
        try {
            //code...
            $categoriaProductos = CtlCategoria::with([
                'productos'
            ])->paginate(10);
        } catch (\Exception $e) {
            //throw $th;
            return ApiResponse::error('Error al traer categorias y productos',422);
        }
    }
    public function deleteCategoria($id){
        try {
            //code...
            $categoria = CtlCategoria::find($id);
            $categoria->activo = !$categoria->activo;
            if($categoria->save()){
                return ApiResponse::success('Se actualizo lacategoria',200,$categoria);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return ApiResponse::error('Error'.$th->getMessage(),422);
        }
    }

}
