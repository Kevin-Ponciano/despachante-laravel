<form wire:submit.prevent="store" x-data="{isEditing:true, isPendingInput: false}">
    @csrf
    <div class="p-3">
        <div class="d-flex justify-content-between">
            @can('[DESPACHANTE] - Acessar Sistema')
                <div class="col-auto">
                    <div class="mb-3">
                        <label class="form-label">Cliente Logista</label>
                        <div wire:ignore>
                            <select @if($isRenave)id="select-cliente-renave-novo" @else id="select-cliente-atpv-novo"
                                    @endif
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
            @endcan
            @if($isRenave)
                <div class="col-auto mb-3">
                    <label class="form-label">Movimentação Renave</label>
                    <select class="form-control @error('movimentacao') is-invalid @enderror"
                            wire:model.defer="movimentacao">
                        <option value="">Selecione a Movimentação</option>
                        <option value="in">Entrada</option>
                        <option value="out">Saída</option>
                    </select>
                    @error('movimentacao')<span class="invalid-feedback"> {{ $message }}</span> @enderror
                </div>
            @endif
        </div>
        <x-atpv-form :is-renave="$isRenave"/>
        @if($isRenave)
            <div class="row mt-2" x-data="{ isUploading: false, error: false,input: $('#upload-file-nr') }"
                 x-on:livewire-upload-start="isUploading = true"
                 x-on:livewire-upload-finish="isUploading = false;input.addClass('is-valid')"
                 x-on:livewire-upload-error="error = true"
                 x-on:livewire-upload-progress="input.removeClass('is-invalid');input.removeClass('is-valid')">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <div class="form-label">Enviar Documentos .pdf</div>
                        <div class="input-icon">
                            <input :disabled="isUploading"
                                   class="form-control @error('arquivos.*') is-invalid @enderror"
                                   id="upload-file-nr" type="file" accept="application/pdf" multiple
                                   wire:model="arquivos">
                            @error('arquivos.*') <span x-show="!isUploading"
                                                       class="invalid-feedback">{{ $message }}</span> @enderror
                            <span x-show="isUploading" class="input-icon-addon">
                                        <div class="spinner-border spinner-border-sm text-muted" role="status"></div>
                                    </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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

