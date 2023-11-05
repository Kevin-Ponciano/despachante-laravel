<?php

namespace App\Http\Livewire;

use App\Models\Pendencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Livewire\Component;
use Log;
use Throwable;

class Pendencias extends Component
{
    public $pendencias = [];

    public $pedidoId;

    public $name;

    public $tipo;

    public $observacao;

    public $createPendencia = false;

    public $isModal = false;

    protected $listeners = [
        '$refresh',
    ];

    public static function hasPendingStatic($pedidoId)
    {
        $pendenciasCount = Auth::user()->empresa()->pedidos()->find($pedidoId)->pendencias->where('status', '!=', 'co')->count();

        return $pendenciasCount > 0;
    }

    public function mount()
    {
        $numeroPedido = Str::afterLast(URL::current(), '/');
        $this->pedidoId = Auth::user()->empresa()->pedidos()->where('numero_pedido', $numeroPedido)->first()->id;
    }

    public function hasPending()
    {
        $pendenciasCount = 0;
        foreach ($this->pendencias as $pendencia) {
            if ($pendencia->status != 'co') {
                $pendenciasCount++;
            }
        }

        return $pendenciasCount > 0;
    }

    public function resolverPendencia($id)
    {
        try {
            if ($this->hasConludeOrExcluded()) {
                return;
            }
            $pendencia = Pendencia::find($id)->load('pedido', 'pedido.timelines');
            $pendencia->status = $pendencia->status == 'co' ? 'pe' : 'co';
            $pendencia->concluded_at = $pendencia->status == 'co' ? now() : null;
            $pendencia->save();
            if ($pendencia->status == 'pe') {
                if ($pendencia->pedido->status != 'pe') {
                    $pendencia->pedido()->update(['status' => 'pe']);
                    $pendencia->pedido->timelines()->create([
                        'user_id' => Auth::user()->id,
                        'titulo' => 'Pedido pendente',
                        'descricao' => '',
                        'tipo' => 'pp',
                    ]);
                    $this->emit('warning', 'Pedido com pendências!');
                }
                $pendencia->pedido->timelines()->create([
                    'user_id' => Auth::user()->id,
                    'titulo' => 'Pendência não resolvida',
                    'descricao' => "O pedido contínua com a pendência: <br><b>$pendencia->nome</b>.",
                    'tipo' => 'pp',
                ]);

            } elseif ($pendencia->status == 'co') {
                $pendencia->pedido->timelines()->create([
                    'user_id' => Auth::user()->id,
                    'titulo' => 'Pendência resolvida',
                    'descricao' => "A pendência foi resolvida: <br><b>$pendencia->nome</b>.",
                    'tipo' => 'pr',
                ]);
            }
            $this->emit('$refresh');
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao resolver pendência!');
        }
    }

    public function hasConludeOrExcluded()
    {
        $status = Auth::user()->empresa()->pedidos()->find($this->pedidoId)->status;
        if ($status === 'co' || $status === 'ex') {
            $this->emit('warning', 'Pedido concluído ou excluído não pode ser editado.');

            return true;
        } else {
            return false;
        }
    }

    public function resolverTodas()
    {
        try {
            if ($this->hasConludeOrExcluded()) {
                return;
            }
            foreach ($this->pendencias as $pendencia) {
                if ($pendencia->status !== 'co') {
                    $pendencia->status = 'co';
                    $pendencia->concluded_at = now();
                    $pendencia->save();
                }
            }

            $this->setPedidoAberto();

            Auth::user()->empresa()->pedidos()->find($this->pedidoId)
                ->timelines()->create([
                    'user_id' => Auth::user()->id,
                    'titulo' => 'Pendências resolvidas',
                    'descricao' => 'Todas as pendências foram resolvidas.',
                    'tipo' => 'pr',
                ]);
            $this->emit('$refresh');
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao resolver pendências!');
        }
    }

    public function setPedidoAberto()
    {
        if ($this->hasConludeOrExcluded()) {
            return;
        }
        $pedido = Auth::user()->empresa()->pedidos()->find($this->pedidoId);
        $pedido->update(['status' => 'ab']);
        $pedido->timelines()->create([
            'user_id' => Auth::user()->id,
            'titulo' => 'Pedido Aberto',
            'descricao' => '',
            'tipo' => 'ap',
        ]);

        $this->emit('$refresh');
        $this->emit('success', ['message' => 'Pedido em Aberto!']);
    }

    public function store()
    {
        try {
            if ($this->hasConludeOrExcluded()) {
                return;
            }
            if ($this->name == null) {
                $this->createPendencia = false;
                $this->clearFields();

                return;
            }
            $pendencia = Pendencia::create([
                'pedido_id' => $this->pedidoId,
                'nome' => $this->name,
                'tipo' => $this->tipo ?? 'dc',
                'observacao' => $this->observacao,
                'status' => 'pe',
            ]);
            if ($pendencia->pedido->status != 'pe') {
                $pendencia->pedido()->update([
                    'status' => 'pe',
                ]);
                $pendencia->pedido->timelines()->create([
                    'user_id' => Auth::user()->id,
                    'titulo' => 'Pedido pendente',
                    'descricao' => '',
                    'tipo' => 'pp',
                ]);
            }

            $pendencia->pedido->timelines()->create([
                'user_id' => Auth::user()->id,
                'titulo' => 'Pendência criada',
                'descricao' => "A seguinte pendência foi criada: <br><b>$pendencia->nome</b>.",
                'tipo' => 'pp',
            ]);

            $this->createPendencia = false;
            $this->emit('$refresh');
            $this->clearFields();
            $this->emit('warning', 'Pendência criada com sucesso!');
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao criar pendência!');
        }
    }

    public function clearFields()
    {
        $this->name = null;
        $this->tipo = null;
        $this->observacao = null;
    }

    public function deletePendencia($id)
    {
        try {
            if ($this->hasConludeOrExcluded()) {
                return;
            }
            $pendencia = Pendencia::find($id);
            $pendencia->delete();

            $pendencia->pedido->timelines()->create([
                'user_id' => Auth::user()->id,
                'titulo' => 'Pendência excluída',
                'descricao' => "A seguinte pendência foi excluída: <br><b>$pendencia->nome</b>.",
                'tipo' => 'ep',
                'privado' => Auth::user()->isDespachante(),
            ]);

            $this->emit('$refresh');
        } catch (Throwable $th) {
            Log::error($th);
            $this->emit('error', 'Erro ao excluir pendência!');
        }
    }

    public function render()
    {
        $this->pendencias = Auth::user()->empresa()->pedidos()->find($this->pedidoId)->pendencias->sortByDesc('id');

        return view('livewire.pendencias');
    }
}
