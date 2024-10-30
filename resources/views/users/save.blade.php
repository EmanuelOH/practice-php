<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>{{ isset($user->id) ? 'Editar Usuario' : 'Crear Usuario' }}</title>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
<div class="container mx-auto mt-12">
    <div class="flex justify-center">
        <div class="w-full max-w-lg">
            <div class="bg-white shadow-lg rounded-lg border border-gray-200">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">{{ isset($user->id) ? 'Editar Usuario' : 'Crear Usuario' }}</h2>

                    {{-- Mensaje de éxito --}}
                    @if(session('success'))
                        <div class="alert alert-success mb-4 text-sm text-green-700 bg-green-100 border-l-4 border-green-500 p-3 rounded">
                            <strong>Bien hecho!</strong> {{ session('success') }}
                        </div>
                    @endif

                    {{-- Mensajes de error generales --}}
                    @if($errors->any())
                        <div class="alert alert-danger mb-4 text-sm text-red-700 bg-red-100 border-l-4 border-red-500 p-3 rounded">
                            <strong>Por favor corrige los siguientes errores:</strong>
                            <ul class="list-disc list-inside pl-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ isset($user->id) ? route('usuarios.update', $user->id) : route('usuarios.store') }}" method="POST" class="space-y-4">
                        @csrf
                        @if(isset($user->id)) 
                            @method('PUT')
                        @endif

                        <div>
                            <label for="names" class="block text-gray-700 font-medium mb-1">Nombres</label>
                            <input type="text" class="form-control @error('names') is-invalid @enderror focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" id="names" name="names" value="{{ old('names', $user->names ?? '') }}">
                            @error('names')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="lastnames" class="block text-gray-700 font-medium mb-1">Apellidos</label>
                            <input type="text" class="form-control @error('lastnames') is-invalid @enderror focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" id="lastnames" name="lastnames" value="{{ old('lastnames', $user->lastnames ?? '') }}">
                            @error('lastnames')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-1">Correo Electrónico</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" id="email" name="email" value="{{ old('email', $user->email ?? '') }}">
                            @error('email')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="address" class="block text-gray-700 font-medium mb-1">Dirección</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" id="address" name="address" value="{{ old('address', $user->address ?? '') }}">
                            @error('address')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        @if(!isset($user->id))
                            <div>
                                <label for="password" class="block text-gray-700 font-medium mb-1">Contraseña</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" id="password" name="password">
                                @error('password')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <div class="flex justify-between items-center">
                            <button type="submit" class="btn btn-primary bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-full">{{ isset($user->id) ? 'Actualizar usuario' : 'Crear usuario' }}</button>
                            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-full">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
