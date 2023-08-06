<form wire:submit.prevent="store" x-data="{isEditing:true}">
    @csrf
    <div class="p-3">
        <div class="d-flex justify-content-between">
            <div class="col-auto">
                <div class="mb-3">
                    <label class="form-label">Cliente Logista</label>
                    <div wire:ignore>
                        <select id="select-cliente-atpv-novo"
                                class="form-control"
                                wire:model.defer="clienteId">
                            @error('clienteId')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                            <option value="-1">Selecione o Cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="is-invalid"></div>
                    @error('clienteId')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <x-atpv-form :is-renave="$isRenave"/>
    </div>
    <div class="modal-footer p-3">
        <a href="#" wire:click="clearInputs" class="btn btn-link link-secondary"
           data-bs-dismiss="modal">
            Cancelar
        </a>
        <button type="submit" class="btn btn-primary ms-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                 stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                 stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 5l0 14"></path>
                <path d="M5 12l14 0"></path>
            </svg>
            Criar novo @if($isRenave)
                RENAVE
            @else
                ATPV
            @endif
        </button>
    </div>
</form>

