<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="flex h-screen">
    <!-- Menú lateral -->
    <aside class="w-1/4 bg-gray-800 text-white p-6">
        <h2 class="text-2xl font-bold mb-6">Administración</h2>
        <ul class="space-y-4">
            <li><a href="{{ route('pages.admin-dashboard') }}" class="block p-2 rounded hover:bg-gray-700">Dashboard</a></li>
            <li><a href="#" class="block p-2 rounded hover:bg-gray-700">Crear Curso</a></li>
            <li><a href="#" class="block p-2 rounded hover:bg-gray-700">Crear Video</a></li>
        </ul>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left p-2 rounded hover:bg-gray-700">Logout</button>
            </form>
        </li>
    </aside>

    <!-- Contenido principal -->
    <main class="w-3/4 p-8">
        <h1 class="text-3xl font-bold mb-6">@yield('title')</h1>
        <div>
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
