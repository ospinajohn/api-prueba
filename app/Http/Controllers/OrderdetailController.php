<?php

namespace App\Http\Controllers;

use App\Models\Orderdetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

class OrderdetailController extends Controller {

    public function index() {
        // trar todas las ordenes pero con los productos asociados
        try {
            $orderdetails = Orderdetail::join('products', 'orderdetails.product_id', '=', 'products.id')
                ->select('orderdetails.*', 'products.nombre as nombre_producto', 'products.precio as precio_producto', 'products.stock as stock_producto')
                ->get();

            return response()->json(
                [
                    'message' => 'Ordenes obtenidas correctamente',
                    'status'  => 'success',
                    'data'    => $orderdetails,

                ], 200

            );

        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'Error al obtener las ordenes',
                    'status'  => 'error',
                    'data'    => $th->getMessage(),

                ], 500
            );
        }

        // segunda forma con with que es mas facil pero no se puede hacer un select y esto quiere decir que trae todos los campos de la tabla orderdetails y de la tabla products
        // try {
        //     $orderdetails = Orderdetail::with('product')->get(); 
        //     return response()->json(
        //         [
        //             'message' => 'Ordenes obtenidas correctamente',
        //             'status'  => 'success',
        //             'data'    => $orderdetails,

        //         ], 200
        //     );

        // } catch (\Throwable $th) {
        //     return response()->json(
        //         [
        //             'message' => 'Error al obtener las ordenes',
        //             'status'  => 'error',
        //             'data'    => $th->getMessage(),

        //         ], 500
        //     );
        // }


    }


    public function create() {
        //
    }


    public function store(Request $request) {
        try {
            // validar los datos
            $validator = Validator::make($request->all(), [
                'product_id' => 'required',
                'cantidad'   => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'message' => 'Error al crear la orden',
                        'status'  => 'error',
                        'data'    => $validator->errors(),

                    ], 500
                );
            }

            // Validar si el del producto existe en la base de datos
            $exists = Product::where('id', $request->product_id)->exists();
            if (!$exists) {
                return response()->json(
                    [
                        'message' => 'Error al crear la orden',
                        'status'  => 'error',
                        'data'    => 'El producto no existe',

                    ], 500
                );
            } else {
                $Product = Product::where('id', $request->product_id)->first();
            }

            // Validar si el producto tiene stock
            if ($Product->stock < $request->cantidad) {
                return response()->json(
                    [
                        'message' => 'Error al crear la orden',
                        'status'  => 'error',
                        'data'    => 'El producto no tiene stock suficiente',

                    ], 500
                );
            }

            // calcular el total de la orden
            $totalOrder = $request->cantidad * $Product->precio;

            // crear la orden
            $orderdetail = new Orderdetail;
            $orderdetail->product_id = $request->product_id;
            $orderdetail->cantidad = $request->cantidad;
            $orderdetail->total = $totalOrder;
            $orderdetail->precio = $Product->precio;
            $orderdetail->save();

            return response()->json(
                [
                    'message' => 'Orden creada correctamente',
                    'status'  => 'success',
                    'data'    => $orderdetail,

                ], 200
            );

        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message'  => 'Error al crear la orden',
                    'status'   => 'error',
                    'data'     => $th->getMessage(),
                    'producto' => $Product,
                    'total'    => $totalOrder,

                ], 500
            );
        }
    }


    public function show($id) {
        try {

            $exists = Orderdetail::where('id', $id)->exists();
            if (!$exists) {
                return response()->json(
                    [
                        'message' => 'Error al obtener la orden',
                        'status'  => 'error',
                        'data'    => 'La orden por este id no existe',

                    ], 500
                );
            }

            $orderdetail = Orderdetail::join('products', 'orderdetails.product_id', '=', 'products.id')
                ->select('orderdetails.*', 'products.nombre as nombre_producto', 'products.precio as precio_producto', 'products.stock as stock_producto')
                ->where('orderdetails.id', $id)
                ->first();

            return response()->json(
                [
                    'message' => 'Orden obtenida correctamente',
                    'status'  => 'success',
                    'data'    => $orderdetail,

                ], 200

            );

        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'Error al obtener la orden',
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
            // validar los datos
            $validator = Validator::make($request->all(), [
                'product_id' => 'required',
                'cantidad'   => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'message' => 'Error al actualizar la orden',
                        'status'  => 'error',
                        'data'    => $validator->errors(),

                    ], 500
                );
            }

            // Validar si el del producto existe en la base de datos
            $exists = Product::where('id', $request->product_id)->exists();
            if (!$exists) {
                return response()->json(
                    [
                        'message' => 'Error al actualizar la orden',
                        'status'  => 'error',
                        'data'    => 'El producto no existe',

                    ], 500
                );
            } else {
                $Product = Product::where('id', $request->product_id)->first();
            }

            // Validar si el producto tiene stock
            if ($Product->stock < $request->cantidad) {
                return response()->json(
                    [
                        'message' => 'Error al actualizar la orden',
                        'status'  => 'error',
                        'data'    => 'El producto no tiene stock suficiente',

                    ], 500
                );
            }

            // calcular el total de la orden
            $totalOrder = $request->cantidad * $Product->precio;

            // actualizar la orden
            $orderdetail = Orderdetail::find($id);
            $orderdetail->product_id = $request->product_id;
            $orderdetail->cantidad = $request->cantidad;
            $orderdetail->total = $totalOrder;
            $orderdetail->precio = $Product->precio;
            $orderdetail->save();

            return response()->json(
                [
                    'message' => 'Orden actualizada correctamente',
                    'status'  => 'success',
                    'data'    => $orderdetail,

                ], 200
            );

        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'Error al actualizar la orden',
                    'status'  => 'error',
                    'data'    => $th->getMessage(),
                ],
                500
            );
        }
    }


    public function destroy($id) {
        try {
            $exists = Orderdetail::where('id', $id)->exists();
            if (!$exists) {
                return response()->json(
                    [
                        'message' => 'Error al eliminar la orden',
                        'status'  => 'error',
                        'data'    => 'La orden por este id no existe',

                    ], 500
                );
            }

            // eliminar la orden
            $order = Orderdetail::findOrFail($id);
            $order->delete();


        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'Error al eliminar la orden',
                    'status'  => 'error',
                    'data'    => $th->getMessage(),

                ], 500
            );
        }
    }
}