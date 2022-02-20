@if($button->iframe)
<div uk-lightbox>
@endif

<{!! $button->getTag() !!}

    @if($button->hasHref())
    href="{{ $button->getHref() }}"
    @endif

    class="{{ $button->getHtmlClassesString() }}"

    name="{{ $button->getName() }}"

    @if($button->haasValue())
    value="{{ $button->getValue() }}"
    @endif

    @if(count($button->data))
        @foreach($button->data as $name => $value)
        data-{{ $name }} = "{{ $value }}"
        @endforeach
    @endif

    @if($button->isSubmit())
    type="submit"
    @endif

    @isset($button->ukIcon)
    uk-icon="{{ $button->ukIcon }}"
    @endisset

    >
    {{ $button->getText() }}

</{!! $button->getTag() !!}>

@if($button->iframe)
</div>
@endif
