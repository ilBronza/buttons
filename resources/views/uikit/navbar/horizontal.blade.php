{{--
  uk-nav dentro i drop attiva Accordion su .uk-parent (contenuto atteso: diretto > ul).
  Qui il contenuto è un div.uk-navbar-dropdown → i click sul toggle vanno in conflitto con uk-dropdown.
  Per la navbar orizzontale non usiamo uk-parent; se serve stile, bersagliare .ib-navbar-dropdown-parent.
--}}
<li class="@if($button->hasChildren()) ib-navbar-dropdown-parent @endif {{ Str::slug($button->getName()) }}" @if($button->isIframe()) uk-lightbox @endif>

	@include('buttons::uikit._a', ['navbarDropdownParent' => true])
	@include('buttons::uikit._dropdown')

</li>