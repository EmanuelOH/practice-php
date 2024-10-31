<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PHPUnit\Exception;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Service\DiscordWebhookService;

use App\Events\UserCreated;
use App\Events\UserUpdated;
use App\Events\UserDeleted;
use App\Events\UserRestore;

class UserController extends Controller
{

    // Método constructor que se llama automáticamente al crear una nueva instancia de la clase
    public function __construct(DiscordWebhookService $discordWebhookService)
    {
        // Almacena la instancia de DiscordWebhookService en la propiedad de la clase
        $this->discordWebhook = $discordWebhookService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::paginate(10);
            return view('users.index', compact('users'));
        } catch (\Exception $e) {
            // si ocurre un error, enviar mensaje a Discord o Slack
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $user = new User();
            return view('users.save', compact('user'));
        } catch (\Exception $e) {
            // si ocurre un error, enviar mensaje a Discord o Slack
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create($validatedData);

        event(new UserCreated($user));

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::find($id);
            return view('users.show', compact('user'));
        } catch (\Exception $e) {
            // si ocurre un error, enviar mensaje a Discord o Slack
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $user = User::find($id);
        
            return view('users.save', compact('user'));
        } catch (\Exception $e) {
            // si ocurre un error, enviar mensaje a Discord o Slack
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {

        $validatedData = $request->validated();

        $user = User::find($id);
        
        $user->update($validatedData);

        event(new UserUpdated($user));

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::find($id);
            $user->delete();
            
            event(new UserDeleted($user));

            return back()->with('success','Se ha eliminado correctamente');

        } catch (\Exception $e) {
            // si ocurre un error, enviar mensaje a Discord o Slack
        }
    }

    public function showTrashed(string $id)
    {
        $user = User::onlyTrashed()->find($id); // Cambié a $user

        if (!$user) {
            return redirect()->route('usuarios.index')->with('error', 'Usuario no encontrado.');
        }

        return view('users.show', compact('user')); // Cambié deleteUser a user
    }

    

    public function restoreUser(string $id)
    {
        $user = User::withTrashed()->find($id); // Cambié - a ->

        if ($user && $user->trashed()) {
            $user->restore();
            
            event(new UserRestore($user));

            return redirect()->route('usuarios.index')->with('success', 'Usuario restaurado correctamente.');
        }

        return response()->json(['mensaje' => 'Usuario no encontrado'], 404);
    }

}
