@php
$navigation = $model
    ->onEachSide(2)
    ->links()
    ->render();
@endphp

@if (!empty($navigation))
    <div class="d-flex justify-content-center justify-content-lg-end align-items-center pt-2 pb-4">
        @if ($text ?? null)
            <div class="d-none d-lg-block mr-2 font-weight-bold text-muted">
                {{ $text }}:
            </div>
        @endif
        {!! $navigation !!}
    </div>
@endif
