<?php

namespace Tests\Feature;

use App\Traits\HandinFiles;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class HandinFilesTest extends TestCase
{
    use HandinFiles;

    public function test_upload_files()
    {
        $files = [
            UploadedFile::fake()->create('file1.pdf', 1000),
            UploadedFile::fake()->create('file2.pdf', 1000),
            UploadedFile::fake()->create('file3.pdf', 1000),
        ];
        $clienteId = '1';
        $pedidoId = '1';
        $folder = 'teste';
        $filesSaved = $this->uploadFiles($files, $clienteId, $pedidoId, $folder);
        $this->assertEquals([
            "SALED/$clienteId/$pedidoId/$folder/file1.pdf",
            "SALED/$clienteId/$pedidoId/$folder/file2.pdf",
            "SALED/$clienteId/$pedidoId/$folder/file3.pdf",
        ], $filesSaved);
        //Storage::deleteDirectory('SALED/1');
    }

    public function test_upload_cod_crlv()
    {
        $files = [
            'cod' => UploadedFile::fake()->create('cod.pdf', 1000),
            'crlv' => UploadedFile::fake()->create('crlv.pdf', 1000),
        ];
        $clienteId = '1';
        $pedido = (object)[
            'id' => '1',
            'placa' => 'ABC1234',
        ];
        $filesSaved = $this->uploadCodCrlv($files, $clienteId, $pedido);
        $this->assertEquals([
            "SALED/$clienteId/$pedido->id/cod_crlv/cod_$pedido->placa.pdf",
            "SALED/$clienteId/$pedido->id/cod_crlv/crlv_$pedido->placa.pdf"
        ], $filesSaved);
    }
}
