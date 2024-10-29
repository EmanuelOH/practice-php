<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GoogleUser;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Redirige al usuario a la página de inicio de sesión de Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Maneja la respuesta de Google después del inicio de sesión.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallBack(Request $request)
    {
        try {
            // Obtener datos del usuario de Google
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Buscar el usuario en la base de datos
            $user = User::where('email', $googleUser->email)->first();

            // Si el usuario ya existe, iniciar sesión
            if ($user) {
                Auth::login($user);
            } else {
                // Si no existe, crear un nuevo usuario
                $user = $this->createUser($googleUser);
            }

            // Redirigir a la vista de usuarios con un mensaje de éxito
            return redirect()->route('usuarios')->with('success', 'Has iniciado sesión correctamente');
        } catch (\Exception $e) {
            Log::error('Google login error:', ['message' => $e->getMessage()]);
            return redirect()->route('login')->with('error', 'Error al iniciar sesión con Google.');
        }
    }

    /**
     * Crea un nuevo usuario y un registro asociado en GoogleUser.
     *
     * @param $googleUser
     * @return \App\Models\User
     */
    protected function createUser($googleUser)
    {
        // Crear el nuevo usuario
        $user = User::create([
            'names' => $googleUser->name,
            'email' => $googleUser->email,
            'password' => \Hash::make(rand(100000, 999999)), // Generar una contraseña aleatoria
        ]);

        // Crear un registro en GoogleUser
        GoogleUser::create([
            'google_id' => $googleUser->id, // Almacena el ID de Google
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'user_id' => $user->id,
        ]);

        // Iniciar sesión con el nuevo usuario
        Auth::login($user);

        return $user;
    }

    /**
     * Cierra la sesión del usuario actual.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        return redirect()->route('login')->with('success', 'Has cerrado sesión correctamente.');
    }
}
