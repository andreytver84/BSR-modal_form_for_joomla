<?php
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

// Получаем настройки из админки модуля
$rfCallId = $params->get('rf_call_id', '123');
$formTitle = $params->get('form_title', 'Регистрация');
$successMsg = $params->get('success_msg', 'Спасибо! Заявка принята.');
$formFields = $params->get('form_fields', []);

// Подключаем шаблон отображения
require ModuleHelper::getLayoutPath('mod_bp_modal', $params->get('layout', 'default'));