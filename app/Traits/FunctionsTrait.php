<?php

namespace App\Traits;

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

    public function onlyNumbers($string)
    {
        return preg_replace('/[^0-9]/', '', $string);
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

    public function play()
    {
        $this->status = 'ea';
        $this->pedido->update([
            'status' => 'ea',
            'responsavel_por' => Auth::user()->id,
        ]);
        $this->emit('$refresh');
        $this->emit('info', ['message' => 'Pedido em andamento']);
    }

    public function conclude()
    {
        $numero_pedido = $this->pedido->numero_pedido;
        $this->status = 'co';
        $this->pedido->update([
            'status' => 'co',
            'concluido_por' => Auth::user()->id,
        ]);
        session()->flash('success', "Pedido $numero_pedido Concluído");
        return redirect()->route('despachante.dashboard');
    }

    public function delete()
    {
        $numero_pedido = $this->pedido->numero_pedido;
        $this->status = 'ex';
        $this->pedido->update([
            'status' => 'ex',
        ]);
        session()->flash('error', "Pedido $numero_pedido Excluído");
        return redirect()->route('despachante.dashboard');
    }
}
