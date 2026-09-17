# Безопасность Joomla 5/6 (этот модуль)

Форма уходит через RadicalForm. Не добавляй свой PHP-endpoint без CSRF-токена (`Session\Session` / `HTMLHelper::_('form.token')`).

## Обязательно

```php
defined('_JEXEC') or die;
```

Вывод в HTML:

```php
htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
```

HTML из редактора (`agreement_text`):

```php
InputFilter::getInstance()->clean((string) $html, 'html');
```

Не прогонять уже очищенный HTML через `htmlspecialchars` в tmpl (сломает разметку согласия).

## Санитайзеры — переиспользовать, не копировать заново

| Функция | Правило |
|---|---|
| `bsrSanitizeRedirectUrl` | только `/path`, без `//`, `\`, `javascript:`, `data:`, `vbscript:`, схем |
| `bsrSanitizeColor` | `#RGB` / `#RRGGBB` / `#RRGGBBAA` |
| `bsrSanitizeFormId` | `[A-Za-z0-9_-]` |
| `bsrSanitizeCssClasses` | буквы/цифры/пробел/`_`/`-` |
| YM goal | `[A-Za-z0-9_-]` |
| phone mask | ограниченный charset из php-входа |
| field `name` | `[A-Za-z0-9_-]`, пустой — `continue` |
| field `type` | whitelist text/tel/email/date/textarea/file/select |

JS дублирует проверку редиректа (`isSafeRedirect`). Не ослаблять.

## Запреты

- `echo $params->get(...)` без санитайза.
- `eval`, `unserialize` пользовательских данных, `innerHTML` из params в JS.
- Абсолютные/внешние редиректы из настройки модуля.
- Менять `accept` файлов в более широкий список без задачи.
- Читать/патчить `imask.min.js`.
- SQL: если появится БД — только query/bind, никогда конкатенация.

## Ассеты

Пути только через `Uri::root(true) . '/modules/mod_bsr_form/assets/...'`. Не вставлять произвольный URL из params в `addScript`.
