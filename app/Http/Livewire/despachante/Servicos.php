<?php

namespace App\Http\Livewire\despachante;

use App\Models\Servico;
use Livewire\Component;

class Servicos extends Component
{
    public $servicos;
    public $servicoIndexSelected;
    public $nomeNovo;
    public $valorNovo;
    public $descricaoNovo;

    public function mount()
    {
        $this->servicos = Servico::all()->toArray();
    }

    public function selectServico()
    {
        if($this->servicoIndexSelected == null) return;
        if($this->servicoIndexSelected == 'novo') {
            $this->showDivServico = 'novo';
            return;
        }
        debug($this->servicos[$this->servicoIndexSelected]);
    }


    public function updateServico($index)
    {
        debug($this->servicos[$index]);
    }
    public function render()
    {
        debug($this->descricaoNovo);
        return view('livewire.despachante.servicos')
            ->layout('layouts.despachante');
    }
}
