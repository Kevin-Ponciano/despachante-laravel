<div class="modal modal-blur fade" wire:ignore.self id="{{$id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog {{$class ?? 'modal-lg'}}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$title}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body {{$classBody??''}}">
                {{$modalBody}}
            </div>
            <div class="modal-footer">
                {{$modalFooter??''}}
            </div>
        </div>
    </div>
</div>
