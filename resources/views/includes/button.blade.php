@if ($button['btnType'] == 'button')
    <button class="{{ $button['btnClass'] }} {{ $button['btnIcon'] }} {{ $button['btnId'] }}" id="{{ $button['btnId'] }}"
        data-action="{{ $button['btnAction'] }}" data-active-icon="{{ $button['btnIcon'] }}"
        data-alt-icon="{{ $button['btnAltIcon'] }}" type="button">
        <span class="{{ empty($button['btnText']) ? '' : 'ml-1' }}">
            {{ $button['btnText'] }}
        </span>
    </button>
@else
    <a class="{{ $button['btnClass'] }} {{ $button['btnIcon'] }} {{ $button['btnId'] }}" id="{{ $button['btnId'] }}"
        data-action="{{ $button['btnAction'] }}" href="{{ $button['btnAction'] }}"
        data-active-icon="{{ $button['btnIcon'] }}" data-alt-icon="{{ $button['btnAltIcon'] }}">
        <span class="{{ empty($button['btnText']) ? '' : 'ml-1' }}">
            {{ $button['btnText'] }}
        </span>
    </a>
@endif
