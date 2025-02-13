<li class="@if($button->hasChildren()) uk-parent @endif {{ Str::slug($button->getName()) }}">

	@include('buttons::uikit._a')
	@include('buttons::uikit._dropdown')

</li>