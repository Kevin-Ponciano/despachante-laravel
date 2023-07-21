<?php

namespace App\Http\Livewire;

use App\Models\Atpv;
use Livewire\Component;

class AtpvShow extends Component
{
    public $atpv;
    public $isRenave = true;
    public $col_length;
    public $servicos=[];
    public $status = 'ab';

    public function mount($id)
    {
        $this->atpv = Atpv::find($id);
        $this->col_length = $this->isRenave ? 3 : 4;
    }

    public function render()
    {

        return view('livewire.atpv-show')
            ->layout('layouts.despachante');
    }
}
