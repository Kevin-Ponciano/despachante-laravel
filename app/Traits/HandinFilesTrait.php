<?php

namespace App\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

trait HandinFilesTrait
{
    public string $rootPath = 'SALED';

    public function formatName($string): string
    {
        return strtr($string, [
            ' ' => '_',
            '.' => '',
            '/' => '',
            '-' => '_',
        ]);
    }

    public function _uploadFiles($files, $clienteId, $pedidoId, $folder)
    {
        $filesSaved = [];
        $path = "$this->rootPath/$clienteId/$pedidoId/$folder";
        foreach ($files as $file) {
            $filesSaved[] = Storage::putFileAs($path, $file, $file->getClientOriginalName());
        }
        return $filesSaved;
    }

    public function _uploadCodCrlv($files, $clienteId, $pedido)
    {
        $filesSaved = [];
        $path = "$this->rootPath/$clienteId/$pedido->id/cod_crlv";
        $filesSaved[] = Storage::putFileAs($path, $files['cod'], "COD_$pedido->placa.pdf");
        $filesSaved[] = Storage::putFileAs($path, $files['crlv'], "CRLV_$pedido->placa.pdf");
        return $filesSaved;
    }

    public function _getFilesLink($clienteId, $pedido, $folder): array
    {
        // TODO: Caso o as requisições aumente, salvar os metadados em um banco de dados
        $files = [];
        foreach (Storage::allFiles("$this->rootPath/$clienteId/$pedido->id/$folder") as $file) {
            $name = basename($file);
            $link = Storage::url($file, now()->addMinutes(5));
            $timestamp = Carbon::createFromFormat('U', Storage::lastModified($file))
                ->setTimezone('America/Sao_Paulo')->format(' d/m/Y H:i');

            $files[] = [
                'name' => $name,
                'link' => $link,
                'timestamp' => $timestamp,
                'path' => $file,
            ];
        }
        return $files;
    }

    public function _downloadAllFiles($clienteId, $pedidoId, $folder)
    {
        $path = "$this->rootPath/$clienteId/$pedidoId/$folder";
        $files = Storage::allFiles($path);
        $zip = new ZipArchive();
        $zipFileName = $folder . '_' . $pedidoId . '.zip';
        $zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        foreach ($files as $file) {
            $tempFile = Storage::get($file);
            $zip->addFromString(basename($file), $tempFile);
        }
        $zip->close();
        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }
}
