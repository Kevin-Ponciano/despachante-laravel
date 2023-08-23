@props(['id' => 'accordion', 'active' => false,'title' => '', 'body' => '', 'class' => ''])
<div class="accordion bg-body">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button wire:ignore.self class="accordion-button @if($active === false) collapsed @endif" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#{{$id}}"
                    aria-expanded="false"
                    id="accordion-btn-{{$id}}">
                <div class="{{$class}}">
                    {{ $title }}
                </div>
            </button>
        </h2>
        <div wire:ignore.self id="{{$id}}" class="accordion-collapse collapse @if($active === true) show @endif"
             style="">
            <div class="accordion-body pt-0">
                {{ $body }}
            </div>
        </div>
    </div>
</div>
