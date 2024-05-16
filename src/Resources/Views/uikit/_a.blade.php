@if($button->hasLightbox())
<div class="{{ $button->getHtmlClassesString() }}"
 uk-lightbox>
@endif

<a
	@if($button->hasLightbox())
	data-type="iframe"
	@endif

	href="{{ $button->getHref() }}"

	class="@if($button->isActive()) uk-text-bold @endif {{ $button->getHtmlClassesString() }}"

	id="{{ $button->getContextId() }}"
	{!! $button->renderToggle() !!}

	@if($target = $button->getTarget())
	target="{{ $target }}"
	@endif

	@if($button->hasReturnConfirm())
	onclick="return confirm('{{ $button->getReturnConfirmText() }}')"
	@endif
	>

	@if($button->hasBadge())
		<span class="uk-badge">{!! $button->getBadgeHtml() !!}</span>
	@endif

	{!! $button->renderImage() !!}

	{!! $button->renderFaIcon() !!}
	{!! $button->getText() !!}

	@if($countValue = $button->getCount())
		<span class="count uk-badge">{{ $countValue }}</span>
	@endif

	@if($button->hasChildren()) <span uk-nav-parent-icon></span> @endif
</a>

@if($button->hasLightbox())
</div>
@endif
