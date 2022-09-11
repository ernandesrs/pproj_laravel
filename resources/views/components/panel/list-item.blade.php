<div class="list-item d-flex mb-4">
    @if ($cover ?? null)
        <div class="item-cover d-none d-md-flex align-items-center p-1">
            <img class="img-fluid img-thumbnail" src="{{ $cover }}" alt="{{ $title }}">
        </div>
    @endif

    <div class="d-flex flex-column flex-md-row align-items-center w-100">
        <div class="item-content px-2 py-2">
            <div>
                @if ($content ?? null)
                    {{ $content }}
                @else
                    @if ($url ?? null)
                        <a href="{{ $url }}" title="{{ $title }}" target="_blank">
                            <h2 class="title">{{ $title }}</h2>
                        </a>
                    @else
                        <h2 class="title">{{ $title }}</h2>
                    @endif
                    <p class="description">{{ $description }}</p>
                @endif
            </div>
            @if ($tags ?? null)
                <div>
                    {{ $tags }}
                </div>
            @endif
        </div>

        <div class="ml-md-auto text-center py-2">
            {{ $actions }}
        </div>
    </div>
</div>

@section('styles')
    <style>
        .list-item {
            cursor: default;
            opacity: 0.9;
            transition-duration: .25s;
        }

        .list-item:hover {
            opacity: 1;
            transition-duration: .25s;
        }

        .list-item>.item-cover {
            width: 150px;
        }

        .list-item .item-content {
            width: 100%;
            height: 100%;
        }

        .list-item .item-content .title,
        .list-item .item-content .description {
            margin: 0;
        }

        .list-item .item-content .title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .list-item .item-content .description {
            font-size: .825rem;
            font-weight: 500;
        }

        @media(min-width: 768px) {
            .list-item .item-content {
                max-width: 575px;
            }
        }

        @media(min-width: 1200px) {
            .list-item .item-content {
                max-width: 475px;
            }
        }
    </style>
@endsection
