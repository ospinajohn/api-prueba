<?php

namespace App\Http\Controllers;

use App\Models\User;
use Cookie;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\TryCatch;
use Validator;

class UserController extends Controller {

    public function index() {
        return response()->json(
            [
                'message' => 'Usuarios obtenidos correctamente',
                'status'  => 'success',
                'data'    => User::all(),

            ], 200
        );
    }


    public function create() {
        //
    }


    public function store(Request $request) {
        try {
            // Validar la información de registro y que el correo venga con punto, @ y com 
            $validator = Validator::make($request->all(), [
                'nombre'   => 'required|string',
                'correo'   => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'telefono' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors(),
                    'msg'   => 'No se pudo registrar'
                ], 500);
            }

            // Encriptar la contraseña
            $request->merge(['password' => bcrypt($request->get('password'))]); // merge es para unir los datos que se le pasan como parametro

            // crear el usuario
            $user = User::create([
                'nombre'   => $request->get('nombre'),
                'correo'   => $request->get('correo'),
                'password' => $request->get('password'),
                'telefono' => $request->get('telefono'),
            ]);


            return response()->json(['data' => $user], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'msg'   => 'No se pudo registrar'
            ], 500);

        }
    }


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


    public function edit($id) {
        return null;
    }


    public function update(Request $request, $id) {
        // actualizar solo el dato que se envie en el request
        try {
            $data = User::findOrFail($id);
            $data->update($request->all());

            $users = User::where('rol', 'supervisor')->get();
            if (count($users) >= 3 && $request->get('rol') == 'supervisor') {
                return response()->json([
                    'error' => 'No se puede registrar mas de 3 supervisores',
                    'msg'   => 'No se pudo actualizar'
                ], 500);
            }

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

    public function login(Request $request) {
        $credentials = $request->validate([
            'correo'   => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) { // verificar las credenciales y la fun attempt es para verificar si las credenciales son correctas 
            $user = Auth::user(); // obtener el usuario autenticado
            $token = $user->createToken('token-name')->plainTextToken; // crear el token
            $cookie = cookie('jwt', $token, 60 * 24); // crear la cookie

            return response()->json([
                'msg'    => 'Login correcto',
                'status' => 'success',
                'data'   => $user,
                'token'  => $token,
            ], 200)->withCookie($cookie);
        } else {
            return response()->json([
                'msg'    => 'Credenciales incorrectas',
                'status' => 'error',
                'data'   => null
            ], 401);
        }
    }

    public function register(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'nombre'   => 'required|string',
                'correo'   => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'telefono' => 'required|string',
                'imagen'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors(),
                    'msg'   => 'No se pudo registrar'
                ], 500);
            }

            $password = Hash::make($request->get('password'));

            // recibir la imagen y guardarla en el servidor
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $imagen->move(public_path('images'), $nombreImagen);


            // crear el usuario
            $user = User::create([
                'nombre'   => $request->get('nombre'),
                'correo'   => $request->get('correo'),
                'password' => $password,
                'telefono' => $request->get('telefono'),
            ]);


            return response()->json([
                'msg'    => 'Registrado correctamente',
                'status' => 'success',
                'data'   => $user
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'msg'   => 'No se pudo registrar'
            ], 500);

        }
    }

    public function logout(Request $request) {
        $cookie = Cookie::forget('jwt');

        return response()->json([
            'msg'    => 'Logout correcto',
            'status' => 'success',
            'data'   => null
        ], 200)->withCookie($cookie);
    }

    // Administrador

    public function indexAdmin() {
        return response()->json(
            [
                'message' => 'Usuarios obtenidos correctamente',
                'status'  => 'success',
                'data'    => User::all(),

            ], 200
        );
    }

    public function getUserProfile() {
        $user = Auth::user();
        return response()->json(
            [
                'message' => 'Usuario obtenido correctamente',
                'status'  => 'success',
                'data'    => $user
            ], 200
        );
    }

    public function updateProfile(Request $request) {
        try {
            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'nombre'   => 'required|string',
                'telefono' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors(),
                    'msg'   => 'No se pudo actualizar'
                ], 500);
            }

            $user->nombre = $request->get('nombre');
            $user->telefono = $request->get('telefono');
            $user->save();


            return response()->json(
                [
                    'message' => 'Usuario actualizado correctamente',
                    'status'  => 'success',
                    'data'    => $user
                ], 200
            );
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'msg'   => 'No se pudo actualizar'
            ], 500);



        }

    }

    public function updatePassword(Request $request) {
        try {
            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors(),
                    'msg'   => 'No se pudo actualizar'
                ], 500);
            }

            $user->password = Hash::make($request->get('password'));
            $user->save();

            return response()->json(
                [
                    'message' => 'Contraseña actualizada correctamente',
                    'status'  => 'success',
                    'data'    => $user
                ], 200
            );
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'msg'   => 'No se pudo actualizar'
            ], 500);
        }
    }

    public function forgotPassword(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'correo' => 'required|string|email|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors(),
                    'msg'   => 'No se pudo enviar el correo'
                ], 500);
            }

            $user = User::where('correo', $request->get('correo'))->first();

            if (!$user) {
                return response()->json([
                    'error' => 'No existe un usuario con ese correo',
                    'msg'   => 'No se pudo enviar el correo'
                ], 500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'msg'   => 'No se pudo enviar el correo'
            ], 500);
        }
    }

}