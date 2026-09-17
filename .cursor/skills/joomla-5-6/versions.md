# Версии и обновления

Источник правды — SemVer в трёх местах **одним значением** (сейчас `2.6.2`).

| Место | Что править |
|---|---|
| `mod_bsr_form.xml` | `<version>` |
| `mod_bsr_form.php` | `$assetVersion` (cache-bust CSS/JS) |
| `update.xml` | `<version>` и URL ZIP |

`update.xml`:

- `<element>mod_bsr_form</element>` `<type>module</type>` `<client>0</client>`
- `<targetplatform name="joomla" version="^[4-9]" />` — не сужать до одной мажорной, пока поддерживаем 4/5/6
- downloadurl: `.../releases/download/vX.Y.Z/mod_bsr_modal_vX.Y.Z.zip`
- infourl: страница релизов GitHub

Сервер в манифесте:

`https://raw.githubusercontent.com/andreytver84/BSR-modal_form_for_joomla/main/update.xml`

После пуша в `main` Joomla видит новую версию. ZIP не собран → не поднимай номер.

## Релиз-чеклист

1. Согласовать X.Y.Z (patch = фикс, minor = фича).
2. Заменить версию в xml/php/update.xml (включая downloadurl и тег `vX.Y.Z`).
3. Языки ru+en синхронны.
4. Description/README не противоречат возможностям.
5. Собрать ZIP **с корнем файлов модуля**, не с лишней обёрткой папки проекта.
6. GitHub Release tag `vX.Y.Z`, asset как в downloadurl.

Не коммить `.cursor/` в ZIP расширения.
