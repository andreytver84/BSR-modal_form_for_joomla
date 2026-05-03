<?php
defined('_JEXEC') or die;
use Joomla\CMS\Language\Text;

// Генерируем CSS-переменные ТОЛЬКО если цвета выбраны в админке
$inlineStyles = [];
if ($colorFocus) {
    $inlineStyles[] = "--bsr-color-focus: {$colorFocus};";
    $inlineStyles[] = "--bsr-color-focus-shadow: {$colorFocus}33;";
}
if ($colorBtn) {
    $inlineStyles[] = "--bsr-color-btn: {$colorBtn};";
    $inlineStyles[] = "--bsr-color-btn-text: #fff;";
}
if ($colorBtnHover) {
    $inlineStyles[] = "--bsr-color-btn-hover: {$colorBtnHover};";
}

$styleAttr = !empty($inlineStyles) ? 'style="' . implode(' ', $inlineStyles) . '"' : '';
?>

<div id="<?php echo htmlspecialchars((string) $uniqueModalId, ENT_QUOTES, 'UTF-8'); ?>"
    class="bsr-modal bsr-modal--hidden" <?php echo $styleAttr; ?>>
    <div class="bsr-modal__content">
        <a class="bsr-modal__close" title="<?php echo Text::_('MOD_BSR_FORM_TXT_CLOSE'); ?>">&times;</a>

        <form class="bsr-form <?php echo htmlspecialchars((string) $formClass, ENT_QUOTES, 'UTF-8'); ?>"
            enctype="multipart/form-data" data-autofill="<?php echo $autofillTitle ? '1' : '0'; ?>"
            data-redirect="<?php echo htmlspecialchars((string) $redirectUrl, ENT_QUOTES, 'UTF-8'); ?>"
            data-goal="<?php echo htmlspecialchars((string) $ymGoal, ENT_QUOTES, 'UTF-8'); ?>">

            <div class="bsr-form__header">
                <h3 class="bsr-form__title"><?php echo htmlspecialchars((string) $formTitle, ENT_QUOTES, 'UTF-8'); ?>
                </h3>
                <input name="rfSubject"
                    value="<?php echo htmlspecialchars((string) $formTitle, ENT_QUOTES, 'UTF-8'); ?>" type="hidden">
            </div>

            <?php if (!empty($formFields)): ?>
                <?php foreach ($formFields as $field): ?>
                    <?php
                    $item = (array) $field;
                    $type = !empty($item['f_type']) ? (string) $item['f_type'] : 'text';
                    $name = !empty($item['f_name']) ? (string) $item['f_name'] : '';
                    if (!$name)
                        continue;

                    $placeholder = !empty($item['f_placeholder']) ? (string) $item['f_placeholder'] : '';
                    $required = !empty($item['f_required']) ? 'required' : '';
                    $errorText = !empty($item['f_error']) ? (string) $item['f_error'] : Text::_('MOD_BSR_FORM_DEFAULT_F_ERROR');
                    ?>
                    <div class="bsr-form__group">

                        <?php if ($type === 'textarea'): ?>
                            <textarea class="bsr-form__input bsr-form__input--textarea" name="<?php echo $name; ?>"
                                placeholder="<?php echo $placeholder; ?>" <?php echo $required; ?>></textarea>

                        <?php elseif ($type === 'file'): ?>
                            <!-- Специфичная структура загрузки для RadicalForm -->
                            <?php if ($placeholder): ?>
                                <!-- Кастомная кнопка (если задан Placeholder) -->
                                <div class="uk-form-custom bsr-form__upload-wrapper" uk-form-custom>
                                    <button type="button" class="bsr-form__submit bsr-form__upload-btn rf-upload-button-text"
                                        tabindex="-1">
                                        <?php echo $placeholder; ?>
                                    </button>
                                    <input class="rf-upload-button" name="<?php echo $name; ?>" type="file"
                                        accept=".zip,.tar,.rar,.jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx" <?php echo $required; ?>>
                                </div>
                            <?php else: ?>
                                <!-- Стандартный инпут (если Placeholder пустой) -->
                                <input class="rf-upload-button bsr-form__input--file" name="<?php echo $name; ?>" type="file"
                                    accept=".zip,.tar,.rar,.jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx" <?php echo $required; ?>>
                            <?php endif; ?>

                        <?php else: ?>
                            <input class="bsr-form__input bsr-form__input--<?php echo $type; ?>"
                                type="<?php echo ($type === 'date' ? 'text' : $type); ?>" name="<?php echo $name; ?>"
                                placeholder="<?php echo $placeholder; ?>" <?php echo $required; ?>             <?php if ($type === 'date')
                                                       echo 'onfocus="(this.type=\'date\')" onblur="if(!this.value)this.type=\'text\'"'; ?>>
                        <?php endif; ?>

                        <?php if ($required): ?>
                            <div class="bsr-form__error"><?php echo $errorText; ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Обязательный контейнер для списка загруженных файлов -->
            <div class="rf-filenames-list"></div>

            <div class="bsr-form__group">
                <button type="submit"
                    class="bsr-form__submit rf-button-send <?php echo htmlspecialchars((string) $btnClass, ENT_QUOTES, 'UTF-8'); ?>"
                    data-rf-call="<?php echo (int) $rfCallId; ?>"><?php echo htmlspecialchars((string) $btnText, ENT_QUOTES, 'UTF-8'); ?></button>
            </div>

            <div class="bsr-form__group bsr-form__group--checkbox">
                <div class="bsr-form__checkbox-wrapper">
                    <?php $chkId = 'rf_chk_' . $uniqueModalId; ?>
                    <input class="bsr-form__checkbox" type="checkbox" name="acception" value="agree" required checked
                        id="<?php echo $chkId; ?>">
                    <label class="bsr-form__label" for="<?php echo $chkId; ?>"><?php echo $agreementText; ?></label>
                </div>
                <div class="bsr-form__error bsr-form__error--checkbox">

                    <?php echo Text::_('MOD_BSR_FORM_ERROR_CHECKBOX'); ?>
                </div>
            </div>
        </form>

        <div class="bsr-success">
            <div class="bsr-success__title"><?php echo Text::_('MOD_BSR_FORM_TXT_SUCCESS_TITLE'); ?></div>

            <div class="bsr-success__text">
                <?php echo nl2br(htmlspecialchars((string) $successMsg, ENT_QUOTES, 'UTF-8')); ?>
            </div>
        </div>
    </div>
</div>