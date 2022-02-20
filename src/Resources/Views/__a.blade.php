@if($button->iframe)
<div uk-lightbox>
@endif

    @if($button->href)

    <a

        @if((! empty($button->blank))&&($button->blank))
        target="_blank"
        @endif

        @if(($button->iframe))
        data-type="iframe"
        href="{{ $button->href }}?iframed=true"

        @else
        href="{{ $button->href }}"
            
            @if(isset($button->target))
            target="{{ $button->target }}"
            @endif

        @endif

        @if(($button->tooltip))
        uk-tooltip="title: {{ $button->tooltip }}"
        @endif

        @if(($button->tooltip))
        uk-tooltip="title: {{ $button->tooltip }}"
        @endif

        @if($classes = $button->getHtmlClassesString())
        class="{{ $classes }}"
        @endif

        @if(count($button->data))
            @foreach($button->data as $name => $value)
            data-{{ $name }} = "{{ $value }}"
            @endforeach
        @endif

        @if($button->ukIcon)
        uk-icon="{{ $button->ukIcon }}"
        @endif

        >
        {{ $button->text }}
    </a>

    @else

    <button

        @if(count($button->classes))
        class="{{ implode(" ", $button->classes) }}"
        @endif

        @if(count($button->data))
            @foreach($button->data as $name => $value)
            data-{{ $name }} = "{{ $value }}"
            @endforeach
        @endif

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

@if($button->iframe)
</div>
@endif
