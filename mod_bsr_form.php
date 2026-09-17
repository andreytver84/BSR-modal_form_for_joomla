<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_bsr_form
 * @author      Andrey Uvikov (order@bestsite-studio.ru)
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Filter\InputFilter;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

if (!function_exists('bsrSanitizeRedirectUrl')) {
    /**
     * Разрешает только относительный путь вида /thanks (без //, javascript:, data:).
     *
     * @param   string  $url
     *
     * @return  string
     */
    function bsrSanitizeRedirectUrl($url)
    {
        $url = trim((string) $url);

        if ($url === '' || $url[0] !== '/' || substr($url, 0, 2) === '//' || strpos($url, '\\') !== false) {
            return '';
        }

        if (preg_match('/^[a-z][a-z0-9+.-]*:/i', $url)) {
            return '';
        }

        $lower = strtolower($url);

        if (strpos($lower, 'javascript:') !== false || strpos($lower, 'data:') !== false || strpos($lower, 'vbscript:') !== false) {
            return '';
        }

        return $url;
    }
}

if (!function_exists('bsrSanitizeColor')) {
    /**
     * Оставляет только hex-цвет.
     *
     * @param   string  $color
     *
     * @return  string
     */
    function bsrSanitizeColor($color)
    {
        $color = trim((string) $color);

        if (preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6}|[0-9a-fA-F]{8})$/', $color)) {
            return $color;
        }

        return '';
    }
}

if (!function_exists('bsrSanitizeFormId')) {
    /**
     * ID формы: латиница, цифры, дефис и подчёркивание.
     *
     * @param   string  $id
     *
     * @return  string
     */
    function bsrSanitizeFormId($id)
    {
        return preg_replace('/[^A-Za-z0-9_-]/', '', (string) $id);
    }
}

if (!function_exists('bsrSanitizeCssClasses')) {
    /**
     * CSS-классы: буквы, цифры, дефис, подчёркивание и пробелы.
     *
     * @param   string  $classes
     *
     * @return  string
     */
    function bsrSanitizeCssClasses($classes)
    {
        $classes = preg_replace('/[^A-Za-z0-9 _-]/', '', (string) $classes);

        return trim(preg_replace('/\s+/', ' ', $classes));
    }
}

if (!function_exists('bsrSanitizeCssSelector')) {
    /**
     * Относительный CSS-селектор для поиска названия (h3 > span, .title).
     *
     * @param   string  $selector
     *
     * @return  string
     */
    function bsrSanitizeCssSelector($selector)
    {
        $selector = trim((string) $selector);

        if ($selector === '' || preg_match('/javascript:|expression\s*\(|url\s*\(/i', $selector)) {
            return '';
        }

        if (!preg_match('/^[A-Za-z0-9\s_\-.#>~+*=:\[\]()\'",]+$/', $selector)) {
            return '';
        }

        return $selector;
    }
}

$assetVersion = '2.7.0';
$app = Factory::getApplication();
$doc = $app->getDocument();
$base = Uri::root(true);

$rfCallId = $params->get('rf_call_id', '');
$formTitle = $params->get('form_title', Text::_('MOD_BSR_FORM_DEFAULT_FORM_TITLE'));
$btnText = $params->get('btn_text', Text::_('MOD_BSR_FORM_DEFAULT_BTN_TEXT'));
$successMsg = $params->get('success_msg', Text::_('MOD_BSR_FORM_DEFAULT_SUCCESS_MSG'));
$formFields = $params->get('form_fields', []);
$autofillTitle = $params->get('autofill_title', 1);
$quickOrder = (int) $params->get('quick_order', 0) === 1 ? 1 : 0;
$quickOrderType = $params->get('quick_order_type', 'consult') === 'order' ? 'order' : 'consult';
$quickOrderContainer = bsrSanitizeCssClasses($params->get('quick_order_container', ''));

if ($quickOrderContainer !== '' && strpos($quickOrderContainer, ' ') !== false) {
    $quickOrderContainer = explode(' ', $quickOrderContainer)[0];
}

$quickOrderSelector = bsrSanitizeCssSelector($params->get('quick_order_selector', ''));
$quickOrderTopic = Text::_('MOD_BSR_FORM_TXT_ON_TOPIC');
$agreementText = InputFilter::getInstance()->clean(
    (string) $params->get('agreement_text', Text::_('MOD_BSR_FORM_DEFAULT_AGREEMENT_TEXT')),
    'html'
);

$redirectUrl = bsrSanitizeRedirectUrl($params->get('redirect_url', ''));
$ymGoal = preg_replace('/[^A-Za-z0-9_-]/', '', (string) $params->get('ym_goal', ''));

$formIdRaw = bsrSanitizeFormId($params->get('form_id', ''));
$formClass = bsrSanitizeCssClasses($params->get('form_class', ''));
$btnClass = bsrSanitizeCssClasses($params->get('btn_class', ''));
$uploadBtnClass = bsrSanitizeCssClasses($params->get('upload_btn_class', ''));
$colorBtn = bsrSanitizeColor($params->get('color_btn', ''));
$colorBtnHover = bsrSanitizeColor($params->get('color_btn_hover', ''));
$colorFocus = bsrSanitizeColor($params->get('color_focus', ''));

$enablePhoneMask = $params->get('enable_phone_mask', 0);
$phoneMaskFormat = preg_replace('/[^0-9A-Za-z{}\[\]()+\-_*# .]/', '', (string) $params->get('phone_mask_format', '+{7} (000) 000-00-00'));
$phoneErrorText = Text::_('MOD_BSR_FORM_ERROR_PHONE_INCOMPLETE');

$hasPhoneField = false;

if (!empty($formFields)) {
    foreach ($formFields as $field) {
        $item = (array) $field;

        if (!empty($item['f_type']) && $item['f_type'] === 'tel') {
            $hasPhoneField = true;
            break;
        }
    }
}

$doc->addStyleSheet($base . '/modules/mod_bsr_form/assets/css/style.css', ['version' => $assetVersion]);

if ($enablePhoneMask && $hasPhoneField) {
    $doc->addScript($base . '/modules/mod_bsr_form/assets/js/imask.min.js', ['version' => '7.6.1']);
}

$doc->addScript($base . '/modules/mod_bsr_form/assets/js/script.js', ['version' => $assetVersion]);

$uniqueModalId = $formIdRaw !== '' ? $formIdRaw : 'bsr-modal-' . (int) $module->id;

$layoutPath = ModuleHelper::getLayoutPath('mod_bsr_form', $params->get('layout', 'default'));

if ($layoutPath) {
    require $layoutPath;
} else {
    echo '<div style="color:red; padding:10px;">' . Text::_('MOD_BSR_FORM_ERROR_LAYOUT_NOT_FOUND') . '</div>';
}
