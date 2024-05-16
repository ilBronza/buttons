<li class="@if($button->isActive()) uk-active @elseif($button->containsActiveElement()) uk-active @endif @if($button->hasChildren()) uk-parent @endif">

	@include('buttons::uikit._a')
	@include('buttons::uikit._nav')

</li>