<?php

namespace App\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

trait HandinFilesTrait
{
    public string $rootPath = 'SALED';
    // TODO: Verificar depois se o path vai ser com o numero do cliente/pedido ou com o ID do cliente/pedido

    /**
     * @param $files
     * @param $despachanteId - ID do despachante
     * @param $clienteId - Numero do cliente único do despachante
     * @param $pedidoId - Numero do pedido único do despachante
     * @param $folder - Pasta onde os arquivos serão salvos
     * @return array
     */
    public function _uploadFiles($files, $despachanteId, $clienteId, $pedidoId, $folder): array
    {
        $filesSaved = [];
        $path = "$this->rootPath/$despachanteId/$clienteId/$pedidoId/$folder";
        foreach ($files as $file) {
            $filesSaved[] = Storage::putFileAs($path, $file, $file->getClientOriginalName());
        }
        return $filesSaved;
    }

    /**
     * @param $files
     * @param $despachanteId - ID do despachante
     * @param $clienteId - Numero do cliente único do despachante
     * @param $pedidoId - Numero do pedido único do despachante
     * @param $placa
     * @return array
     */
    public function _uploadCodCrlv($files, $despachanteId, $clienteId, $pedidoId, $placa): array
    {
        $filesSaved = [];
        $path = "$this->rootPath/$despachanteId/$clienteId/$pedidoId/cod_crlv";
        $filesSaved[] = Storage::putFileAs($path, $files['cod'], "COD_$placa.pdf");
        $filesSaved[] = Storage::putFileAs($path, $files['crlv'], "CRLV_$placa.pdf");
        return $filesSaved;
    }


    /**
     * @param $despachanteId - ID do despachante
     * @param $clienteId - Numero do cliente único do despachante
     * @param $pedidoId - Numero do pedido único do despachante
     * @param $folder
     * @return array
     */
    public function _getFilesLink($despachanteId, $clienteId, $pedidoId, $folder): array
    {
        // TODO: Caso o as requisições aumente, salvar os metadados em um banco de dados
        $files = [];
        $path = "$this->rootPath/$despachanteId/$clienteId/$pedidoId/$folder";
        $filesCloud = Storage::allFiles($path);
        foreach ($filesCloud as $file) {
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

    /**
     * @param $despachanteId - ID do despachante
     * @param $clienteId - Numero do cliente único do despachante
     * @param $pedidoId - Numero do pedido único do despachante
     * @param $folder
     * @return BinaryFileResponse
     */
    public function _downloadAllFiles($despachanteId, $clienteId, $pedidoId, $folder): BinaryFileResponse
    {
        $path = "$this->rootPath/$despachanteId/$clienteId/$pedidoId/$folder";
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
