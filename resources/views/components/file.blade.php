<div class="{{$col??'col-2'}}">
    <div class="card">
        <div class="text-center">
            <div class="row">
                <div class="d-flex justify-content-end">
                    <div class="dropdown">
                        <a href="#" class="btn-action" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dots" width="24"
                                 height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                            </svg>
                        </a>
                        <div class="dropdown-menu">
{{--                            <a href="{{$link}}" target="_blank" class="dropdown-item">Visualizar</a>--}}
                            <a wire:click="visualizar('{{$path}}')" class="dropdown-item cursor-pointer">Visualizar</a>
                            <a wire:click="downloadFile('{{$path}}')" class="dropdown-item cursor-pointer">Download</a>
                            @can(['[DESPACHANTE] - Acessar Sistema'])
                                <a href="#"
                                   onclick="$(window).trigger('deleteFile', {path: '{{$path}}',nome: '{{$nome}}',})"
                                   class=" dropdown-item deleteFile text-danger">Excluir</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-1">
                    <div class="font-weight-medium">
                        <a wire:click="visualizar('{{$path}}')" class="text-decoration-none text-reset cursor-pointer">
                            <svg width="48px" height="48px" viewBox="0 0 400 400"
                                 xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <style>.cls-1 {
                                            fill: #ff402f;
                                        }</style>
                                </defs>
                                <g id="xxx-word">
                                    <path class="cls-1"
                                          d="M325,105H250a5,5,0,0,1-5-5V25a5,5,0,0,1,10,0V95h70a5,5,0,0,1,0,10Z"/>
                                    <path class="cls-1"
                                          d="M325,154.83a5,5,0,0,1-5-5V102.07L247.93,30H100A20,20,0,0,0,80,50v98.17a5,5,0,0,1-10,0V50a30,30,0,0,1,30-30H250a5,5,0,0,1,3.54,1.46l75,75A5,5,0,0,1,330,100v49.83A5,5,0,0,1,325,154.83Z"/>
                                    <path class="cls-1"
                                          d="M300,380H100a30,30,0,0,1-30-30V275a5,5,0,0,1,10,0v75a20,20,0,0,0,20,20H300a20,20,0,0,0,20-20V275a5,5,0,0,1,10,0v75A30,30,0,0,1,300,380Z"/>
                                    <path class="cls-1"
                                          d="M275,280H125a5,5,0,0,1,0-10H275a5,5,0,0,1,0,10Z"/>
                                    <path class="cls-1"
                                          d="M200,330H125a5,5,0,0,1,0-10h75a5,5,0,0,1,0,10Z"/>
                                    <path class="cls-1"
                                          d="M325,280H75a30,30,0,0,1-30-30V173.17a30,30,0,0,1,30-30h.2l250,1.66a30.09,30.09,0,0,1,29.81,30V250A30,30,0,0,1,325,280ZM75,153.17a20,20,0,0,0-20,20V250a20,20,0,0,0,20,20H325a20,20,0,0,0,20-20V174.83a20.06,20.06,0,0,0-19.88-20l-250-1.66Z"/>
                                    <path class="cls-1"
                                          d="M145,236h-9.61V182.68h21.84q9.34,0,13.85,4.71a16.37,16.37,0,0,1-.37,22.95,17.49,17.49,0,0,1-12.38,4.53H145Zm0-29.37h11.37q4.45,0,6.8-2.19a7.58,7.58,0,0,0,2.34-5.82,8,8,0,0,0-2.17-5.62q-2.17-2.34-7.83-2.34H145Z"/>
                                    <path class="cls-1"
                                          d="M183,236V182.68H202.7q10.9,0,17.5,7.71t6.6,19q0,11.33-6.8,18.95T200.55,236Zm9.88-7.85h8a14.36,14.36,0,0,0,10.94-4.84q4.49-4.84,4.49-14.41a21.91,21.91,0,0,0-3.93-13.22,12.22,12.22,0,0,0-10.37-5.41h-9.14Z"/>
                                    <path class="cls-1"
                                          d="M245.59,236H235.7V182.68h33.71v8.24H245.59v14.57h18.75v8H245.59Z"/>
                                </g>
                            </svg>
                            <div>{{$nome}}</div>
                        </a>
                    </div>
                </div>
                <div class="col-12 text-secondary">
                    {{$timestamp}}
                </div>
            </div>
        </div>
    </div>
</div>
