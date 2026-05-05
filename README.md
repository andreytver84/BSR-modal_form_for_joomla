# BSR Form — Универсальная всплывающая форма для Joomla 4/5 / Universal Pop-up Form for Joomla 4/5

[🇷🇺 Русский](#ру-русский) | [🇬🇧 English](#en-english)

---

<a name="ру-русский"></a>

## 🇷🇺 Русский

Универсальный модуль модального окна с динамическим конструктором полей. Предназначен для быстрой интеграции форм обратной связи на сайты под управлением CMS Joomla.

### 🚀 Основные возможности

- **Множественные формы:** Возможность размещать несколько независимых форм на одной странице без конфликтов JS.
- **Конструктор полей:** Добавление текстовых полей, телефонов, email, дат, текстовых областей и **файлов** через админку.
- **Умная маска телефона:** Встроенная поддержка библиотеки IMask.js (загружается только при необходимости). Позволяет задать строгий формат номера (например, для РФ `+7 (000) 000-00-00` или международный) и блокирует ввод лишних символов.
- **Прикрепление файлов:** Поддержка загрузки документов, изображений и архивов. Свой текст кнопки загрузки легко настраивается через поле _Placeholder_.
- **Динамический заголовок:** Автоматическая подстановка текста из нажатой кнопки в заголовок формы и тему письма.
- **Гибкий дизайн:** Настройка цветов кнопок, фокуса полей и CSS-классов напрямую из настроек модуля. Изолированные CSS/JS файлы не ломают стили вашего шаблона.
- **Маркетинг:**
  - Поддержка целей **Яндекс.Метрики** (JS-событие).
  - Настраиваемый **редирект** на страницу "Спасибо" после успешной отправки.
- **Согласие с обработкой данных:** Встроенный чекбокс с редактируемым текстом (соответствие ФЗ-152).
- **Автоматические обновления (Update Server):** Модуль интегрирован в штатную систему обновлений Joomla. Уведомления о новых версиях и их установка происходят прямо из админ-панели в один клик.
- **Мультиязычность:** Полная поддержка языковых файлов Joomla (ru-RU, en-GB).

### 🛠 Зависимости

Модуль работает в строгой связке с плагином [RadicalForm](https://radicalmart.ru/all/radicalform). Убедитесь, что плагин установлен, опубликован, а в его настройках **разрешена загрузка файлов**.

### 📦 Установка

1. Скачайте последний релиз (ZIP-архив) со страницы модуля.
2. В админке Joomla перейдите в **Система -> Установка -> Расширения** (System -> Install -> Extensions).
3. Загрузите архив.
   _(В дальнейшем обновления будут приходить автоматически)._

### 💡 Использование

**Как открыть форму**
Для вызова окна используйте CSS-классы на кнопках или ссылках:

1. **Общий вызов:** класс `bsr-open-modal` (откроет первую найденную форму на странице).
2. **Точечный вызов:**
   - Задайте в настройках модуля **ID формы** (например, `feedback`).
   - Используйте класс кнопки `bsr-open-feedback`.

**Пример HTML:**
<button class="bsr-open-feedback sppb-btn">Сделать заказ</button>

---

<a name="en-english"></a>

## 🇬🇧 English

Universal modal window module with a dynamic field builder. Designed for quick integration of feedback forms into websites running on Joomla CMS.

### 🚀 Key Features

- **Multiple Forms:** Ability to place several independent forms on one page without JS conflicts.
- **Field Builder:** Add text fields, phones, emails, dates, textareas, and **files** directly via the admin panel.
- **Smart Phone Mask:** Built-in IMask.js support (loads conditionally). Allows setting strict phone formats (e.g., `+{7} (000) 000-00-00` or international) and blocks invalid characters.
- **File Attachments:** Support for uploading documents, images, and archives. Custom upload button text is easily configured via the _Placeholder_ field.
- **Dynamic Title:** Automatic substitution of text from the clicked button into the form title and email subject.
- **Flexible Design:** Customize button colors, field focus, and CSS classes directly from the module settings. Isolated CSS/JS assets prevent template conflicts.
- **Marketing Tools:**
  - Support for **Yandex.Metrica** goals (JS event).
  - Configurable **redirect** to a "Thank You" page after successful submission.
- **Data Processing Consent:** Built-in checkbox with editable text (GDPR compliant).
- **Automatic Updates:** Integrated with Joomla's native update system. Get notified about new versions and install them with one click directly from the admin panel.
- **Multilingual:** Full support for Joomla language files (ru-RU, en-GB).

### 🛠 Dependencies

The module works in conjunction with the [RadicalForm](https://radicalmart.ru/all/radicalform) plugin. Make sure the plugin is installed, enabled, and **file uploads are allowed** in its settings.

### 📦 Installation

1. Download the latest release (ZIP archive) from the repository page.
2. In the Joomla admin panel, go to **System -> Install -> Extensions**.
3. Upload the archive.
   _(Future updates will be delivered automatically)._

### 💡 Usage

**How to open the form**
To call the window, use CSS classes on buttons or links:

1. **General call:** class `bsr-open-modal` (opens the first found form on the page).
2. **Specific call:**
   - Set the **Form ID** in the module settings (for example, `feedback`).
   - Use the button class `bsr-open-feedback`.

**HTML Example:**
<button class="bsr-open-feedback sppb-btn">Make an order</button>

---

## 👤 Автор / Author

**Увиков Андрей (Andrey Uvikov)**

- Email: order@bestsite-studio.ru
- Сайт / Website: https://bestsite-tver.ru
