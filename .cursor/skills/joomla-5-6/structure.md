# Структура расширения Joomla 5/6

Актуально для **этого** репозитория. Не описывай CMS целиком.

## Текущее дерево

```
mod_bsr_form.php          вход модуля, санитайз, ассеты
mod_bsr_form.xml          манифест
tmpl/default.php          layout
language/ru-RU|en-GB/     .ini и .sys.ini
assets/css|js/            style.css, script.js, imask.min.js
update.xml                update server
```

Манифест: `type="module" client="site" method="upgrade"`. В `<files>`: php-вход (`module="mod_bsr_form"`), `tmpl`, `language`, `assets`.

## Совместимость 5 и 6

- PHP: Joomla 5 ≥ 8.1, Joomla 6 ≥ 8.3. Пиши PHP 8.1-совместимо (без 8.3-only), если не оговорено иначе.
- API: `Joomla\CMS\*` (Factory, Text, Uri, ModuleHelper, InputFilter).
- Запрещены legacy `JFactory` / `JText` / `JHtml` / `JRequest`.
- Bootstrap 5 / vanilla JS. jQuery не добавлять.
- `WebAssetManager` и `services/provider.php` — только при явной миграции.

## Если добавляют классы (по запросу)

```xml
<namespace path="src">Bestsite\Module\BsrForm</namespace>
```

```
services/provider.php
src/Dispatcher/Dispatcher.php
src/Helper/BsrFormHelper.php
```

Namespace site: `Bestsite\Module\BsrForm\Site\...`. В PHP: `\defined('_JEXEC') or die;`.

Пока миграции нет — логика остаётся в `mod_bsr_form.php` + `tmpl/default.php`.

## Layout

```php
$layoutPath = ModuleHelper::getLayoutPath('mod_bsr_form', $params->get('layout', 'default'));
```

Override в шаблоне сайта: `templates/<tmpl>/html/mod_bsr_form/default.php` — не ломать CSS-классы `bsr-*` и RadicalForm (`rf-button-send`, `rf-upload-button`, `data-rf-call`, `rfSubject`, `acception`).
