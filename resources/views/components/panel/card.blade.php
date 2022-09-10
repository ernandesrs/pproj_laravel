<div class="card border-0">
    <div class="card-header bg-transparent border-0 d-flex align-items-center">
        <div
            class="icon-square rounded-sm bg-{{ $style ?? 'primary' }} text-light d-flex justify-content-center align-items-center mr-2">
            {{ icon_elem($icon) }}
        </div>
        <h5 class="card-title mb-0">{{ $title }}</h5>
    </div>
    <div class="card-body shadow-sm pt-5">
        {{ $slot }}
    </div>
</div>

@section('styles')
    <style>
        .card-header {
            margin-bottom: -40px;
            z-index: 2
        }

        .card-header>.icon-square {
            width: 60px;
            height: 60px;
            font-size: 1.6rem;
        }

        .card-body {
            z-index: 1;
        }
    </style>
@endsection
