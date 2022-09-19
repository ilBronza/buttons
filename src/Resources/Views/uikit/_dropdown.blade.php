@if($button->hasChildren())
<div
	class="uk-navbar-dropdown uk-width-auto"
	uk-dropdown="@if($button->isChild()) pos: right-top; offset: 30 @endif"
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
