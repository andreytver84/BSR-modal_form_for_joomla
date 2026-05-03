<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_bsr_form
 * @author      Andrey Uvikov (order@bestsite-studio.ru)
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

// 1. Подключаем статические стили и скрипты
$doc = Joomla\CMS\Factory::getDocument();
$doc->addStyleSheet(Uri::root(true) . '/modules/mod_bsr_form/assets/css/style.css', ['version' => '2.5.0']);
$doc->addScript(Uri::root(true) . '/modules/mod_bsr_form/assets/js/script.js', ['version' => '2.5.0']);

// 2. Базовые настройки / Basic settings
$rfCallId = $params->get('rf_call_id', '');
$formTitle = $params->get('form_title', Text::_('MOD_BSR_FORM_DEFAULT_FORM_TITLE'));
$btnText = $params->get('btn_text', Text::_('MOD_BSR_FORM_DEFAULT_BTN_TEXT'));
$successMsg = $params->get('success_msg', Text::_('MOD_BSR_FORM_DEFAULT_SUCCESS_MSG'));
$formFields = $params->get('form_fields', []);
$autofillTitle = $params->get('autofill_title', 1);
$agreementText = $params->get('agreement_text', Text::_('MOD_BSR_FORM_DEFAULT_AGREEMENT_TEXT'));

// 3. Аналитика и редирект / Analytics and redirect
$redirectUrl = $params->get('redirect_url', '');
$ymGoal = $params->get('ym_goal', '');

// 4. Настройки дизайна / Design settings
$formIdRaw = $params->get('form_id', '');
$formClass = $params->get('form_class', '');
$btnClass = $params->get('btn_class', '');
$colorBtn = $params->get('color_btn', '');
$colorBtnHover = $params->get('color_btn_hover', '');
$colorFocus = $params->get('color_focus', '');

// 5. Генерация уникального ID / Generate unique ID
$uniqueModalId = !empty($formIdRaw) ? $formIdRaw : 'bsr-modal-' . rand(10000, 99999);

// 6. Подключаем шаблон (ТОЛЬКО ПОСЛЕ ТОГО, КАК ВСЕ ПЕРЕМЕННЫЕ ГОТОВЫ)
$layoutPath = ModuleHelper::getLayoutPath('mod_bsr_form', $params->get('layout', 'default'));

if ($layoutPath) {
    require $layoutPath;
} else {
    echo '<div style="color:red; padding:10px;">' . Text::_('MOD_BSR_FORM_ERROR_LAYOUT_NOT_FOUND') . '</div>';
}