<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'password' => 'required|string|min:6',
        ]);

        $data = $request->only(['identificacion', 'nombres', 'apellidos', 'email', 'telefono', 'rol']);
        $data['password'] = bcrypt($request->password); // O Hash::make()
        Usuario::create($data);

        return redirect()->route('login')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
    }
}
