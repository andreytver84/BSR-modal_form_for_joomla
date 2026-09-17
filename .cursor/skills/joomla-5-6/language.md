# Языковые константы

## Файлы (держать ключи синхронно)

| Файл | Назначение |
|---|---|
| `language/ru-RU/ru-RU.mod_bsr_form.ini` | runtime RU |
| `language/en-GB/en-GB.mod_bsr_form.ini` | runtime EN |
| `language/ru-RU/ru-RU.mod_bsr_form.sys.ini` | установщик/список модулей RU |
| `language/en-GB/en-GB.mod_bsr_form.sys.ini` | установщик/список модулей EN |

Не переименовывать в `mod_bsr_form.ini` без задачи: текущие имена с префиксом локали рабочие.

## Правила

- UTF-8 без BOM, `\n` переводы строк.
- `KEY="value"`. Ключ: `MOD_BSR_FORM_` + UPPER_SNAKE.
- В XML: `label="MOD_BSR_FORM_FIELD_…_LABEL"`, `description="…_DESC"`.
- Дефолты полей: ключ + `translate_default="true"` (`MOD_BSR_FORM_DEFAULT_*`).
- В PHP/tmpl: `Text::_('MOD_BSR_FORM_…')`. Для JS — `Text::script` + `Joomla.Text._`, либо data-атрибут (как `data-phone-error`).
- `.sys.ini` минимум: `MOD_BSR_FORM`, `MOD_BSR_FORM_XML_DESCRIPTION`.
- HTML в значениях — только `*_DESC` и instruction-блоки. Внутри кавычки удваивать: `"Say ""Hello"""`.
- Не переводить имена полей HTML (`name`, CSS-классы, `rfSubject`).

## Чеклист новой строки

1. Ключ в RU `.ini` и EN `.ini` (или оба `.sys.ini`).
2. Использование в XML или `Text::_`.
3. Карта ключей совпадает (можно сравнить `^[A-Z0-9_]+` без значений).
4. Не оставлять ключ только в одной локали.

`MOD_BSR_FORM_INSTRUCTIONS_HTML` есть в EN `.ini`; если правишь инструкции — либо добавь RU-ключ, либо держи HTML в `<description>` XML и не плоди дубли.
