<?php


use App\Models\Course;
use App\Models\User;
use App\Models\Video;

it('solo los administradores pueden ver el dashboard', function () {
    // Arrange: Crear usuario admin y cliente
    $admin = User::factory()->create(['role' => 'admin']);
    $client = User::factory()->create(['role' => 'client']);

    // Act & Assert: Admin puede acceder
    actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk();

    // Cliente NO puede acceder
    actingAs($client)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

it('muestra correctamente los datos en el dashboard', function () {
    // Arrange: Crear datos
    Course::factory(5)->create();
    Video::factory(15)->create();
    User::factory(20)->create(['role' => 'client']); // Solo clientes cuentan

    $admin = User::factory()->create(['role' => 'admin']);

    // Act & Assert
    actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertSee('Total de Cursos')
        ->assertSee('5')
        ->assertSee('Total de Videos')
        ->assertSee('15')
        ->assertSee('Usuarios Registrados')
        ->assertSee('20');
});
