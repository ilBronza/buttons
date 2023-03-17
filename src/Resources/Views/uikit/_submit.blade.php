	<button 
		class="uk-button {{ $button->getHtmlClassesString() }}"
		type="submit"
		name="{{ $button->getName() }}"
		value="{{ $button->getValue() }}"
		id="{{ $button->getContextId() }}"

		@if($returnConfirm = $button->getReturnConfirmText())
		onclick="return confirm('{{ $returnConfirm }}')"
		@endif
		>

		{{ $button->getText() }}
		{!! $button->renderFaIcon() !!}

		@if($countValue = $button->getCount())
			<span class="count uk-badge">{{ $countValue }}</span>
		@endif

		@if($button->hasChildren()) <span uk-nav-parent-icon></span> @endif

	</button>
