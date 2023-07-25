<?php

namespace App\Traits;

trait HandinFilesTrait
{
    public function saveFiles($files, $cliente, $pedido)
    {
        $filesSaved = [];
        $cliente->nome = strtr($cliente->nome, [
            ' ' => '_',
            '.' => '',
            '/' => '',
            '-' => '_',
        ]);
        $path = "$cliente->nome/$pedido->id/DOCUMENTOS";
        foreach ($files as $file) {
            $filesSaved[] = $file->storeAs($path, $file->getClientOriginalName(), 'public');
        }
        return $filesSaved;
    }
}
