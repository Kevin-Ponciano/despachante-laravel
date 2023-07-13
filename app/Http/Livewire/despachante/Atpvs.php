<?php

namespace App\Http\Livewire\despachante;

use App\Models\Atpv;
use Livewire\Component;

class Atpvs extends Component
{
    public $atpvs;
    public $teste = 'teste';

    public $queryString;
    public function render()
    {
        $this->queryString = ['teste'];
        $this->atpvs = Atpv::all();
        return view('livewire.despachante.atpvs')
            ->layout('layouts.despachante');
    }
}
