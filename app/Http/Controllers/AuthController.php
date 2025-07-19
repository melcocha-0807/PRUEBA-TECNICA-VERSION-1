<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario; // Cambié de User a Usuario
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

<<<<<<< HEAD
            if ($user->rol === 'vendedor') {
                return redirect()->route('vendedor.panel'); // ← nombre correcto
            } elseif ($user->rol === 'auxiliar de bodega') {
                return redirect()->route('auxiliar.dashboard');
            } elseif ($user->rol === 'usuario') {
                return redirect()->route('usuario.home');
=======
            // Redireccionar según rol
            switch ($user->rol) {
                case 'vendedor':
                    return redirect()->route('vendedor.panel');
                case 'auxiliar de bodega':
                    return redirect()->route('auxiliar.productos'); // ✅ Cambié a una ruta más específica
                case 'usuario':
                    return redirect()->route('usuario.home'); // ✅ Cambié de catalogo a home
                default:
                    return redirect('/')->with('warning', 'Rol no reconocido');
>>>>>>> origin/master
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->withInput($request->except('password'));
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'Has cerrado sesión correctamente');
    }

    // Mostrar formulario de registro (si lo necesitas)
    public function showRegister()
    {
        return view('auth.register');
    }

    // Procesar registro
    public function register(Request $request)
    {
        $request->validate([
            'identificacion' => 'required|string|max:45|unique:usuarios,identificacion',
            'nombres' => 'required|string|max:200',
            'apellidos' => 'required|string|max:200',
            'email' => 'required|email|max:150|unique:usuarios,email',
            'telefono' => 'nullable|string|max:45',
            'rol' => 'required|in:usuario,vendedor,auxiliar de bodega',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $usuario = Usuario::create([
            'identificacion' => $request->identificacion,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'rol' => $request->rol,
            'password' => bcrypt($request->password),
        ]);

        // Opcionalmente, iniciar sesión automáticamente después del registro
        Auth::login($usuario);

        return redirect()->route('login')->with('success', 'Registro exitoso. Bienvenido!');
    }

    // Asignar rol a un usuario (opcional, para administración)
    public function assignRole(Request $request, $userId)
    {
        $request->validate([
            'role' => 'required|in:usuario,vendedor,auxiliar de bodega',
        ]);

        $usuario = Usuario::findOrFail($userId);
        $usuario->rol = $request->input('role');
        $usuario->save();

        return back()->with('success', 'Rol asignado correctamente');
    }

    // Método para verificar si el usuario está autenticado (middleware helper)
    public function checkAuth()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página');
        }
    }
}