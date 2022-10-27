<li>

    @if($button->href)

    <a
        @if(! $button->isAjaxButton())
        href="{{ $button->href }}"
        @endif

        @if(count($button->classes))
        class="{{ implode(" ", $button->classes) }}"
        @endif

        @foreach($button->attributes as $name => $value)
            {{ $name }} = "{{ $value }}"
        @endforeach

        @if($buttonId = $button->getId())
        id="{{ $buttonId }}"
        @endif

        @if(count($button->data))
            @foreach($button->data as $name => $value)
            data-{{ $name }} = "{{ $value }}"
            @endforeach
        @endif

        @isset($button->ukIcon)
        uk-icon="{{ $button->ukIcon }}"
        @endisset

        >

    {{ $button->text }}

    </a>

    @else

    <button

        @if(count($button->classes))
        class="{{ implode(" ", $button->classes) }}"
        @endif

        @if($buttonId = $button->getId())
        id="{{ $buttonId }}"
        @endif

        @if(count($button->data))
            @foreach($button->data as $name => $value)
            data-{{ $name }} = "{{ $value }}"
            @endforeach
        @endif

        @foreach($button->attributes as $name => $value)
            {{ $name }} = "{{ $value }}"
        @endforeach

        @if($button->submit)
        type="submit"
        @endif

        @isset($button->ukIcon)
        uk-icon="{{ $button->ukIcon }}"
        @endisset

        >
        {{ $button->text }}

    </button>

    @endif

</li>