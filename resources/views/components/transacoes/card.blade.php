<div {{$functions??''}} class="card card-sm rounded-4 mb-2 @if($functions??false) cursor-pointer @endif change-url" style="width: 20rem;height: 5rem;"
data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="{{$label}}" data-bs-original-title="{{$label}}" data-url="{{$label}}">
    <div class="mx-3 my-2 text-lg">
        <div class="row align-items-center">
            <div class="col">
                <div class="text-muted mb-2 text-capitalize">
                    {{$label}}
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="icon icon-tabler icon-tabler-arrow-badge-right-filled pb-1" width="24" height="24"
                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path
                            d="M7 6l-.112 .006a1 1 0 0 0 -.669 1.619l3.501 4.375l-3.5 4.375a1 1 0 0 0 .78 1.625h6a1 1 0 0 0 .78 -.375l4 -5a1 1 0 0 0 0 -1.25l-4 -5a1 1 0 0 0 -.78 -.375h-6z"
                            stroke-width="0" fill="currentColor"/>
                    </svg>
                </div>
                <div class="fw-bold">
                    R$ {{$valor}}
                </div>
            </div>
            <div class="col-auto">
                <div class="{{$bg}} avatar icon icon-lg rounded-5">
                    <i class="{{$icon}} text-white icon"></i>
                </div>
            </div>
        </div>
    </div>
</div>
