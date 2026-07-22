# IlBronza/Buttons

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

Laravel package to build HTML buttons, dropdowns and navbars rendered with UIkit Blade views, with Font Awesome icons and role-gated rendering.

Part of the IlBronza package family: it depends on `IlBronza\CRUD`, `IlBronza\Form`, `IlBronza\Menu` and `IlBronza\UikitTemplate` and is not meant to be used standalone.

## Installation

Via Composer

``` bash
$ composer require ilbronza/buttons
```

The service provider is auto-discovered. Views and translations are registered under the `buttons::` namespace.

## Usage

### Creating a button

``` php
use IlBronza\Buttons\Button;

$button = Button::create([
    'href' => route('users.edit', $user),
    'translatedText' => 'Modifica',      // literal text
    'icon' => 'pen',                     // Font Awesome icon code
]);

echo $button->render();
```

Instead of `translatedText` you can pass `text` with a translation key: it will go through `trans()`. If an `href` is set the button renders as `<a>`, otherwise as `<button>`.

### Fluent styling

``` php
$button->setPrimary();        // uk-button-primary
$button->setDanger();         // uk-button-danger
$button->setSmall();          // uk-button-small
$button->setHtmlClass('my-class');
$button->setDisabled();
$button->tooltip('Edit this user');
$button->setBlank();          // target="_blank"
$button->setReturnConfirm('Are you sure?');
```

### Dropdowns (children)

``` php
$button = Button::create([
    'text' => 'menu.actions',
    'children' => [
        ['href' => route('users.edit', $user), 'translatedText' => 'Modifica', 'icon' => 'pen'],
        ['href' => route('users.show', $user), 'translatedText' => 'Mostra', 'icon' => 'link'],
    ],
]);
```

Children can also be added with `addChild($button)`, `addChildFromArray($parameters)` or `addChildrenFromArray($arrays)`. Dropdown behavior can be tuned with `setDropdownMode('hover'|'click')`, `setDropdownColumns()` and `setChildrenPerColumn()`.

### Rendering variants

``` php
$button->render();                    // standard UIkit button
$button->renderSubmit();              // submit button
$button->renderA();                   // plain anchor, no uk-button class
$button->navbarRender('horizontal');  // navbar item: horizontal, vertical or pdf
```

Rendering is role-gated through `IlBronza\CRUD`: if the current user lacks the required roles, the render methods return `null` and the button is simply not displayed.

### Default model buttons

``` php
use IlBronza\Buttons\Helpers\DefaultButtonsCreatorHelper;

DefaultButtonsCreatorHelper::getEditButton($model);
DefaultButtonsCreatorHelper::getShowButton($model);
```

### Icons

Icons are Font Awesome, wrapped by `IlBronza\Buttons\Icons\FaIcon` (aliased as `FaIcon`):

``` php
FaIcon::check();          // green check
FaIcon::xmark();          // red xmark
FaIcon::inline('user');   // any icon code
```

Defaults (filling type, view type) live in `config/buttons.php`.

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details.

## Security

If you discover any security related issues, please email davide@sistema.srl instead of using the issue tracker.

## Credits

- [Davide Bronzini][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/ilbronza/buttons.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/ilbronza/buttons.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/ilbronza/buttons
[link-downloads]: https://packagist.org/packages/ilbronza/buttons
[link-author]: https://github.com/ilbronza
[link-contributors]: ../../contributors
