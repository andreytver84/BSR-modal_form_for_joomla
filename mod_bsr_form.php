<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_bsr_form
 * @author      Andrey Uvikov (order@bestsite-studio.ru)
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;

// Базовые настройки / Basic settings
$rfCallId = $params->get('rf_call_id', '');
$formTitle = $params->get('form_title', Text::_('MOD_BSR_FORM_DEFAULT_FORM_TITLE'));
$btnText = $params->get('btn_text', Text::_('MOD_BSR_FORM_DEFAULT_BTN_TEXT'));
$successMsg = $params->get('success_msg', Text::_('MOD_BSR_FORM_DEFAULT_SUCCESS_MSG'));
$formFields = $params->get('form_fields', []);
$autofillTitle = $params->get('autofill_title', 1);
$agreementText = $params->get('agreement_text', Text::_('MOD_BSR_FORM_DEFAULT_AGREEMENT_TEXT'));

// Аналитика и редирект / Analytics and redirect
$redirectUrl = $params->get('redirect_url', '');
$ymGoal = $params->get('ym_goal', '');

// Настройки дизайна / Design settings
$formIdRaw = $params->get('form_id', '');
$formClass = $params->get('form_class', '');
$btnClass = $params->get('btn_class', '');
$colorBtn = $params->get('color_btn', '');
$colorBtnHover = $params->get('color_btn_hover', '');
$colorFocus = $params->get('color_focus', '');

// Генерация уникального ID / Generate unique ID
$uniqueModalId = !empty($formIdRaw) ? $formIdRaw : 'bsr-modal-' . rand(10000, 99999);

$layoutPath = ModuleHelper::getLayoutPath('mod_bsr_form', $params->get('layout', 'default'));

if ($layoutPath) {
    require $layoutPath;
} else {
    echo '<div style="color:red; padding:10px;">' . Text::_('MOD_BSR_FORM_ERROR_LAYOUT_NOT_FOUND') . '</div>';
}