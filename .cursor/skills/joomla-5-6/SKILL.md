---
name: joomla-5-6
description: >-
  Guides Joomla 5/6 extension work for this repo with progressive disclosure.
  Use when editing mod_bsr_form, PHP/tmpl, language ini, manifest XML, update.xml,
  installer description, security sanitizers, versions, or RadicalForm integration.
---

# Joomla 5/6 для этого репозитория

Не загружай все справочники. Прочитай **один** файл по задаче, затем правь код.

| Задача | Файл | Субагент |
|---|---|---|
| Структура модуля, манифест, файлы | [structure.md](structure.md) | `joomla-structure` |
| Языковые константы ru/en | [language.md](language.md) | `joomla-lang` |
| XSS, JEXEC, санитайз, редирект | [security.md](security.md) | `joomla-security` |
| Версия, update.xml, релиз | [versions.md](versions.md) | `joomla-release` |
| HTML description в XML/установщике | [description.md](description.md) | `joomla-release` |

## Порядок

1. Определи тип задачи по таблице.
2. Если нужно больше 2 файлов или сверка 4 языковых — **делегируй субагенту**. В этот чат верни краткое резюме.
3. Не цитируй справочник пользователю. Не вставляй целые `.ini`/`.xml`.
4. Не читай `assets/js/imask.min.js`.
5. Текущая архитектура — классический site-модуль (вход `mod_bsr_form.php` + `tmpl/`). Не переписывай на DI, пока не попросили.

## Этот проект

- Элемент: `mod_bsr_form`. Зависимость: плагин RadicalForm.
- Языки: `ru-RU`, `en-GB`. Префикс ключей: `MOD_BSR_FORM_`.
- Совместимость: Joomla 4/5/6 (`targetplatform` `^[4-9]`).
- Версию держать одинаковой в манифесте, `$assetVersion`, `update.xml`.
