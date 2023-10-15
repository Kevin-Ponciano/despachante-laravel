<style>
    b {
        font-weight: 900;
    }
</style>
<ul class="steps steps-vertical">
    @foreach($timelines as $timeline)
        @if($timeline->privado && Auth::user()->isDespachante())
            <x-timeline-item :timeline="$timeline"/>
        @elseif(!$timeline->privado)
            <x-timeline-item :timeline="$timeline"/>
        @endif
    @endforeach
</ul>
