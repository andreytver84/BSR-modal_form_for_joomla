# BSR Form — Универсальная всплывающая форма для Joomla 4/5 / Universal Pop-up Form for Joomla 4/5

[🇷🇺 Русский](#ру-русский) | [🇬🇧 English](#en-english)

---

<a name="ру-русский"></a>

## 🇷🇺 Русский

Универсальный модуль модального окна с динамическим конструктором полей. Предназначен для быстрой интеграции форм обратной связи на сайты под управлением CMS Joomla.

### 🚀 Основные возможности

- **Множественные формы:** Возможность размещать несколько независимых форм на одной странице без конфликтов JS.
- **Конструктор полей:** Добавление текстовых полей, телефонов, email, дат и текстовых областей через админку.
- **Динамический заголовок:** Автоматическая подстановка текста из нажатой кнопки в заголовок формы и тему письма.
- **Гибкий дизайн:** Настройка цветов кнопок, фокуса полей и CSS-классов напрямую из настроек модуля.
- **Маркетинг:** \* Поддержка целей **Яндекс.Метрики** (JS-событие).
  - Настраиваемый **редирект** на страницу "Спасибо" после успешной отправки.
- **Согласие с обработкой данных:** Встроенный чекбокс с редактируемым текстом (соответствие ФЗ-152).
- **Мультиязычность:** Полная поддержка языковых файлов Joomla (ru-RU, en-GB).

### 🛠 Зависимости

Модуль работает в связке с плагином [RadicalForm](https://radicalmart.ru/all/radicalform). Убедитесь, что плагин установлен и опубликован.

### 📦 Установка

1. Скачайте репозиторий или создайте ZIP-архив с содержимым папки модуля.
2. В админке Joomla перейдите в **Система -> Установка -> Расширения** (System -> Install -> Extensions).
3. Загрузите архив.

### 💡 Использование

**Как открыть форму**
Для вызова окна используйте CSS-классы на кнопках или ссылках:

1. **Общий вызов:** класс `bsr-open-modal` (откроет первую найденную форму на странице).
2. **Точечный вызов:** \* Задайте в настройках модуля **ID формы** (например, `feedback`).
   - Используйте класс кнопки `bsr-open-feedback`.

**Пример HTML:**
<button class="bsr-open-feedback sppb-btn">Сделать заказ</button>

---

<a name="en-english"></a>

## 🇬🇧 English

Universal modal window module with a dynamic field builder. Designed for quick integration of feedback forms into websites running on Joomla CMS.

### 🚀 Key Features

- **Multiple Forms:** Ability to place several independent forms on one page without JS conflicts.
- **Field Builder:** Add text fields, phones, emails, dates, and textareas directly via the admin panel.
- **Dynamic Title:** Automatic substitution of text from the clicked button into the form title and email subject.
- **Flexible Design:** Customize button colors, field focus, and CSS classes directly from the module settings.
- **Marketing Tools:** \* Support for **Yandex.Metrica** goals (JS event).
  - Configurable **redirect** to a "Thank You" page after successful submission.
- **Data Processing Consent:** Built-in checkbox with editable text (GDPR compliant).
- **Multilingual:** Full support for Joomla language files (ru-RU, en-GB).

### 🛠 Dependencies

The module works in conjunction with the [RadicalForm](https://radicalmart.ru/all/radicalform) plugin. Make sure the plugin is installed and enabled on your website.

### 📦 Installation

1. Download the repository or create a ZIP archive with the module folder contents.
2. In the Joomla admin panel, go to **System -> Install -> Extensions**.
3. Upload the archive.

### 💡 Usage

**How to open the form**
To call the window, use CSS classes on buttons or links:

1. **General call:** class `bsr-open-modal` (opens the first found form on the page).
2. **Specific call:** \* Set the **Form ID** in the module settings (for example, `feedback`).
   - Use the button class `bsr-open-feedback`.

**HTML Example:**
<button class="bsr-open-feedback sppb-btn">Make an order</button>

---

## 👤 Автор / Author

**Увиков Андрей (Andrey Uvikov)**

- Email: order@bestsite-studio.ru
- Сайт / Website: https://bestsite-tver.ru
