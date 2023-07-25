<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\UploadFile;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Storage;
use Tests\TestCase;

class UploadFileTest extends TestCase
{
    public function test_can_upload_file()
    {
        Storage::fake('avatars');

        $sizeInKilobytes = 1024;
        $nameFile = 'document.pdf';
        $file = UploadedFile::fake()->create($nameFile, $sizeInKilobytes);

        Livewire::test(UploadFile::class)
            ->set('file', $file)
            ->call('upload', $nameFile)
            ->assertHasNoErrors(['photo' => 'mimes:png']);

        Storage::disk('avatars')->assertExists($nameFile);
    }
}
