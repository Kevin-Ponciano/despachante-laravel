<li class="step-item {{$timeline->getTipo()['step-color']}}">
    <div class="h4 m-0 text-capitalize">
        <i class="icon {{$timeline->getTipo()['icon']}}"></i>
        {{$timeline->titulo}}
        @if($timeline->privado)
            <i class="text-danger ti ti-lock"></i>
        @endif
    </div>
    <div>
        <div class="row">
            <div class="col-auto mt-3">
                <img src="{{$timeline->user->getProfilePhoto()}}" alt="user photo"
                     class="icon icon-md rounded-circle">
            </div>
            <div class="col">
                <div class="mt-1 fw-bolder">{{$timeline->user->name}}</div>
                <div class="text-wrap">{!!$timeline->descricao!!}</div>
                <div class="text-secondary">{{$timeline->getCreatedAt()}}</div>
            </div>
            <div class="col-auto align-self-center">
                <div class="badge {{$timeline->getTipo()['bg']}}"></div>
            </div>
        </div>
    </div>
</li>
