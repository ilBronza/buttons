<li class="@if($button->hasChildren()) uk-parent @endif {{ Str::slug($button->getName()) }}" @if($button->isIframe()) uk-lightbox @endif>

	@include('buttons::uikit._a')
	@include('buttons::uikit._dropdown')

</li>