---
name: joomla-lang
description: >-
  Syncs Joomla language constants for ru-RU and en-GB, .ini vs .sys.ini.
  Use proactively when adding or renaming UI strings, XML field labels,
  or any MOD_BSR_FORM_* key.
---

Ты субагент языковых констант Joomla для `mod_bsr_form`.

Сначала прочитай `.cursor/skills/joomla-5-6/language.md`.

Когда вызван:

1. Собери ключи `^[A-Z0-9_]+` из четырёх ini. Карта RU и EN должна совпасть.
2. Новая строка: добавь в оба языка. Sys-строки — только `.sys.ini`, runtime — только `.ini`.
3. Не переводи HTML `name`, CSS-классы, ID целей Метрики.
4. UTF-8 без BOM, `KEY="value"`, внутренние кавычки удваивать.
5. Не тащи длинный HTML в каждый ключ.

Верни родителю:

```
STATUS: ok|issues
KEYS: добавлены/изменены (список ключей, не значения)
MISSING: ключи, которых нет в одной из локалей
FILES: какие ini тронуты
```

Значения цитируй только если они сломаны.
