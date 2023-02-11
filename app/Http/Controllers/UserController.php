<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return response()->json(
            [
                'message' => 'Usuarios obtenidos correctamente',
                'status'  => 'success',
                'data'    => User::all(),

            ], 200
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        try {
            $user = User::create($request->all());
            if ($user['correo']  )
            
            return response()->json(
                [
                    'message' => 'Usuario creado correctamente',
                    'status'  => 'success',
                    'data'    => $user
                ], 200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'Error al crear el usuario',
                    'status'  => 'error',
                    'data'    => null
                ], 500
            );
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        // find es para buscar por id y findOrFail es para buscar por id y si no lo encuentra lanza una excepcion 
        try {
            $user = User::findOrFail($id);
            return response()->json(
                [
                    'message' => 'Usuario obtenido correctamente',
                    'status'  => 'success',
                    'data'    => $user
                ], 200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'Usuario no encontrado',
                    'status'  => 'error',
                    'data'    => null
                ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        // actualizar solo el dato que se envie en el request
        try {
            $data = User::findOrFail($id);
            $data->update($request->all());
            return response()->json([
                'data' => $data,
                'msg'  => 'Actualizado correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'msg'   => 'No se pudo actualizar'
            ], 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) { {
            try {
                $data = User::findOrFail($id);
                $data->delete();
                return response()->json([
                    'data' => $data,
                    'msg'  => 'Eliminado correctamente'
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage(),
                    'msg'   => 'No se pudo eliminar'
                ], 500);
            }

        }
    }
}