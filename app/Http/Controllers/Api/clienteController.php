<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clientes;
use Illuminate\Support\Facades\Validator;

class clienteController extends Controller
{
    public function mostrar(){
        $clientes=Clientes::all();
        if ($clientes->isEmpty()){
            $data = [
                'mensaje' => 'No se encontraron clientes',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        return response()->json($clientes, 200);
    }

    public function crear(Request $request){

        $validator = Validator::make($request->all(),[
            'nombre' => 'required|max:150',
            'email' => 'required|email|unique:Clientes',
            'telefono' => 'required|digits:10',
            'sector' => 'required|in:Taller,Compra,Venta'
        ]);

         if ($validator->fails()){
         $data = [
        'mensaje' => 'Error en la validacion de los datos',
        'errores' => $validator->errors(),
        'status' => 400
         ];
         return response()->json($data, 400);
        }
         $clientes = Clientes::create([
        'nombre' => $request->nombre,
        'email' => $request->email,
        'telefono' => $request->telefono,
        'sector' => $request->sector
         ]);
        if (!$clientes){
        $data= [
            'mensaje' => 'Error al crear el cliente',
            'status' => 500
        ];
        return response()->jspm($data,500);
        }
        $data = [
        'cliente' => $clientes,
        'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function  buscar($id){
        $clientes = clientes::find($id);
        if(!$clientes){
            $data = [
            'message' => 'Cliente no encontrado',
            'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data =[
            'cliente' => $clientes,
            'status'=> 200
        ];
        return response()->json($data, 200);
    }

    public function eliminar($id){
        $clientes = clientes::find($id);
        if(!$clientes){
            $data = [
                'message' => 'Cliente no encontrado',
                'status' => 404 
            ];
            return response()->json($data, 404);
        }
        $clientes->delete();
        $data = [
            'message'=> 'Cliente eliminado',
            'status'=> 200
        ];
        return response()->json($data, 200);
    }

    public function actualizar(Request $request, $id){
        $clientes = clientes::find($id);

        if(!$clientes){
            $data = [
            'message'=> 'Cliente no encontrado',
            'status'=> 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(),[
            'nombre' => 'required|max:150',
            'email' => 'required|email|unique:Clientes',
            'telefono' => 'required|digits:10',
            'sector' => 'required|in:Taller,Compra,Venta'
        ]);

         if ($validator->fails()){
         $data = [
        'mensaje' => 'Error en la validacion de los datos',
        'errores' => $validator->errors(),
        'status' => 400
         ];
         return response()->json($data, 400);
        }

        $clientes->nombre = $request->nombre;
        $clientes->email = $request->email;
        $clientes->telefono = $request->telefono;
        $clientes->sector = $request->sector;

        $clientes->save();
        $data = [
            'message'=>'Cliente actualizado',
            'cliente'=> $clientes,
            'status'=>200
        ];
        return response()->json($data, 200);
    }

    public function actualizacionParcial(Request $request, $id){
        $clientes = clientes::find($id);

        if(!$clientes){
            $data = [
                'mensaje'=> 'Cliente no encontrado',
                'status'=> '404'
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(),[
            'nombre' => 'max:150',
            'email' => 'email|unique:Clientes',
            'telefono' => 'digits:10',
            'sector' => 'in:Taller,Compra,Venta'
        ]);
        if ($validator->fails()){
            $data = [
           'mensaje' => 'Error en la validacion de los datos',
           'errores' => $validator->errors(),
           'status' => 400
            ];
            return response()->json($data, 400);
        }
        
        if($request->has('nombre')){
            $clientes->nombre = $request->nombre;
        }
        if($request->has('email')){
            $clientes->email = $request->email;
        }
        if($request->has('telefono')){
            $clientes->telefono = $request->telefono;
        }
        if($request->has('sector')){
            $clientes->sector = $request->sector;
        }
        $clientes->save();

        $data = [
            'mensaje'=>'Actualizado Parcialmente',
            'cliente'=> $clientes,
            'status'=>200
        ];
        return response()->json($data, 200);
    }
}
