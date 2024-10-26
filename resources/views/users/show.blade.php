<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $user->trashed() ? 'Ver Usuario Eliminado' : 'Ver Usuario' }}</title>
</head>
<body>
@yield('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-2xl text-red-500 mb-2"><strong>{{ $user->trashed() ? 'Usuario Eliminado' : 'Detalles del Usuario'}}</strong></h2>
                    <ol class="mb-2">
                        <li>Nombres: {{ $user->names }}</li>
                        <li>Apellidos: {{ $user->lastnames }}</li>
                        <li>Correo: {{ $user->email }}</li>
                        <li>Dirección: {{ $user->address }}</li>
                        <li>Password: {{ $user->password }}</li>
                    </ol>
                    @if ($user->trashed())
                        <form action="{{ route('usuarios.restore', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Restaurar Usuario</button>
                        </form>
                    @endif
                    <div class="mt-3">
                        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">IR al index</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
