# IlBronza/Buttons

Laravel package (`ilbronza/buttons`) that builds HTML buttons, dropdowns and navbars rendered with UIkit Blade views. Part of the IlBronza package family and meant to be used together with its sibling packages.

## Architecture

- `src/Button.php` — the core class. Almost all behavior lives in traits (see `src/Traits/`): setters, getters, text, children/dropdown, style, toggle, rendering.
- `src/Icons/` — `Icon` (abstract) and `FaIcon` (Font Awesome). Config in `config/buttons.php` (`faIcons.fillingType`, `faIcons.viewType`).
- `src/Helpers/DefaultButtonsCreatorHelper.php` — static factories for common buttons (`getEditButton($model)`, `getShowButton($model)`) built from a `BaseModel`'s URLs.
- `resources/views/` — Blade views, namespace `buttons::`. The active template set is `uikit/` (button, submit, `_a`, `_dropdown`, `_nav`, `navbar/horizontal|vertical|pdf`, `partials/toggle`). Root-level `__*.blade.php` views are legacy.
- `resources/lang/it/buttons.php` — translations (namespace `buttons::`), Italian only.
- `ButtonsServiceProvider` registers views + translations under the `buttons` namespace and a `button` singleton with a `Button` facade alias.

### Cross-package dependencies (not in composer.json!)

`composer.json` has an empty `require`, but the code hard-depends on sibling IlBronza packages:

- `IlBronza\CRUD` — `CRUDHasRolesInterface`, `IlBronzaHasRolesTrait`, `UserRolesPermissionsHelper` (role-gated rendering), `BaseModel`
- `IlBronza\Form` — `setForm()` binding
- `IlBronza\Menu` — `InteractsWithNavbarTrait`, `config('menu.childrenPerColumn')`
- `IlBronza\UikitTemplate` — `UseTemplateTrait` resolves the actual view names (`getTemplateViewName()`)

The package cannot work standalone. Keep this in mind when testing or refactoring.

## Core API

### Creating

```php
$button = Button::create([
    'href' => $model->getEditUrl(),
    'translatedText' => 'Modifica',   // literal text
    'text' => 'buttons::buttons.edit', // passed through trans()
    'icon' => 'pen',                   // Font Awesome code → FaIcon
    'children' => [ [...], [...] ],    // nested button parameter arrays
]);
```

The constructor assigns any array key to a public property. Button `name` is resolved in order: `name` → `label`/`text`/`translatedText` → slug of `href` → random number.

### Fluent setters (return `$this`/`static`)

`setText()`, `setTranslatedText()`, `setShowText(bool)`, `setPrimary()`, `setSecondary()`, `setDanger()`, `setSmall()`, `setHtmlClass()`, `setDisabled()`, `setSubmit()`, `setFirst()`, `addData(array)`, `setData(key, value)`, `setForm(Form)`, `setAsIframe()`, `tooltip()`.

Void/non-fluent setters: `setHref()`, `setTarget()` / `setBlank()`, `setName()`, `setId()`, `setIcon()`, `setReturnConfirm(?message)`, `setAsLightbox()`, `setToggle(id)` / `setToggleClass(class)`, `setDropdownMode('hover'|'click')`, `setPosition(float)` / `setLast()` (navbar ordering).

### Children / dropdowns

`addChild($button)`, `addButton($button)` (alias), `addChildFromArray($params)`, `addChildrenFromArray($arrays)`. Children render as UIkit dropdowns; columns computed from `childrenPerColumn` (fallback `config('menu.childrenPerColumn')`), capped at 6. `setDropdownColumns()`, `setChildrenPerColumn()`.

### Rendering

- `render()` / `renderButton()` → `buttons::uikit.button`
- `renderSubmit()` → submit view
- `renderA()` / `renderLink()` → anchor without the `uk-button` class
- `navbarRender('horizontal'|'vertical'|'pdf')` → navbar views
- `renderLi()` → list item; `renderToggle()` → UIkit toggle partial
- `renderJsMethod()` / `renderJsRedirect()` → JS snippets for datatables buttons

Rendering is role-gated: `renderType()` returns `null` if `UserRolesPermissionsHelper::hasValidItemRoles($this)` fails. A button silently not rendering is usually a roles/permissions issue.

`getHref()` fallback chain: `href` → `route($this->route)` → `route($this->routeName, $this->routeParameters)` → `javascript:void(0)`. Tag is `<a>` when an href exists, `<button>` otherwise.

### Ajax / datatables

`setAjaxTableButton(?selector, data)` and `setSubmitTableButton(?selector, data)` mark the button as an ajax table action (`ib-table-action-button` class, `data-route`, etc.). `setReturnConfirm()` wraps redirects in `window.confirm`.

## Conventions

- Icons are Font Awesome via `FaIcon`; `ukIcon` / `setUkIcon()` are **deprecated** — don't use in new code, don't remove yet (views still fall back to it).
- CSS is UIkit (`uk-button`, `uk-button-primary`, …). The button name slug is auto-appended as a class.
- Indentation is inconsistent (tabs and 4-space blocks coexist); match the surrounding code.
- Comments are mixed Italian/English.

## Known quirks (do not "fix" silently)

- `haasValue()` — typo'd method name, but may be called externally; if renaming, keep an alias.
- `NewButtonMethodsTraitToRenameAfterHaveMovedEverything` — staging trait holding newer properties/`setNameByParameters()`; long-term goal is to fold it into the other traits.
- The `button` singleton in the service provider calls `new Button` without the required `array $parameters` argument — it would fail if ever resolved; the facade is effectively unused in favor of `Button::create()`.
- `bootForConsole()` publishes `config/button.php` (singular) but the real file is `config/buttons.php`.
- `getReturnConfirmText()` falls back to `trans('buttons::messages.areYouSure')`, but no `messages.php` lang file exists — the raw key is displayed unless the host app provides it.
- `config('buttons.dropdownMode')` is read with a `'hover'` default but is not present in `config/buttons.php`.

## Testing

`composer test` runs PHPUnit via Orchestra Testbench 10. The sibling packages (Crud, Form, Menu, UikitTemplate) are installed in `require-dev` through composer `path` repositories pointing at the sister folders (`../Crud` etc.), so tests must run from a checkout that lives next to them.

- `tests/TestCase.php` — Testbench base: registers `ButtonsServiceProvider`, sets locale `it`, `app.template` to `UikitTemplate::class` (needed by `UseTemplateTrait`) and `menu.childrenPerColumn`.
- `tests/Unit/` — logic: name resolution, setters, text/trans, href chain, children/dropdown columns.
- `tests/Feature/` — rendered HTML (button, submit, dropdown, toggle, icons) and role-gated rendering with `tests/Stubs/TestUser` (`isSuperAdmin()`, `hasAnyRole()`).
- Some tests are regression tests for the quirks above (`haasValue()`, missing `messages.php`): if one fails after a "fix", update the test knowingly, don't delete it.
