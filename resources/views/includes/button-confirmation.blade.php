@if ($button['btnType'] == 'button')
    <button class="jsButtonConfirmation {{ $button['btnClass'] }} {{ $button['btnIcon'] }}"
        data-type="{{ $button['btnStyle'] }}" data-message="{{ $button['btnMessage'] }} Confirme para continuar."
        data-action="{{ $button['btnAction'] }}" type="button">
        <span class="{{ !empty($button['btnText']) ? 'ml-1' : null }}">{{ $button['btnText'] }}</span>
    </button>
@elseif($button['btnType'] == 'link')
    <a class="jsButtonConfirmation {{ $button['btnClass'] }} {{ $button['btnIcon'] }}" href="{{ $button['btnAction'] }}"
        data-type="{{ $button['btnStyle'] }}" data-message="{{ $button['btnMessage'] }} Confirme para continuar."
        data-action="{{ $button['btnAction'] }}">
        <span class="{{ !empty($button['btnText']) ? 'ml-1' : null }}">{{ $button['btnText'] }}</span>
    </a>
@endif
