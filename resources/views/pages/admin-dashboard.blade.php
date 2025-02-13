@extends('layouts.admin')

@section('title', 'Panel de Administración')

@section('content')
    <div class="grid grid-cols-3 gap-6">
        <!-- Total de cursos -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-bold">Total de Cursos</h2>
            <p class="text-3xl font-semibold">{{ $totalCourses }}</p>
        </div>

        <!-- Cantidad de videos -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-bold">Total de Videos</h2>
            <p class="text-3xl font-semibold">{{ $totalVideos }}</p>
        </div>

        <!-- Número de usuarios (sin admins) -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-bold">Usuarios Registrados</h2>
            <p class="text-3xl font-semibold">{{ $totalUsers }}</p>
        </div>
    </div>
@endsection
