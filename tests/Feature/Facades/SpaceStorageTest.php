<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Thuraaung\SpaceStorage\Facades\SpaceStorage;

it('should upload an image from uploaded file', function (): void {
    Storage::fake();

    $path = SpaceStorage::upload('images', UploadedFile::fake()->image('photo.jpg'));

    expect($path)->toBeString();

    Storage::assertExists($path);
});

it('should upload an image from link (upload)', function (): void {
    Storage::fake();

    $path = SpaceStorage::upload('images', fake()->imageUrl(width: 10, height: 10));

    expect($path)->toBeString();

    Storage::assertExists($path);
});

it('should upload an image from link (put)', function (): void {
    Storage::fake();

    $path = SpaceStorage::put('images', fake()->imageUrl(width: 10, height: 10));

    expect($path)->toBeString();

    Storage::assertExists($path);
});

it('should display an existing image', function (): void {
    Storage::fake();

    $path = SpaceStorage::upload('images', fake()->imageUrl());

    Storage::assertExists($path);

    expect(SpaceStorage::display($path)->status())->toBe(200);
    expect(SpaceStorage::display($path)->headers->contains('content-type', 'image/png'))
        ->toBeTrue();
});

it('should not display when an image does not exist', function (): void {
    Storage::fake();

    SpaceStorage::display('test.png');
})->throws(NotFoundHttpException::class, 'File not found!');

it('should update an image from image link', function (): void {
    Storage::fake();

    $path = SpaceStorage::upload('images', UploadedFile::fake()->image('photo.jpg'));

    Storage::assertExists($path);

    $status = SpaceStorage::update($path, fake()->imageUrl(width: 10, height: 10));

    expect($status)->toBeTrue();

    Storage::assertExists($path);
});

it('should update an image from uploaded file', function (): void {
    Storage::fake();

    $path = SpaceStorage::upload('images', UploadedFile::fake()->image('photo.jpg'));

    Storage::assertExists($path);

    $status = SpaceStorage::update($path, UploadedFile::fake()->image('new.jpg'));

    expect($status)->toBeTrue();

    Storage::assertExists($path);
});

it('should delete an existing image', function (): void {
    Storage::fake();

    $path = SpaceStorage::upload('images', UploadedFile::fake()->image('photo.jpg'));

    expect(SpaceStorage::delete($path))->toBeTrue();
});

it('should delete a non-existing image', function (): void {
    Storage::fake();

    expect(SpaceStorage::delete('/images/test.png'))->toBeFalse();
});

it('should return true when an image exists', function (): void {
    Storage::fake();

    $path = SpaceStorage::upload('images', UploadedFile::fake()->image('photo.jpg'));

    expect(SpaceStorage::exists($path))->toBeTrue();
});

it('should return false when an image does not exist', function (): void {
    Storage::fake();

    expect(SpaceStorage::exists('test.png'))->toBeFalse();
});
