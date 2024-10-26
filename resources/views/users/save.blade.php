<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>{{ isset($user->id) ? 'Editar Usuario' : 'Crear Usuario' }}</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h2>{{ isset($user->id) ? 'Editar Usuario' : 'Crear Usuario' }}</h2>

                    @if(session('success'))
                        <div class="alert alert-success">
                            <strong>Bien hecho!</strong> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ isset($user->id) ? route('usuarios.update', $user->id) : route('usuarios.store') }}" method="POST">
                        @csrf
                        @if(isset($user->id)) 
                            @method('PUT')
                        @else 
                            @method('POST') 
                        @endif

                        <div class="mb-3">
                            <label for="names" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="names" name="names" value="{{ old('names', $user->names ?? '') }}" required>
                            @error('names')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="lastnames" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="lastnames" name="lastnames" value="{{ old('lastnames', $user->lastnames ?? '') }}" required>
                            @error('lastnames')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address ?? '') }}" required>
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        @if(!isset($user->id))
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password">
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary">{{ isset($user->id) ? 'Actualizar usuario' : 'Crear usuario' }}</button>
                        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
