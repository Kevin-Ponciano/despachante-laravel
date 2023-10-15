<form wire:submit.prevent="{{$uploadMethod}}('{{$folder}}')"
      x-data="{ isUploading: false, error: false,input: $('#uploadFiles') }"
      x-on:livewire-upload-start="isUploading = true"
      x-on:livewire-upload-finish="isUploading = false;input.addClass('is-valid')"
      x-on:livewire-upload-error="error = true"
      x-on:livewire-upload-progress="input.removeClass('is-invalid');input.removeClass('is-valid')">

    <label class="form-label">{{ $label}}
        <span class="ps-3 text-muted" x-show="isUploading">
             Validando...
        </span>
        <div wire:loading wire:target="{{$uploadMethod}}">
            Enviando...
            <span class="spinner-border spinner-border-sm text-green"
                  role="status"></span>
        </div>
    </label>
    <div class="input-icon mb-2">
        <input :disabled="isUploading"
               class="form-control @error('arquivos.*') is-invalid @enderror"
               id="uploadFiles" type="file" accept="application/pdf" multiple
               wire:model="arquivos">
        @error('arquivos.*') <span x-show="!isUploading"
                                   class="invalid-feedback">{{ $message }}</span> @enderror
        <span x-show="isUploading" class="input-icon-addon">
            <div class="spinner-border spinner-border-sm text-muted"
                 role="status"></div>
        </span>
    </div>
    <div class="btn-list">
        <button type="submit" class="btn btn-primary" :disabled="isUploading">
            Enviar
        </button>
        @if(!empty($arquivos))
            <button type="button" class="btn btn-ghost-green" wire:click="downloadAllFiles('{{$folder}}')">
                <i class="ti ti-download px-2"></i>
                Baixar todos
            </button>
        @endif
    </div>
</form>
