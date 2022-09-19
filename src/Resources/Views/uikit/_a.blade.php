<a
	href="{{ $button->getHref() }}"

	id="{{ $button->getContextId() }}"
	{!! $button->renderToggle() !!}

	>

	{!! $button->renderFaIcon() !!}
	{!! $button->getText() !!}

	@if($countValue = $button->getCount())
		<span class="count uk-badge">{{ $countValue }}</span>
	@endif

	@if($button->hasChildren()) <span uk-nav-parent-icon></span> @endif
</a>
