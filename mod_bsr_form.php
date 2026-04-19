<?php
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

// Базовые настройки
$rfCallId = $params->get('rf_call_id', '123');
$formTitle = $params->get('form_title', 'Оставить заявку');
$btnText = $params->get('btn_text', 'Отправить');
$successMsg = $params->get('success_msg', 'Спасибо! Заявка принята.');
$formFields = $params->get('form_fields', []);
$autofillTitle = $params->get('autofill_title', 1);
$agreementText = $params->get('agreement_text', 'Нажимая кнопку, я даю согласие на обработку данных.');

// Настройки дизайна и атрибутов
$formId = $params->get('form_id', '');
$formClass = $params->get('form_class', '');
$btnClass = $params->get('btn_class', '');
$colorBtn = $params->get('color_btn', '');
$colorBtnHover = $params->get('color_btn_hover', '');
$colorFocus = $params->get('color_focus', '');

// Безопасное подключение шаблона
$layoutPath = ModuleHelper::getLayoutPath('mod_bsr_form', $params->get('layout', 'default'));

if ($layoutPath) {
    require $layoutPath;
} else {
    echo '<div style="color:red; padding:10px; border:1px solid red;">Ошибка BSR Form: Файл шаблона tmpl/default.php не найден. Убедитесь, что папка модуля называется строго <b>mod_bsr_form</b>.</div>';
}