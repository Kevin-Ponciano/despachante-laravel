<div class="offcanvas offcanvas-{{$direction}}" tabindex="-1" id="{{$id??'offcanvas'}}" style="width: 35rem;"
     aria-labelledby="offcanvas{{\Str::ucfirst($direction)}}Label">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title" id="offcanvas{{\Str::ucfirst($direction)}}Label">{{$title}}</h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        {{$slot}}
    </div>
</div>
