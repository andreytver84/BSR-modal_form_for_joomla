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

// Аналитика и редирект
$redirectUrl = $params->get('redirect_url', '');
$ymGoal = $params->get('ym_goal', '');

// Настройки дизайна
$formIdRaw = $params->get('form_id', '');
$formClass = $params->get('form_class', '');
$btnClass = $params->get('btn_class', '');
$colorBtn = $params->get('color_btn', '');
$colorBtnHover = $params->get('color_btn_hover', '');
$colorFocus = $params->get('color_focus', '');

$uniqueModalId = !empty($formIdRaw) ? $formIdRaw : 'bsr-modal-' . rand(10000, 99999);

$layoutPath = ModuleHelper::getLayoutPath('mod_bsr_form', $params->get('layout', 'default'));

if ($layoutPath) {
    require $layoutPath;
} else {
    echo '<div style="color:red; padding:10px;">Ошибка: Шаблон не найден.</div>';
}