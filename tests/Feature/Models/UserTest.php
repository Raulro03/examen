<?php

use App\Models\Course;
use App\Models\User;
use App\Models\Video;

it('has courses', function () {
    // Arrange
    $user = User::factory()
        ->has(Course::factory()->count(2), 'purchasedCourses')
        ->create();

    // Act & Assert
    expect($user->purchasedCourses)
        ->toHaveCount(2)
        ->each->toBeInstanceOf(Course::class);
});

it('has videos', function () {
    // Arrange
    $user = User::factory()
        ->has(Video::factory()->count(2), 'watchedVideos')
        ->create();

    // Act & Assert
    expect($user->watchedVideos)
        ->toHaveCount(2)
        ->each->toBeInstanceOf(Video::class);
});

it('is admin', function () {
    // Arrange
    $user = User::factory()->create(['role' => 'admin']);

    // Act & Assert
    expect($user->isAdmin())->toBeTrue();
});

it('is not admin', function () {
    // Arrange
    $user = User::factory()->create(['role' => 'client']);

    // Act & Assert
    expect($user->isAdmin())->toBeFalse();
});
