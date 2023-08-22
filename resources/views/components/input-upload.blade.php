<div
    x-data="{ isUploading: false, error: false, input: $('#{{$propName}}')}"
    x-on:livewire-upload-start=" isUploading=true"
    x-on:livewire-upload-finish="isUploading = false;input.addClass('is-valid')"
    x-on:livewire-upload-error="error = true"
    x-on:livewire-upload-progress="input.removeClass('is-invalid');input.removeClass('is-valid')">

    <label class="form-label">{{ $label}}
        <span class="ps-3 text-muted" x-show="isUploading">
            Validando...
        </span>
        <div class="ps-3 text-muted" wire:loading wire:target="{{$uploadMethod}}">
            Enviando...
            <span class="spinner-border spinner-border-sm text-green"
                  role="status"></span>
        </div>
    </label>
    <div class="input-icon mb-2">
        <input :disabled="isUploading"
               class="form-control @error($propName) is-invalid @enderror"
               id="{{$propName}}" type="file" accept="application/pdf"
               wire:model="{{$propName}}">
        @error($propName) <span x-show="!isUploading"
                                class="invalid-feedback">{{ $message }}</span> @enderror
        <span x-show="isUploading" class="input-icon-addon">
            <div class="spinner-border spinner-border-sm text-muted"
                 role="status"></div>
        </span>
    </div>
</div>
