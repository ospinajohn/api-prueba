<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {

    public function index() {
        try {
            $products = Product::all();
            return response()->json(
                [
                    'message' => 'Productos obtenidos correctamente',
                    'status'  => 'success',
                    'data'    => $products,

                ], 200
            );

        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'Error al obtener los productos',
                    'status'  => 'error',
                    'data'    => $th->getMessage(),

                ], 500
            );
        }
    }


    public function create() {
        //
    }


    public function store(Request $request) {
        try {
            $product = Product::create($request->all());

            return response()->json(
                [
                    'message' => 'Producto creado correctamente',
                    'status'  => 'success',
                    'data'    => $product,

                ], 200
            );

        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'Error al crear el producto',
                    'status'  => 'error',
                    'data'    => $th->getMessage(),

                ], 500
            );
        }
    }


    public function show($id) {
        try {
            $data = Product::findOrFail($id);
            return response()->json(
                [
                    'message' => 'Producto obtenido correctamente',
                    'status'  => 'success',
                    'data'    => $data,

                ], 200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'Error al obtener el producto',
                    'status'  => 'error',
                    'data'    => $th->getMessage(),

                ], 500
            );
        }
    }


    public function edit($id) {
        //
    }


    public function update(Request $request, $id) {
        try {
            $data = Product::findOrFail($id);
            $data->update($request->all());
            return response()->json(
                [
                    'message' => 'Producto actualizado correctamente',
                    'status'  => 'success',
                    'data'    => $data,

                ], 200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'Error al actualizar el producto',
                    'status'  => 'error',
                    'data'    => $th->getMessage(),

                ], 500
            );
        }
    }


    public function destroy($id) {
        try {
            $data = Product::findOrFail($id);
            $data->delete();
            return response()->json(
                [
                    'message' => 'Producto eliminado correctamente',
                    'status'  => 'success',
                    'data'    => $data,

                ], 200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'Error al eliminar el producto',
                    'status'  => 'error',
                    'data'    => $th->getMessage(),

                ], 500
            );
        }
    }




}