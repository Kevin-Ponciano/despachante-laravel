<?php

namespace App\Traits;

use App\Models\Arquivo;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

trait HandinFilesTrait
{
    use WithFileUploads;

    public string $rootPath = 'SALED';
    public $arquivos = [];
    public $arquivosDoPedido = [];
    public $arquivosCodCrlv = [];
    public $arquivosRenave = [];
    public $arquivoCodSeg;
    public $arquivoCrlv;
    public $arquivosAtpvs;
    public $arquivoAtpv;

    protected array $rulesMsgArquivos = [[
        'arquivos.*' => 'mimes:pdf|max:10240',
    ], [
        'arquivos.*.mimes' => 'Formato inválido (Somente PDF).',
        'arquivos.*.max' => 'Tamanho máximo de 10MB.',
    ]];

    protected array $rulesMsgArquivoCodSeg = [[
        'arquivoCodSeg' => 'nullable|mimes:pdf|max:10240',
    ], [
        'arquivoCodSeg.mimes' => 'Formato inválido (Somente PDF).',
        'arquivoCodSeg.max' => 'Tamanho máximo de 10MB.',
    ]];

    protected array $rulesMsgArquivoCrlv = [[
        'arquivoCrlv' => 'nullable|mimes:pdf|max:10240',
    ], [
        'arquivoCrlv.mimes' => 'Formato inválido (Somente PDF).',
        'arquivoCrlv.max' => 'Tamanho máximo de 10MB.',
    ]];

    protected array $rulesMsgArquivoAtpv = [[
        'arquivoAtpv' => 'required|mimes:pdf|max:10240',
    ], [
        'arquivoAtpv.required' => 'Obrigatório.',
        'arquivoAtpv.mimes' => 'Formato inválido (Somente PDF).',
        'arquivoAtpv.max' => 'Tamanho máximo de 10MB.',
    ]];

    public function updatedArquivos()
    {
        $this->validate($this->rulesMsgArquivos[0], $this->rulesMsgArquivos[1]);
    }

    public function updatedArquivoCodSeg()
    {
        $this->validate($this->rulesMsgArquivoCodSeg[0], $this->rulesMsgArquivoCodSeg[1]);
    }

    public function updatedArquivoCrlv()
    {
        $this->validate($this->rulesMsgArquivoCrlv[0], $this->rulesMsgArquivoCrlv[1]);
    }

    public function updatedArquivoAtpv()
    {
        $this->validate($this->rulesMsgArquivoAtpv[0], $this->rulesMsgArquivoAtpv[1]);
    }


    /**
     * @param $folder - Pasta onde os arquivos serão salvos
     * @return void
     */
    public function uploadFiles($folder): void
    {
        $this->validate($this->rulesMsgArquivos[0], $this->rulesMsgArquivos[1]);
        if (empty($this->arquivos)) {
            $this->addError('arquivos.*', 'Obrigatório.');
            return;
        }

        $despachanteId = Auth::user()->getIdDespachante();
        $clienteId = $this->pedido->cliente->numero_cliente;
        $pedidoId = $this->pedido->numero_pedido;


        $pathFiles = [];
        $path = "$this->rootPath/$despachanteId/$clienteId/$pedidoId/$folder";
        foreach ($this->arquivos as $file) {
            $pathFiles[] = $this->saveFile($file, $path, $folder);
        }
        if (count($pathFiles) == 0) {
            $this->addError('arquivos.*', 'Erro ao enviar os arquivos.');
        } else {
            $this->emit('success', [
                'message' => 'Arquivos enviados com sucesso.',
            ]);
            if (Auth::user()->isCliente()) {
                if ($this->pedido->status == 'pe') {
                    $this->pedido->update(['status' => 'rp']);
                    $this->pedido->pendencias()->where('tipo', 'dc')->update(['status' => 'rp']);
                    $this->emit('modal-sucesso-documento');
                }
            }
        }

        $this->arquivos = [];
    }


    public function uploadCodCrlv()
    {
        $this->validate($this->rulesMsgArquivoCodSeg[0], $this->rulesMsgArquivoCodSeg[1]);
        $this->validate($this->rulesMsgArquivoCrlv[0], $this->rulesMsgArquivoCrlv[1]);

        if (empty($this->arquivoCodSeg) && empty($this->arquivoCrlv)) {
            $this->emit('error', 'Nenhum arquivo Selecionado.');
            return;
        }

        $despachanteId = Auth::user()->getIdDespachante();
        $clienteId = $this->pedido->cliente->numero_cliente;
        $pedidoId = $this->pedido->numero_pedido;
        $placa = $this->pedido->placa;
        $path = "$this->rootPath/$despachanteId/$clienteId/$pedidoId/cod_crlv";

        if (!empty($this->arquivoCodSeg))
            $codIsSaved = $this->saveFile($this->arquivoCodSeg, $path, 'cod_crlv', "COD_$placa.pdf");
        if (!empty($this->arquivoCrlv))
            $crlvIsSaved = $this->saveFile($this->arquivoCrlv, $path, 'cod_crlv', "CRLV_$placa.pdf");
        if (isset($codIsSaved) && $codIsSaved == null) {
            $this->addError('arquivoCodSeg', 'Erro ao enviar o arquivo.');
        }
        if (isset($crlvIsSaved) && $crlvIsSaved == null) {
            $this->addError('arquivoCrlv', 'Erro ao enviar o arquivo.');
        }
        if ((isset($codIsSaved) && $codIsSaved != null) || (isset($crlvIsSaved) && $crlvIsSaved != null)) {
            $this->emit('success', [
                'message' => 'Arquivos enviados com sucesso.',
            ]);
        }
        $this->arquivoCodSeg = null;
        $this->arquivoCrlv = null;
    }

    public function uploadAtpv()
    {
        $this->validate($this->rulesMsgArquivoAtpv[0], $this->rulesMsgArquivoAtpv[1]);

        $despachanteId = Auth::user()->getIdDespachante();
        $clienteId = $this->pedido->cliente->numero_cliente;
        $pedidoId = $this->pedido->numero_pedido;
        $placa = $this->pedido->placa;
        $path = "$this->rootPath/$despachanteId/$clienteId/$pedidoId/atpv";

        $atpvIsSaved = $this->saveFile($this->arquivoAtpv, $path, 'atpv', "ATPV_$placa.pdf");
        if ($atpvIsSaved == null) {
            $this->addError('arquivoAtpv', 'Erro ao enviar o ATPV.');
        } else {
            $this->emit('success', [
                'message' => 'ATPV enviado com sucesso.',
            ]);
        }

    }


    /**
     * @param $folder
     * @return array
     */
    public function _getFilesLink($folder): array
    {
        $arquivos = $this->pedido->arquivos()->where('folder', $folder)->get();
        $files = [];
        foreach ($arquivos as $file) {
            $name = $file->nome;
            $link = $file->url;
            $path = $file->path;
            $mime = $file->mime_type;
            $data = Carbon::createFromFormat('Y-m-d H:i:s', $file->updated_at)->format('d/m/Y H:i');

            $files[] = [
                'name' => $name,
                'link' => $link,
                'timestamp' => $data,
                'path' => $path,
                'mime' => $mime,
            ];
        }
        return $files;
    }


    public function downloadFile($path)
    {
        return Storage::download($path);
    }

    /**
     * @param $folder
     * @return BinaryFileResponse
     */
    public function downloadAllFiles($folder): BinaryFileResponse
    {
        $pedidoId = $this->pedido->numero_pedido;

        $files = $this->pedido->arquivos()->where('folder', $folder)->pluck('path')->toArray();
        $zip = new ZipArchive();
        $zipFileName = \Str::replace('/', '_', $folder) . '_' . $pedidoId . '.zip';
        $zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        foreach ($files as $file) {
            $tempFile = Storage::get($file);
            if ($tempFile != null)
                $zip->addFromString(basename($file), $tempFile);
        }
        $zip->close();
        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }

    public function deleteFile($path)
    {
        $isDeleted = Storage::delete($path);
        if ($isDeleted) {
            Arquivo::where('path', $path)->delete();
            $this->emit('success', 'Arquivo deletado com sucesso.');
        } else {
            $this->emit('error', 'Erro ao deletar arquivo.');
        }
    }

    protected function saveFile($file, $path, $folder, $nome = null)
    {
        if (empty($nome))
            $nome = $file->getClientOriginalName();
        $pathFile = Storage::putFileAs($path, $file, $nome);
        if (!$pathFile)
            return null;
        $mime = Storage::mimeType($pathFile);
        $url = Storage::url($pathFile, now()->addMinutes(5));# TODO: Tentar manter a url publica

        Arquivo::updateOrCreate(
            [
                'path' => $pathFile,
            ],
            [
                'pedido_id' => $this->pedido->id,
                'nome' => $nome,
                'folder' => $folder,
                'mime_type' => $mime,
                'url' => $url,
                'updated_at' => now(),
            ]
        );
        return $pathFile;
    }
}
