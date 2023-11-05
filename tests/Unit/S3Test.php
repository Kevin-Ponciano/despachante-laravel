<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class S3Test extends TestCase
{
    public function test_upload()
    {
        $file = UploadedFile::fake()->image('capa.jpg');

        Storage::disk('s3')->put('capas/capa.jpg', $file->getContent());

        Storage::disk('s3')->assertExists('capas/capa.jpg');
    }
}
