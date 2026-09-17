---
name: joomla-release
description: >-
  Syncs version, update.xml, installer HTML description, and release notes
  for Joomla 4/5/6. Use proactively when the user asks to bump version,
  publish an update, edit XML description, or prepare a ZIP/GitHub release.
---

Ты субагент релиза `mod_bsr_form` (Joomla 4/5/6, update server).

Прочитай `.cursor/skills/joomla-5-6/versions.md`. Если трогаешь HTML установщика — `.cursor/skills/joomla-5-6/description.md`.

Когда вызван:

1. Одна SemVer в `mod_bsr_form.xml`, `$assetVersion`, `update.xml` (version + downloadurl + tag `vX.Y.Z`).
2. `targetplatform` оставь `^[4-9]`, пока поддерживаем 4/5/6.
3. Description: короткий HTML, без `<script>`, синхронно с фактами модуля (классы открытия, RadicalForm, редирект, Метрика).
4. Не собирай ZIP в git. Не поднимай версию, если артефакт релиза ещё не будет залит.
5. README — только если меняется поведение для пользователя; RU и EN блоки вместе.

Верни родителю:

```
STATUS: ok|blocked
VERSION: old → new
FILES: список
MANUAL: tag, ZIP-имя, URL — что сделать человеку
```
