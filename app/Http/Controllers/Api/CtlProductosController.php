<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\ApiResponse;
use App\Models\CtlInventerio;
use App\Models\CtlProductos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CtlProductosController extends Controller
{
    //
    public function index(){
        try {
        $products = CtlProductos::with([
            "categoria"=> function ($query) {
                $query->select(['id','nombre']);
            },
            "inventario"
        ])->paginate(10);

        return $products;
        } catch (\Exception $e) {
            //throw $th;
            return $e->getMessage();
        }
    }
    public function store(Request $request){
        try {
            //code...
            $message=[
                "nombre.required"=>"Nombre es requerido",
                "nombre.max"=>"nombre no debe pasar de 255 caracteres",
                "nombre.unique"=>"nombre ya existe",
                "precio"=>"requerido",
                "image"=>"requerido",
                "cantidad.required"=>"Cantidad es requerida",
                "cantidad.numeric" => "Cantidad debe un numero"
            ];
            $validators= Validator::make($request->all(),[
                "nombre"=>"required|max:255|unique:ctl_productos,nombre",
                "precio"=>"required|numeric",
                "image"=>"required",
                "cantidad"=>"required|numeric"
            ]);
            if ($validators->fails()) {
                return response()->json([
                    'errors'=> $validators->errors()
                    ],422);
            }
            DB::beginTransaction();
            $producto = new CtlProductos();
            $producto->fill($request->all());
            if ($producto->save()) {
                # code...
                $inventario = new CtlInventerio();
                $inventario->cantidad = $request->cantidad;
                $inventario->product_id= $producto->id;
                DB::commit();
                if ($inventario->save()) {

                return ApiResponse::success('Se creo el producto',200,$producto);
                }
            }

        } catch (\Exception $e) {
            //throw $th;
            return ApiResponse::error($e->getMessage());
        }
    }

    public function updateInventario(Request $request, $id){
        try {
            //code...
            //return $request->all();
            $inventario = CtlInventerio::find($id);
            $inventario->cantidad =$inventario->cantidad +  $request->cantidad;
            if ($inventario->save()) {
                # code...
                return ApiResponse::success('Actualizo inventario',200);
            }
        } catch (\Exception $th) {
            //throw $th;
            return ApiResponse::error($th->getMessage(),422);
        }
    }
    public function deleteProducto($id){
        try {
            //code...
            $producto = CtlProductos::find($id);
            $producto->activo = !$producto->activo;
            if ($producto->save()) {
                return ApiResponse::success('Se actualizo el producto',200, $producto);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    
}
