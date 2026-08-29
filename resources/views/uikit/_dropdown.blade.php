@if($button->hasChildren())
<div
	class="{{ $button->isChild() ? 'uk-dropdown' : 'uk-navbar-dropdown' }} @if(! $button->getDropdownWidth()) uk-width-auto @endif"
	@if($width = $button->getDropdownWidth())
		style="width: {{ $width }};"
	@endif
	@if($button->isChild())
	uk-dropdown="mode: {{ config('menu.buttons.dropdownMode', 'hover') }}; pos: right-top"
	@endif
	>
		<div class="uk-navbar-dropdown-grid uk-child-width-1-{{ $button->getChildrenColumnNumber() }}" uk-grid>

			<div>
				<ul class="uk-nav uk-navbar-dropdown-nav">
				@foreach($button->getChildren() as $child)
					{!! $child->navbarRender('horizontal') !!}

					@if(($loop->index) && (($loop->index + 1) % $button->getChildrenPerColumn() == 0) && (! $loop->last))
				</ul>
			</div>
			<div>
				<ul class="uk-nav uk-navbar-dropdown-nav">

					@endif
				@endforeach
				</ul>
			</div>

		</div>
</div>
@endif
