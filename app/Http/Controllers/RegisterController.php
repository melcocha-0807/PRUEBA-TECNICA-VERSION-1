<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'identificacion' => 'required|string|max:45|unique:usuarios,identificacion',
            'nombres' => 'required|string|max:200',
            'apellidos' => 'required|string|max:200',
            'email' => 'required|email|max:150|unique:usuarios,email',
            'telefono' => 'nullable|string|max:45',
            'rol' => 'required|in:usuario,vendedor,auxiliar de bodega',
            'password' => [
                'required',
                Password::min(8)
                    ->numbers()
            ],
        ], [
            'identificacion.required' => 'La identificación es obligatoria.',
            'identificacion.unique' => 'Esta identificación ya está registrada.',
            'nombres.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe tener un formato válido.',
            'email.unique' => 'Este email ya está registrado.',
            'rol.required' => 'Debe seleccionar un rol.',
            'rol.in' => 'El rol seleccionado no es válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        try {
            $usuario = Usuario::create([
                'identificacion' => $request->identificacion,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'rol' => $request->rol,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('login')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput($request->except('password'))
                ->with('error', 'Error al crear el usuario. Inténtalo de nuevo.');
        }
    }
}