<?php
defined('_JEXEC') or die;
?>

<div class="wrap__wrap">
    <div id="form__consult" class="wrap__modal hide-block">
        <div class="wrap__form">
            <a class="close__modal">&times;</a>

            <form class="modal__form">
                <div class="head__form">
                    <div class="wrap__input topic">
                        <h3>
                            <?php echo htmlspecialchars($formTitle, ENT_QUOTES, 'UTF-8'); ?>
                        </h3>
                        <input name="rfSubject" value="Заявка с сайта" type="hidden">
                    </div>
                </div>

                <?php if (!empty($formFields) && is_object($formFields)): ?>
                    <?php foreach ($formFields as $field): ?>

                        <?php
                        $type = $field->f_type;
                        $name = $field->f_name;
                        $placeholder = $field->f_placeholder;
                        $required = ($field->f_required == '1') ? 'required' : '';
                        $errorText = $field->f_error;
                        ?>

                        <div class="wrap__input <?php echo ($type == 'checkbox') ? 'accepted' : ''; ?>">

                            <?php if ($type == 'textarea'): ?>
                                <textarea class="message" name="<?php echo $name; ?>" placeholder="<?php echo $placeholder; ?>"
                                    <?php echo $required; ?>></textarea>

                            <?php elseif ($type == 'checkbox'): ?>
                                <input type="checkbox" name="<?php echo $name; ?>" value="Да" <?php echo $required; ?>>
                                <span>
                                    <?php echo $placeholder; ?>
                                </span>

                            <?php elseif ($type == 'date'): ?>
                                <input type="text" name="<?php echo $name; ?>" placeholder="<?php echo $placeholder; ?>"
                                    onfocus="this.type='date'" onblur="if(!this.value)this.type='text'" <?php echo $required; ?>>

                            <?php else: // text, tel, email ?>
                                <input type="<?php echo $type; ?>" name="<?php echo $name; ?>"
                                    placeholder="<?php echo $placeholder; ?>" <?php echo $required; ?> value="">
                            <?php endif; ?>

                            <?php if ($required): ?>
                                <div class="tm-error">
                                    <?php echo $errorText; ?>
                                </div>
                            <?php endif; ?>

                        </div>

                    <?php endforeach; ?>
                <?php endif; ?>

                <div class="wrap__input">
                    <button type="submit" class="rf-button-send sppb-btn sppb-btn-default sppb-btn-round"
                        data-rf-call="<?php echo $rfCallId; ?>">
                        Отправить
                    </button>
                </div>
            </form>

            <div class="sucsess_mess">
                <div style="font-weight: bold; font-size: 20px; margin-bottom: 10px;">Отлично!</div>
                <?php echo nl2br(htmlspecialchars($successMsg, ENT_QUOTES, 'UTF-8')); ?>
            </div>
        </div>
    </div>
</div>

<style>
    /* Сюда вставьте весь тот CSS-код из нашего предыдущего шага */
    .wrap__modal {
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

    .hide-block {
        display: none !important;
    }

    .wrap__form {
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

    .wrap__input.topic h3 {
        margin: 0 0 15px 0;
        text-align: center;
        font-size: 20px;
        color: #333333;
        text-transform: uppercase;
        font-weight: 600;
    }

    .wrap__input {
        margin-bottom: 12px;
        position: relative;
    }

    .wrap__form input[type="text"],
    .wrap__form input[type="tel"],
    .wrap__form input[type="email"],
    .wrap__form input[type="date"],
    .wrap__form textarea {
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

    .wrap__form textarea {
        min-height: 65px;
        resize: vertical;
    }

    .wrap__form input:focus,
    .wrap__form textarea:focus {
        border-color: #336884;
        outline: none;
        box-shadow: 0 0 0 3px rgba(51, 104, 132, 0.15);
    }

    .wrap__form input[required] {
        border-left: 3px solid #336884;
    }

    .wrap__form .rf-button-send {
        width: 100%;
        background: #336884;
        color: #ffffff;
        border: none;
        padding: 12px;
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 5px;
        transition: background-color 0.3s ease;
    }

    .wrap__form .rf-button-send:hover {
        background: #113a40;
    }

    .wrap__input.accepted {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 11px;
        line-height: 1.3;
        color: #666666;
        margin-bottom: 0;
    }

    .wrap__input.accepted input[type="checkbox"] {
        margin: 2px 0 0 0;
        width: 15px;
        height: 15px;
        cursor: pointer;
        flex-shrink: 0;
    }

    a.close__modal {
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

    a.close__modal:hover {
        color: #000000;
        transform: rotate(90deg);
    }

    .tm-error {
        font-size: 11px;
        color: #d9534f;
        margin-top: 4px;
        display: none;
    }

    .uk-form-danger+.tm-error {
        display: block;
    }
</style>

<script>
    function initModalLogic() {
        const formBlock = document.querySelector('.wrap__modal');
        if (!formBlock) return;

        const subjectInput = formBlock.querySelector('input[name="rfSubject"]');
        const modalForm = formBlock.querySelector('.modal__form');
        const successMess = formBlock.querySelector('.sucsess_mess');

        // Ищем поле, в которое будем подставлять название из кнопки
        // Допустим, мы считаем таким первое текстовое поле в форме
        const firstTextField = modalForm.querySelector('input[type="text"]');

        const closeModal = () => formBlock.classList.add('hide-block');

        const openModal = (btnText) => {
            const cleanText = (btnText.toLowerCase().includes('зарегистр')) ? '' : btnText;

            // Если есть текстовое поле, подставим туда текст кнопки (как вы просили для "названия семинара")
            if (firstTextField && cleanText) {
                firstTextField.value = cleanText;
            }

            if (subjectInput) {
                subjectInput.value = "Заявка: " + (cleanText || "Регистрация");
            }

            modalForm.style.display = "block";
            successMess.style.display = "none";
            formBlock.classList.remove('hide-block');
        };

        document.addEventListener('click', (event) => {
            const openBtn = event.target.closest('.open__modal');
            if (openBtn && !openBtn.classList.contains('rf-button-send')) {
                event.preventDefault();
                openModal(openBtn.textContent.trim());
            }
            if (event.target.closest('.close__modal') || event.target === formBlock) {
                closeModal();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initModalLogic);
    } else {
        initModalLogic();
    }
</script>