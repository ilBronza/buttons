<a
	href="{{ $button->getHref() }}"

	class="{{ $button->getHtmlClassesString() }}"

	id="{{ $button->getContextId() }}"
	{!! $button->renderToggle() !!}

	@if($returnConfirm = $button->getReturnConfirmText())
	onclick="return confirm('{{ $returnConfirm }}')"
	@endif

	>

	{!! $button->renderImage() !!}

	{!! $button->renderFaIcon() !!}
	{!! $button->getText() !!}

	@if($countValue = $button->getCount())
		<span class="count uk-badge">{{ $countValue }}</span>
	@endif

	@if($button->hasChildren()) <span uk-nav-parent-icon></span> @endif
</a>
