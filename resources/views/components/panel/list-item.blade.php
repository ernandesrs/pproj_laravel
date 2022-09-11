<div class="list-item d-flex align-items-center pb-3 mb-3">
    @if ($cover ?? null)
        <div class="item-cover {{ $coverStyle ?? null }} d-none d-sm-flex align-items-center">
            <img class="img-fluid img-thumbnail" src="{{ $cover }}" alt="Cover">
        </div>
    @endif

    <div class="d-flex flex-column flex-sm-row align-items-center w-100">
        <div class="item-content px-2">
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

        <div class="ml-sm-auto text-center py-2">
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
            box-shadow: 0 4px 4px -4px #ccc;
        }

        .list-item:hover {
            opacity: 1;
            transition-duration: .25s;
            box-shadow: 0 12px 12px -12px #ccc;
        }

        .list-item>.item-cover {
            width: 150px;
        }

        .list-item>.item-cover.square-rounded {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 80px;
            height: 80px;
        }
        
        .list-item>.item-cover.square-rounded>img {
            border-radius: 50%;
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
