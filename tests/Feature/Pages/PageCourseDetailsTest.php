<?php

use App\Models\Course;
use App\Models\User;
use App\Models\Video;

use Juampi92\TestSEO\TestSEO;
use function Pest\Laravel\get;

it('does not find unreleased course', function () {
    // Arrange
    $client = User::factory()->create(['role' => 'client']);
    loginAsUser($client);

    $course = Course::factory()->create();

    // Act & Assert
    get(route('pages.course-details', $course))
        ->assertNotFound();
});

it('shows course details', function () {
    // Arrange

    $client = User::factory()->create(['role' => 'client']);
    loginAsUser($client);

    $course = Course::factory()->released()->create();

    // Act & Assert
    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSeeText([
            $course->title,
            $course->description,
            $course->tagline,
            ...$course->learnings,
        ])
        ->assertSee(asset("images/{$course->image_name}"));
});

it('shows course video count', function () {
    // Arrange
    $client = User::factory()->create(['role' => 'client']);
    loginAsUser($client);

    $course = Course::factory()
        ->released()
        ->has(Video::factory()->count(3))
        ->create();

    // Act & Assert
    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSeeText('3 videos');
});

it('includes paddle checkout button', function () {
    // Arrange
    $client = User::factory()->create(['role' => 'client']);
    loginAsUser($client);

    config()->set('services.paddle.vendor-id', 'vendor-id');
    $course = Course::factory()
        ->released()
        ->create([
            'paddle_product_id' => 'pri_01j449tat6p71xg1yx22pwnrjt',
        ]);

    // Act & Assert
    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSee('<script src="https://cdn.paddle.com/paddle/v2/paddle.js"></script>', false)
        ->assertSee('Paddle.Initialize({ token: "vendor-id" });', false)
        ->assertSee('<a href="#" data-theme="light" class="paddle_button mt-8 inline-flex items-center rounded-md border border-transparent bg-yellow-400 py-3 px-6 text-base font-medium text-gray-900 shadow hover:text-red-500"', false);
});

it('includes a title', function () {
    // Arrange
    $client = User::factory()->create(['role' => 'client']);
    loginAsUser($client);

    $course = Course::factory()->released()->create();
    $expectedTitle = config('app.name') . ' - ' . $course->title;

    // Act
    $response = get(route('pages.course-details', $course))
        ->assertOk();

    // Assert
    $seo = new TestSEO($response->getContent());
    expect($seo->data)->title()->toBe($expectedTitle);
});

it('includes social tags', function () {
    // Arrange
    $client = User::factory()->create(['role' => 'client']);
    loginAsUser($client);

    $course = Course::factory()->released()->create();

    // Act
    $response = get(route('pages.course-details', $course))
        ->assertOk();

    // Assert
    $seo = new TestSEO($response->getContent());
    expect($seo->data)
        ->description()->toBe($course->description)
        ->openGraph()->type->toBe('website')
        ->openGraph()->url->toBe(route('pages.course-details', $course))
        ->openGraph()->title->toBe($course->title)
        ->openGraph()->description->toBe($course->description)
        ->openGraph()->image->toBe(asset("images/{$course->image_name}"))
        ->twitter()->card->toBe('summary_large_image');
});

it('muestra el botón de compra solo para clientes', function () {
    // Arrange: Crear un curso publicado
    $course = Course::factory()->released()->create([
        'paddle_product_id' => 'pri_01j449tat6p71xg1yx22pwnrjt',
    ]);

    // Cliente ve el botón de compra
    $client = User::factory()->create(['role' => 'client']);
    loginAsUser($client);

        get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSee('Buy Now!')
        ->assertSee($course->paddle_product_id);

    // Admin NO ve el botón de compra
    $admin = User::factory()->create(['role' => 'admin']);
    loginAsUser($admin);

    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertDontSee('Buy Now!')
        ->assertSee('Ya eres admin, no hace falta comprarlo');
});
