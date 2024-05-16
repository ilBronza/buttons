<li class="@if($button->isActive()) uk-active @elseif($button->containsActiveElement()) uk-active @endif @if($button->hasChildren()) uk-parent @endif">

	@if(isset($buttonParentLevel))
	{{ $buttonParentLevel }}. 
	@endif

<a
	href="{{ $button->getHref() }}"

	class="@if($button->isActive()) uk-text-bold @endif {{ $button->getHtmlClassesString() }}"

	id="{{ $button->getContextId() }}"
	>

	@if($button->hasBadge())
		<span class="uk-badge">{!! $button->getBadgeHtml() !!}</span>
	@endif

	{!! $button->renderFaIcon() !!}
	{!! $button->getText() !!}

	@if($countValue = $button->getCount())
		<span class="count uk-badge">{{ $countValue }}</span>
	@endif
</a>

@if($button->hasChildren())
	<ul class="uk-nav-sub">
	@foreach($button->getChildren() as $child)
		@include('buttons::uikit.navbar.pdf', [
			'button' => $child,
			'buttonParentLevel' => (isset($buttonParentLevel)) ? (($buttonParentLevel . '. ') . $loop->index + 1) : ($loop->index + 1)
			])
	@endforeach
	</ul>
@endif


</li>