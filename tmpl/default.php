<?php
defined('_JEXEC') or die;
use Joomla\CMS\Language\Text;

// Генерируем CSS-переменные для кастомных цветов из админки
$inlineStyles = [];
if ($colorFocus) {
    $inlineStyles[] = "--bsr-color-focus: " . htmlspecialchars((string) $colorFocus, ENT_QUOTES, 'UTF-8') . ";";
    $inlineStyles[] = "--bsr-color-focus-shadow: " . htmlspecialchars((string) $colorFocus, ENT_QUOTES, 'UTF-8') . "33;";
}
if ($colorBtn) {
    $inlineStyles[] = "--bsr-color-btn: " . htmlspecialchars((string) $colorBtn, ENT_QUOTES, 'UTF-8') . ";";
}
if ($colorBtnHover) {
    $inlineStyles[] = "--bsr-color-btn-hover: " . htmlspecialchars((string) $colorBtnHover, ENT_QUOTES, 'UTF-8') . ";";
}
$styleAttr = !empty($inlineStyles) ? 'style="' . implode(' ', $inlineStyles) . '"' : '';


$uploadBtnMod = empty($uploadBtnClass) ? 'bsr-form__submit--default' : $uploadBtnClass;
$mainBtnMod = empty($btnClass) ? 'bsr-form__submit--default' : $btnClass;
?>

<div id="<?php echo htmlspecialchars((string) $uniqueModalId, ENT_QUOTES, 'UTF-8'); ?>"
    class="bsr-modal bsr-modal--hidden" <?php echo $styleAttr; ?>>
    <div class="bsr-modal__content">
        <a class="bsr-modal__close"
            title="<?php echo htmlspecialchars((string) Text::_('MOD_BSR_FORM_TXT_CLOSE'), ENT_QUOTES, 'UTF-8'); ?>">&times;</a>

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
                    if (!$name) continue;

                    $placeholderSafe = !empty($item['f_placeholder']) ? htmlspecialchars((string) $item['f_placeholder'], ENT_QUOTES, 'UTF-8') : '';
                    $required = !empty($item['f_required']) ? 'required' : '';
                    $errorTextSafe = !empty($item['f_error']) ? htmlspecialchars((string) $item['f_error'], ENT_QUOTES, 'UTF-8') : htmlspecialchars((string) Text::_('MOD_BSR_FORM_DEFAULT_F_ERROR'), ENT_QUOTES, 'UTF-8');
                    ?>
                    <div class="bsr-form__group">

                        <?php if ($type === 'textarea'): ?>
                            <textarea class="bsr-form__input bsr-form__input--textarea"
                                name="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>"
                                placeholder="<?php echo $placeholderSafe; ?>" <?php echo $required; ?>></textarea>

                        <?php elseif ($type === 'file'): ?>
                            <?php if ($placeholderSafe): ?>
                                <div class="uk-form-custom bsr-form__upload-wrapper" uk-form-custom>
                                    <button type="button"
                                        class="bsr-form__submit bsr-form__upload-btn rf-upload-button-text <?php echo htmlspecialchars((string) $uploadBtnMod, ENT_QUOTES, 'UTF-8'); ?>"
                                        tabindex="-1"><?php echo $placeholderSafe; ?></button>
                                    <input class="rf-upload-button"
                                        name="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>" type="file"
                                        accept=".zip,.tar,.rar,.jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx" <?php echo $required; ?>>
                                </div>
                            <?php else: ?>
                                <input class="rf-upload-button bsr-form__input--file <?php echo htmlspecialchars((string) $uploadBtnMod, ENT_QUOTES, 'UTF-8'); ?>"
                                    name="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>" type="file"
                                    accept=".zip,.tar,.rar,.jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx" <?php echo $required; ?>>
                            <?php endif; ?>

                        <?php elseif ($type === 'tel'): ?>
                            <!-- НОВЫЙ БЛОК ДЛЯ ТЕЛЕФОНА С ПОДДЕРЖКОЙ МАСКИ -->
                            <input class="bsr-form__input bsr-form__input--tel <?php echo ($enablePhoneMask ? 'js-bsr-phone-mask' : ''); ?>"
                                type="tel" name="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>"
                                placeholder="<?php echo $placeholderSafe; ?>" <?php echo $required; ?>
                                <?php echo ($enablePhoneMask ? 'data-mask="' . htmlspecialchars((string)$phoneMaskFormat, ENT_QUOTES, 'UTF-8') . '"' : ''); ?>>

                        <?php else: ?>
                            <input class="bsr-form__input bsr-form__input--<?php echo htmlspecialchars($type, ENT_QUOTES, 'UTF-8'); ?>"
                                type="<?php echo ($type === 'date' ? 'text' : htmlspecialchars($type, ENT_QUOTES, 'UTF-8')); ?>"
                                name="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>"
                                placeholder="<?php echo $placeholderSafe; ?>" <?php echo $required; ?> 
                                <?php if ($type === 'date') echo 'onfocus="(this.type=\'date\')" onblur="if(!this.value)this.type=\'text\'"'; ?>>
                        <?php endif; ?>

                        <?php if ($required): ?>
                            <div class="bsr-form__error"><?php echo $errorTextSafe; ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="rf-filenames-list"></div>

            <div class="bsr-form__group">
                <button type="submit"
                    class="bsr-form__submit rf-button-send <?php echo htmlspecialchars((string) $mainBtnMod, ENT_QUOTES, 'UTF-8'); ?>"
                    data-rf-call="<?php echo (int) $rfCallId; ?>"><?php echo htmlspecialchars((string) $btnText, ENT_QUOTES, 'UTF-8'); ?></button>
            </div>

            <div class="bsr-form__group bsr-form__group--checkbox">
                <div class="bsr-form__checkbox-wrapper">
                    <?php $chkId = 'rf_chk_' . htmlspecialchars($uniqueModalId, ENT_QUOTES, 'UTF-8'); ?>
                    <input class="bsr-form__checkbox" type="checkbox" name="acception" value="agree" required checked
                        id="<?php echo $chkId; ?>">
                    <label class="bsr-form__label" for="<?php echo $chkId; ?>"><?php echo $agreementText; ?></label>
                </div>
                <div class="bsr-form__error bsr-form__error--checkbox">
                    <?php echo htmlspecialchars((string) Text::_('MOD_BSR_FORM_ERROR_CHECKBOX'), ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>
        </form>

        <div class="bsr-success">
            <div class="bsr-success__title">
                <?php echo htmlspecialchars((string) Text::_('MOD_BSR_FORM_TXT_SUCCESS_TITLE'), ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <div class="bsr-success__text">
                <?php echo nl2br(htmlspecialchars((string) $successMsg, ENT_QUOTES, 'UTF-8')); ?></div>
        </div>
    </div>
</div>