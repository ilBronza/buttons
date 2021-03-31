<li class="{{ $button->getClasses() }} {{ ($button->isChild())? 'uk-nav-divider' : '' }}">

    <a href="{{ $button->href ?? 'javascript:void(0)' }}"

    @if($button->tooltip)
        uk-tooltip title="{{ $button->tooltip }}"
    @endif
    >
        @if($button->dgIcon))
            <span class="dg-icon dg-icon-{{ $button->dgIcon }}"></span>
        @endif

        @if($button->count)
            <span class="count uk-badge">{{ $button->count }}</span>
        @endif

        @if($button->text)
            <span>{{ $button->text }}</span>
        @endif
    </a>

    @if(count($button->children))

        @if(count($button->children) < 15)
            <div class="uk-navbar-dropdown">
                <ul class="uk-nav uk-navbar-dropdown-nav">
                @foreach ($button->children as $child)
                    @include('utilities.buttons.__dgButton', ['button' => $child])
                @endforeach
                </ul>
            </div>
        @else

            <div class="uk-width-xlarge" style="max-width: none;" uk-dropdown>
                <div class="uk-dropdown-grid uk-child-width-1-2@m" uk-grid>
                    <div>
                        <ul class="uk-nav uk-dropdown-nav">
                            @foreach ($button->children as $child)
                                    @include('utilities.buttons.__dgButton', ['button' => $child])
                                @if($loop->index == floor(count($button->children) / 2))
                        </ul>
                    </div>
                    <div>
                        <ul class="uk-nav uk-dropdown-nav">
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

    @endif
</li>
