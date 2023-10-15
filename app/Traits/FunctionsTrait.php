<?php

namespace App\Traits;

use App\Http\Livewire\Pendencias;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

trait FunctionsTrait
{
    public function regexMoney($number)
    {
        return strtr($number, [
            '.' => '',
            ',' => '.',
        ]);
    }

    public function regexMoneyToView($number)
    {
        return strtr($number, [
            '.' => ',',
        ]);
    }

    public function setEndereco()
    {
        $cep = $this->onlyNumbers($this->endereco['cep']);
        $response = HTTP::get("http://viacep.com.br/ws/$cep/json/", 'GET')->json();
        if ($response === null)
            return $this->addError('endereco.cep', 'CEP inválido.');
        elseif (isset($response['erro']))
            return $this->addError('endereco.cep', 'CEP Não encontrado.');
        $this->endereco['cep'] = $response['cep'];
        $this->endereco['logradouro'] = $response['logradouro'];
        $this->endereco['bairro'] = $response['bairro'];
        $this->endereco['cidade'] = $response['localidade'];
        $this->endereco['uf'] = $response['uf'];
        return $this->resetErrorBag('endereco.cep');
    }

    public function onlyNumbers($string)
    {
        return preg_replace('/[^0-9]/', '', $string);
    }

    public function play()
    {
        if (Pendencias::hasPendingStatic($this->pedido->id))
            return $this->emit('modal-aviso');

        $this->status = 'ea';
        $this->pedido->update([
            'status' => $this->status,
            'responsavel_por' => Auth::user()->id,
        ]);

        $this->pedido->timelines()->create([
            'user_id' => Auth::user()->id,
            'titulo' => 'Pedido em Andamento',
            'descricao' => '',
            'tipo' => 'tp',
        ]);

        $this->emit('$refresh');
        $this->emit('info', ['message' => 'Pedido em andamento']);
    }

    public function reopen()
    {
        $this->status = 'ab';
        $this->pedido->update([
            'status' => $this->status,
        ]);

        $this->pedido->timelines()->create([
            'user_id' => Auth::user()->id,
            'titulo' => 'Pedido Reaberto',
            'descricao' => '',
            'tipo' => 'op',
        ]);

        $this->emit('$refresh');
        $this->emit('success', ['message' => 'Pedido Reaberto']);
    }

    public function conclude()
    {
        if (Pendencias::hasPendingStatic($this->pedido->id))
            return $this->emit('modal-aviso');

        $numero_pedido = $this->pedido->numero_pedido;
        $this->status = 'co';
        $this->pedido->update([
            'status' => $this->status,
            'concluido_por' => Auth::user()->id,
            'concluido_em' => now(),
        ]);

        $this->pedido->timelines()->create([
            'user_id' => Auth::user()->id,
            'titulo' => 'Pedido Concluído',
            'descricao' => '',
            'tipo' => 'cp',
        ]);

        session()->flash('success', "Pedido $numero_pedido Concluído");
        return redirect()->route('despachante.dashboard');
    }

    public function delete()
    {
        if (Pendencias::hasPendingStatic($this->pedido->id))
            return $this->emit('modal-aviso');

        $numero_pedido = $this->pedido->numero_pedido;
        $this->status = 'ex';
        $this->pedido->update([
            'status' => $this->status,
        ]);

        $this->pedido->timelines()->create([
            'user_id' => Auth::user()->id,
            'titulo' => 'Pedido Excluído',
            'descricao' => '',
            'tipo' => 'ep',
        ]);

        $this->pedido->delete();
        session()->flash('error', "Pedido $numero_pedido Excluído");
        return redirect()->route('despachante.dashboard');
    }

    public function hasConludeOrExcluded()
    {
        if ($this->status === 'co' || $this->status === 'ex') {
            $this->emit('warning', 'Pedido concluído ou excluído não pode ser editado.');
            return true;
        } else {
            return false;
        }
    }

}
