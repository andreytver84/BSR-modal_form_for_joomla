<?php
defined('_JEXEC') or die;
?>

<div class="bsr-modal bsr-modal--hidden">
    <div class="bsr-modal__content">
        <a class="bsr-modal__close" title="Закрыть">&times;</a>

        <form class="bsr-form <?php echo htmlspecialchars((string) $formClass, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $formId ? 'id="' . htmlspecialchars((string) $formId, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>
            <div class="bsr-form__header">
                <h3 class="bsr-form__title"><?php echo htmlspecialchars((string) $formTitle, ENT_QUOTES, 'UTF-8'); ?>
                </h3>
                <input name="rfSubject" value="<?php echo htmlspecialchars((string) $formTitle, ENT_QUOTES, 'UTF-8'); ?>"
                    type="hidden">
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
                    $errorText = !empty($item['f_error']) ? (string) $item['f_error'] : 'Обязательное поле';
                    ?>

                    <div class="bsr-form__group">
                        <?php if ($type === 'textarea'): ?>
                            <textarea class="bsr-form__input bsr-form__input--textarea" name="<?php echo $name; ?>"
                                placeholder="<?php echo $placeholder; ?>" <?php echo $required; ?>></textarea>
                        <?php elseif ($type === 'date'): ?>
                            <input class="bsr-form__input bsr-form__input--date" type="text" name="<?php echo $name; ?>"
                                placeholder="<?php echo $placeholder; ?>" onfocus="this.type='date'"
                                onblur="if(!this.value)this.type='text'" <?php echo $required; ?>>
                        <?php else: ?>
                            <input class="bsr-form__input bsr-form__input--<?php echo $type; ?>" type="<?php echo $type; ?>"
                                name="<?php echo $name; ?>" placeholder="<?php echo $placeholder; ?>" <?php echo $required; ?>
                                value="">
                        <?php endif; ?>

                        <?php if ($required): ?>
                            <div class="bsr-form__error"><?php echo $errorText; ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="bsr-form__group">
                <button type="submit"
                    class="bsr-form__submit rf-button-send <?php echo htmlspecialchars((string) $btnClass, ENT_QUOTES, 'UTF-8'); ?>"
                    data-rf-call="<?php echo (int) $rfCallId; ?>"><?php echo htmlspecialchars((string) $btnText, ENT_QUOTES, 'UTF-8'); ?></button>
            </div>

            <div class="bsr-form__group bsr-form__group--checkbox">
                <div class="bsr-form__checkbox-wrapper">
                    <input class="bsr-form__checkbox" type="checkbox" name="acception" value="соглашаюсь" required
                        checked id="rf_acception_<?php echo (int) $rfCallId; ?>">
                    <label class="bsr-form__label"
                        for="rf_acception_<?php echo (int) $rfCallId; ?>"><?php echo $agreementText; ?></label>
                </div>
                <div class="bsr-form__error bsr-form__error--checkbox">Необходимо подтвердить согласие</div>
            </div>
        </form>

        <div class="bsr-success">
            <div class="bsr-success__title">Отлично!</div>
            <div class="bsr-success__text">
                <?php echo nl2br(htmlspecialchars((string) $successMsg, ENT_QUOTES, 'UTF-8')); ?></div>
        </div>
    </div>
</div>

<style>
    .bsr-modal {
        position: fixed !important;
        z-index: 10000 !important;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
    }

    .bsr-modal--hidden {
        display: none !important;
    }

    .bsr-modal__content {
        position: relative;
        background: #ffffff;
        width: 100%;
        max-width: 450px;
        border-radius: 8px;
        padding: 25px 35px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        box-sizing: border-box;
        font-family: 'Open Sans', sans-serif;
        max-height: 95vh;
        overflow-y: auto;
    }

    .bsr-modal__close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 28px;
        line-height: 1;
        color: #999999;
        cursor: pointer;
        transition: color 0.3s ease, transform 0.3s ease;
        text-decoration: none;
    }

    .bsr-modal__close:hover {
        color: #000000;
        transform: rotate(90deg);
    }

    .bsr-form__header {
        margin-bottom: 15px;
    }

    .bsr-form__title {
        margin: 0;
        text-align: center;
        font-size: 20px;
        color: #333333;
        text-transform: uppercase;
        font-weight: 600;
    }

    .bsr-form__group {
        margin-bottom: 12px;
        position: relative;
    }

    .bsr-form__group--checkbox {
        margin-bottom: 0;
    }

    .bsr-form__input {
        width: 100%;
        padding: 10px 15px;
        font-size: 15px;
        color: #333;
        border: 1px solid #cccccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-family: inherit;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .bsr-form__input--textarea {
        min-height: 65px;
        resize: vertical;
    }

    <?php if ($colorFocus): ?>
        .bsr-form__input:focus {
            border-color:
                <?php echo htmlspecialchars((string) $colorFocus, ENT_QUOTES, 'UTF-8'); ?>
            ;
            outline: none;
            box-shadow: 0 0 0 3px
                <?php echo htmlspecialchars((string) $colorFocus, ENT_QUOTES, 'UTF-8'); ?>
                33;
        }

        .bsr-form__label a {
            color:
                <?php echo htmlspecialchars((string) $colorFocus, ENT_QUOTES, 'UTF-8'); ?>
            ;
            text-decoration: underline;
        }

    <?php else: ?>
        .bsr-form__input:focus {
            border-color: #336884;
            outline: none;
        }

    <?php endif; ?>

    .bsr-form__submit {
        width: 100%;
        border: none;
        padding: 12px;
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 5px;
        transition: all 0.3s ease;
        <?php if ($colorBtn): ?>
            background-color:
                <?php echo htmlspecialchars((string) $colorBtn, ENT_QUOTES, 'UTF-8'); ?>
            ;
            color: #ffffff;
        <?php endif; ?>
    }

    <?php if ($colorBtnHover): ?>
        .bsr-form__submit:hover {
            background-color:
                <?php echo htmlspecialchars((string) $colorBtnHover, ENT_QUOTES, 'UTF-8'); ?>
            ;
        }

    <?php endif; ?>

    .bsr-form__checkbox-wrapper {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .bsr-form__checkbox {
        margin: 3px 0 0 0;
        width: 16px;
        height: 16px;
        cursor: pointer;
        flex-shrink: 0;
    }

    .bsr-form__label {
        font-size: 12px;
        line-height: 1.4;
        color: #666666;
        cursor: pointer;
        flex: 1;
        margin: 0;
    }

    .bsr-form__error {
        font-size: 11px;
        color: #d9534f;
        margin-top: 4px;
        display: none;
    }

    .bsr-form__error--checkbox {
        padding-left: 26px;
    }

    .uk-form-danger+.bsr-form__error {
        display: block;
    }

    input[type="checkbox"].uk-form-danger~.bsr-form__label {
        color: #d9534f;
    }

    .bsr-form__checkbox-wrapper:has(.uk-form-danger)+.bsr-form__error--checkbox {
        display: block;
    }

    .bsr-success {
        display: none;
        text-align: center;
        font-size: 15px;
        line-height: 1.5;
        color: #155724;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        padding: 25px 20px;
        border-radius: 8px;
    }

    .bsr-success__title {
        font-weight: bold;
        font-size: 20px;
        margin-bottom: 10px;
    }
</style>

<script>
    window.rfCall_1 = function () {
        const form = document.querySelector('.bsr-modal .bsr-form');
        if (form) form.style.opacity = "0.5";
    };

    window.rfCall_2 = function () {
        const msg = document.querySelector('.bsr-modal .bsr-success');
        const form = document.querySelector('.bsr-modal .bsr-form');
        if (msg) msg.style.display = "block";
        if (form) {
            form.style.display = "none";
            form.style.opacity = "1";
        }
    };

    window.rfCall_3 = function () {
        setTimeout(() => {
            const modal = document.querySelector('.bsr-modal');
            const msg = document.querySelector('.bsr-modal .bsr-success');
            if (msg) msg.style.display = "none";
            if (modal) modal.classList.add('bsr-modal--hidden');
        }, 3000);
    };

    function initBsrModal() {
        const formModal = document.querySelector('.bsr-modal');
        if (!formModal) return;

        const titleElem = formModal.querySelector('.bsr-form__title');
        const subjectInput = formModal.querySelector('input[name="rfSubject"]');
        const modalForm = formModal.querySelector('.bsr-form');
        const successMess = formModal.querySelector('.bsr-success');

        const enableAutofill = <?php echo $autofillTitle ? 'true' : 'false'; ?>;
        const defaultTitle = "<?php echo addslashes((string) $formTitle); ?>";

        const closeModal = () => formModal.classList.add('bsr-modal--hidden');

        const openModal = (btnText) => {
            const cleanText = btnText ? btnText.trim() : '';
            let currentTitle = defaultTitle;

            if (enableAutofill && cleanText) {
                const lowerText = cleanText.toLowerCase();
                if (!lowerText.includes('зарегистрир') && !lowerText.includes('отправить')) {
                    currentTitle = cleanText;
                }
            }

            if (titleElem) titleElem.textContent = currentTitle;
            if (subjectInput) subjectInput.value = currentTitle;

            modalForm.style.display = "block";
            modalForm.style.opacity = "1";
            successMess.style.display = "none";

            formModal.classList.remove('bsr-modal--hidden');
        };

        document.addEventListener('click', (event) => {
            const openBtn = event.target.closest('.bsr-open-modal');
            if (openBtn && !openBtn.classList.contains('rf-button-send')) {
                event.preventDefault();
                openModal(openBtn.textContent);
            }

            if (event.target.closest('.bsr-modal__close') || event.target === formModal) {
                closeModal();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBsrModal);
    } else {
        initBsrModal();
    }
</script>