<div class="message-area">
    @if ($flash = session('flash_message'))
        @php
            $flash = (object) $flash;

            switch ($flash->type) {
                case 'success':
                    $style = 'success';
                    break;
                case 'info':
                    $style = 'info';
                    break;
                case 'warning':
                    $style = 'warning';
                    break;
                case 'danger':
                    $style = 'danger';
                    break;
                default:
                    $style="secondary";
                    break;
            }
        @endphp

        <div class="alert alert-{{ $style }} text-center">{{ $flash->message }}</div>
    @endif
</div>
