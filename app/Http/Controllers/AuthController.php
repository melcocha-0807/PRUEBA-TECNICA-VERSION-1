<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->rol === 'vendedor') {
                return redirect()->route('vendedor.panel'); // ← nombre correcto
            } elseif ($user->rol === 'auxiliar de bodega') {
                return redirect()->route('auxiliar.dashboard');
            } elseif ($user->rol === 'usuario') {
                return redirect()->route('usuario.home');
            }
            return redirect('/'); // Rol desconocido
        }
        return back()->withErrors([
            'email' => 'Credenciales incorrectas',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // Asignar rol a un usuario (opcional, para administración)
    public function assignRole(Request $request, $userId)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);
        $user = User::findOrFail($userId);
        $user->syncRoles([$request->input('role')]);
        return back()->with('success', 'Rol asignado correctamente');
    }
}
