<?php
defined('_JEXEC') or die;
use Joomla\CMS\Language\Text;
?>

<div id="<?php echo htmlspecialchars((string) $uniqueModalId, ENT_QUOTES, 'UTF-8'); ?>"
    class="bsr-modal bsr-modal--hidden">
    <div class="bsr-modal__content">
        <a class="bsr-modal__close" title="<?php echo Text::_('MOD_BSR_FORM_TXT_CLOSE'); ?>">&times;</a>

        <form class="bsr-form <?php echo htmlspecialchars((string) $formClass, ENT_QUOTES, 'UTF-8'); ?>"
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
                    <?php echo Text::_('MOD_BSR_FORM_ERROR_CHECKBOX'); ?></div>
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

<style>
    /* Основные стили / Main styles */
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
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .bsr-modal__close:hover {
        color: #000;
        transform: rotate(90deg);
    }

    .bsr-form__title {
        margin: 0 0 15px;
        text-align: center;
        font-size: 20px;
        text-transform: uppercase;
        font-weight: 600;
    }

    .bsr-form__group {
        margin-bottom: 12px;
        position: relative;
    }

    .bsr-form__input {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-family: inherit;
    }

    .bsr-form__input--textarea {
        min-height: 65px;
        resize: vertical;
    }

    /* Динамические цвета / Dynamic colors */
    <?php if ($colorFocus): ?>
        .bsr-form__input:focus {
            border-color:
                <?php echo $colorFocus; ?>
            ;
            outline: none;
            box-shadow: 0 0 0 3px
                <?php echo $colorFocus; ?>
                33;
        }

        .bsr-form__label a {
            color:
                <?php echo $colorFocus; ?>
            ;
        }

    <?php endif; ?>

    .bsr-form__submit {
        width: 100%;
        border: none;
        padding: 12px;
        font-weight: 600;
        text-transform: uppercase;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
        <?php if ($colorBtn): ?>
            background-color:
                <?php echo $colorBtn; ?>
            ;
            color: #fff;
        <?php endif; ?>
    }

    <?php if ($colorBtnHover): ?>
        .bsr-form__submit:hover {
            background-color:
                <?php echo $colorBtnHover; ?>
            ;
        }

    <?php endif; ?> .bsr-form__checkbox-wrapper {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .bsr-form__label {
        font-size: 12px;
        line-height: 1.4;
        color: #666;
        cursor: pointer;
    }

    .bsr-form__error {
        font-size: 11px;
        color: #d9534f;
        margin-top: 4px;
        display: none;
    }

    .uk-form-danger+.bsr-form__error,
    .bsr-form__checkbox-wrapper:has(.uk-form-danger)+.bsr-form__error--checkbox {
        display: block;
    }

    .bsr-success {
        display: none;
        text-align: center;
        background: #d4edda;
        border: 1px solid #c3e6cb;
        padding: 25px 20px;
        border-radius: 8px;
        color: #155724;
    }

    .bsr-success__title {
        font-weight: bold;
        font-size: 20px;
        margin-bottom: 10px;
    }
</style>

<script>
    (function () {
        // 1. УНИВЕРСАЛЬНЫЙ ПЕРЕХВАТЧИК УСПЕХА / UNIVERSAL SUCCESS INTERCEPTOR
        const bsrHandleSuccess = () => {
            const activeModal = document.querySelector('.bsr-modal:not(.bsr-modal--hidden)');
            if (!activeModal) return;

            const form = activeModal.querySelector('.bsr-form');
            const successBox = activeModal.querySelector('.bsr-success');

            // Читаем настройки из data-атрибутов / Read settings from data attributes
            const redirectUrl = form.getAttribute('data-redirect');
            const goalId = form.getAttribute('data-goal');

            // А) Яндекс Метрика (событие reachGoal) / Yandex Metrica (reachGoal event)
            if (goalId && typeof ym !== 'undefined') {
                try {
                    ym.apply(null, [null, 'reachGoal', goalId]);
                    console.log('BSR Form: YM Goal sent - ' + goalId);
                } catch (e) { console.warn('BSR Form: Metrica error', e); }
            }

            // Б) Логика завершения (Редирект или Сообщение) / Completion logic (Redirect or Message)
            if (redirectUrl) {
                window.location.href = redirectUrl;
            } else {
                if (successBox) successBox.style.display = "block";
                if (form) form.style.display = "none";

                setTimeout(() => {
                    activeModal.classList.add('bsr-modal--hidden');
                    setTimeout(() => {
                        if (successBox) successBox.style.display = "none";
                        if (form) { form.style.display = "block"; form.style.opacity = "1"; }
                    }, 500);
                }, 3000);
            }
        };

        // Слушаем завершение сетевых запросов (AJAX) / Listen for network requests completion (AJAX)
        const oldOpen = XMLHttpRequest.prototype.open;
        XMLHttpRequest.prototype.open = function () {
            this.addEventListener('load', () => {
                if (this.responseURL.includes('radicalform') && this.status === 200) {
                    setTimeout(bsrHandleSuccess, 100);
                }
            });
            oldOpen.apply(this, arguments);
        };

        // 2. ИНИЦИАЛИЗАЦИЯ ОТКРЫТИЯ / OPEN INITIALIZATION
        const setup = () => {
            const modalId = "<?php echo $uniqueModalId; ?>";
            const formModal = document.getElementById(modalId);
            if (!formModal) return;

            document.addEventListener('click', (e) => {
                const openBtn = e.target.closest('.bsr-open-' + modalId + ', .bsr-open-modal');
                if (openBtn && !e.target.classList.contains('rf-button-send')) {
                    // Игнорируем если клик по общей кнопке, а форма не первая / Ignore if common button clicked and form is not first
                    if (openBtn.classList.contains('bsr-open-modal') && !openBtn.classList.contains('bsr-open-' + modalId)) {
                        if (document.querySelector('.bsr-modal') !== formModal) return;
                    }

                    e.preventDefault();
                    const btnText = openBtn.textContent.trim();
                    const title = formModal.querySelector('.bsr-form__title');
                    const subject = formModal.querySelector('input[name="rfSubject"]');

                    // Автозаполнение заголовка / Autofill title
                    if (<?php echo $autofillTitle ? 'true' : 'false'; ?> && btnText && !btnText.toLowerCase().includes('отправить')) {
                        if (title) title.textContent = btnText;
                        if (subject) subject.value = btnText;
                    }

                    formModal.classList.remove('bsr-modal--hidden');
                }

                // Закрытие модального окна / Close modal
                if (e.target.closest('.bsr-modal__close') || e.target === formModal) {
                    formModal.classList.add('bsr-modal--hidden');
                }
            });

            // Прозрачность при отправке / Opacity on submit
            formModal.querySelector('.bsr-form').addEventListener('submit', function () {
                this.style.opacity = "0.5";
            });
        };

        if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', setup); } else { setup(); }
    })();
</script>