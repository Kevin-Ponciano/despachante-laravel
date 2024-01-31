@php
    if($tipo === 'in')
        $color = 'green';
    elseif($tipo === 'out')
        $color = 'red';
    else
        $color = 'primary';
@endphp
<div class="d-flex justify-content-center align-items-center mt-3">
    <div>
        <button class="btn btn-ghost-{{$color}} rounded-5 mx-1"
                wire:click="previous"> &lt;
        </button>
        <button class="toggle-months text-capitalize btn btn-outline-{{$color}} rounded-5 mx-1"
                wire:click="toggleShowMonth">
            @if($showMonth)
                {{ $mes }}
            @endif
            {{$ano}}
        </button>
        <button class="btn btn-ghost-{{$color}} rounded-5 mx-1"
                wire:click="next"> &gt;
        </button>
    </div>
</div>
<div wire:ignore.self id="months-menu" style="display: none;">
    <div class="d-flex justify-content-center align-items-center mt-3">
        <button wire:click="setMonth(1)"
                class="toggle-months btn btn-outline-{{$color}} rounded-5 mx-1">
            Jan
        </button>
        <button wire:click="setMonth(2)"
                class="toggle-months btn btn-outline-{{$color}} rounded-5 mx-1">
            Fev
        </button>
        <button wire:click="setMonth(3)"
                class="toggle-months btn btn-outline-{{$color}} rounded-5 mx-1">
            Mar
        </button>
        <button wire:click="setMonth(4)"
                class="toggle-months btn btn-outline-{{$color}} rounded-5 mx-1">
            Abr
        </button>
        <button wire:click="setMonth(5)"
                class="toggle-months btn btn-outline-{{$color}} rounded-5 mx-1">
            Mai
        </button>
        <button wire:click="setMonth(6)"
                class="toggle-months btn btn-outline-{{$color}} rounded-5 mx-1">
            Jun
        </button>
        <button wire:click="setMonth(7)"
                class="toggle-months btn btn-outline-{{$color}} rounded-5 mx-1">
            Jul
        </button>
        <button wire:click="setMonth(8)"
                class="toggle-months btn btn-outline-{{$color}} rounded-5 mx-1">
            Ago
        </button>
        <button wire:click="setMonth(9)"
                class="toggle-months btn btn-outline-{{$color}} rounded-5 mx-1">
            Set
        </button>
        <button wire:click="setMonth(10)"
                class="toggle-months btn btn-outline-{{$color}} rounded-5 mx-1">
            Out
        </button>
        <button wire:click="setMonth(11)"
                class="toggle-months btn btn-outline-{{$color}} rounded-5 mx-1">
            Nov
        </button>
        <button wire:click="setMonth(12)"
                class="toggle-months btn btn-outline-{{$color}} rounded-5 mx-1">
            Dez
        </button>
    </div>
</div>
