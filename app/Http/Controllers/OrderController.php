<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Validator;

class OrderController extends Controller {
    public function index() {
        try {

            $orders = Order::join('users', 'orders.user_id', '=', 'users.id')
                ->join('orderdetails', 'orders.orderdetail_id', '=', 'orderdetails.id')
                ->join('products', 'orderdetails.product_id', '=', 'products.id')
                ->select(
                    'orders.id', 'orders.user_id', 'orders.orderdetail_id', 'orders.total', 'orders.estado', 'orders.fecha', 'users.nombre as nombre_usuario', 'users.correo', 'orderdetails.product_id', 'orderdetails.cantidad', 'products.nombre as nombre_producto', 'products.precio as precio_producto', 'products.stock as stock_producto'
                )
                ->get();

            return response()->json(
                [
                    'message' => 'Ordenes obtenidas correctamente',
                    'status'  => 'success',
                    'data'    => $orders,

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
    }


    public function create() {

    }


    public function store(Request $request) {
        try {

            $validator = Validator::make($request->all(), [
                'user_id'        => 'required',
                'orderdetail_id' => 'required',
                'total'          => 'required',
                'estado'         => 'required',
                'fecha'          => 'required',
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

            $order = Order::create($request->all());

            return response()->json(
                [
                    'message' => 'Orden creada correctamente',
                    'status'  => 'success',
                    'data'    => $order,


                ], 200

            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'Error al crear la orden',
                    'status'  => 'error',
                    'data'    => $th->getMessage(),

                ], 500
            );
        }
    }


    public function show($id) {
        try {

            $exists = Order::where('id', $id)->exists();
            if (!$exists) {
                return response()->json(
                    [
                        'message' => 'Error al obtener la orden',
                        'status'  => 'error',
                        'data'    => 'La orden por este id no existe',

                    ], 500
                );
            }

            $order = Order::join('users', 'orders.user_id', '=', 'users.id')
                ->join('orderdetails', 'orders.orderdetail_id', '=', 'orderdetails.id')
                ->join('products', 'orderdetails.product_id', '=', 'products.id')
                ->select(
                    'orders.id', 'orders.user_id', 'orders.orderdetail_id', 'orders.total', 'orders.estado', 'orders.fecha', 'users.nombre as nombre_usuario', 'users.correo', 'orderdetails.product_id', 'orderdetails.cantidad', 'products.nombre as nombre_producto', 'products.precio as precio_producto', 'products.stock as stock_producto'
                )
                ->where('orders.id', $id)
                ->first();

            return response()->json(
                [
                    'message' => 'Orden obtenida correctamente',
                    'status'  => 'success',
                    'data'    => $order,

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
            $validator = Validator::make($request->all(), [
                'user_id'        => 'required',
                'orderdetail_id' => 'required',
                'total'          => 'required',
                'estado'         => 'required',
                'fecha'          => 'required',
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

            $exists = Order::where('id', $id)->exists();

            if (!$exists) {
                return response()->json(
                    [
                        'message' => 'Error al actualizar la orden',
                        'status'  => 'error',
                        'data'    => 'La orden por este id no existe',

                    ], 500
                );
            }

            $order = Order::find($id);
            $order->update($request->all());
        }
    }

    public function destroy($id) {
        try {

            $exists = Order::where('id', $id)->exists();

            if (!$exists) {
                return response()->json(
                    [
                        'message' => 'Error al eliminar la orden',
                        'status'  => 'error',
                        'data'    => 'La orden por este id no existe',

                    ], 500
                );
            }

            $order = Order::find($id);
            $order->delete();

            return response()->json(
                [
                    'message' => 'Orden eliminada correctamente',
                    'status'  => 'success',
                    'data'    => $order,

                ], 200

            );

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

    public function getOrdersByUser($id) {
        try {
            $orders = Order::join('users', 'orders.user_id', '=', 'users.id')
                ->join('orderdetails', 'orders.orderdetail_id', '=', 'orderdetails.id')
                ->join('products', 'orderdetails.product_id', '=', 'products.id')
                ->select(
                    'orders.id', 'orders.user_id', 'orders.orderdetail_id', 'orders.total', 'orders.estado', 'orders.fecha', 'users.nombre as nombre_usuario', 'users.correo', 'orderdetails.product_id', 'orderdetails.cantidad', 'products.nombre as nombre_producto', 'products.precio as precio_producto', 'products.stock as stock_producto'
                )
                ->where('orders.user_id', $id)
                ->get();


            $orderdetails = Order::join('orderdetails', 'orders.orderdetail_id', '=', 'orderdetails.id')
                ->join('products', 'orderdetails.product_id', '=', 'products.id')
                ->select(
                    'orderdetails.total'
                )
                ->where('orders.user_id', $id)
                ->get();

            // sumar el total de orderdetails
            $totalSum = $orderdetails->sum('total');



            return response()->json(
                [
                    'message'         => 'Ordenes obtenidas correctamente',
                    'status'          => 'success',
                    'data'            => $orders,
                    'total de compra' => $totalSum
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
    }
}