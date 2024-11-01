<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;


class ForgotPasswordController extends Controller
{

    // Método para mostrar el formulario de solicitud de enlace
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password'); // Asegúrate de que este nombre de vista sea correcto
    }

    // Método para enviar el enlace de restablecimiento de contraseña
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', trans($status))
            : back()->withErrors(['email' => trans($status)]);
    }
}
