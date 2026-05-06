/* assets/js/script.js */
document.addEventListener('DOMContentLoaded', () => {
    // --- 1. ПЕРЕХВАТЧИК AJAX ЗАПРОСОВ ---
    const oldSend = XMLHttpRequest.prototype.send;

    XMLHttpRequest.prototype.send = function (data) {
        let isFinalSubmit = false;

        // УМНАЯ ПРОВЕРКА: Смотрим, что именно сейчас отправляется на сервер
        // Если внутри запроса есть поле 'rfSubject' (наше скрытое поле), значит отправляется вся форма.
        // Если его нет - значит RadicalForm просто в фоне загружает прикрепленный файл.
        if (data instanceof FormData) {
            if (data.has('rfSubject') || data.has('acception')) {
                isFinalSubmit = true;
            }
        } else if (typeof data === 'string' && (data.includes('rfSubject=') || data.includes('acception='))) {
            isFinalSubmit = true;
        }

        this.addEventListener('load', () => {
            // Слушаем только успешные ответы от плагина RadicalForm
            if (this.responseURL.includes('radicalform') && this.status === 200) {

                // Если это была просто фоновая загрузка файла - ничего не закрываем, ждем дальше!
                if (!isFinalSubmit) return;

                // Ищем открытое модальное окно
                const activeModal = document.querySelector('.bsr-modal:not(.bsr-modal--hidden)');
                if (!activeModal) return;
                const form = activeModal.querySelector('.bsr-form');
                if (!form) return;

                try {
                    const res = JSON.parse(this.responseText);
                    // Серверная валидация: если плагин вернул ошибку - прерываем процесс, 
                    // чтобы плагин мог показать красные предупреждения под полями.
                    if (res.error || res.success === false || (res.messages && res.messages.error)) {
                        return;
                    }
                } catch (e) { }

                // --- ЕСЛИ ОШИБОК НЕТ, ФОРМА УСПЕШНО ОТПРАВЛЕНА ---
                const successBox = activeModal.querySelector('.bsr-success');
                const redirectUrl = form.getAttribute('data-redirect');
                const goalId = form.getAttribute('data-goal');

                // Отправка в Яндекс Метрику
                if (goalId && typeof ym !== 'undefined') {
                    try { ym.apply(null, [null, 'reachGoal', goalId]); } catch (e) { }
                }

                // Логика завершения
                if (redirectUrl) {
                    window.location.href = redirectUrl;
                } else {
                    // Прячем форму, показываем "Отлично! Заявка принята"
                    if (successBox) successBox.style.display = "block";
                    form.style.display = "none";

                    // Через 3 секунды закрываем окно
                    setTimeout(() => {
                        activeModal.classList.add('bsr-modal--hidden');
                        setTimeout(() => {
                            // Возвращаем форму в исходное состояние (чтобы ее можно было открыть снова)
                            if (successBox) successBox.style.display = "none";
                            form.style.display = "block";
                            form.reset();

                            // Очищаем список прикрепленных файлов
                            const fileList = form.querySelector('.rf-filenames-list');
                            if (fileList) fileList.innerHTML = '';
                        }, 500);
                    }, 3000);
                }
            }
        });

        oldSend.apply(this, arguments);
    };

    // --- 2. ИНИЦИАЛИЗАЦИЯ ОТКРЫТИЯ/ЗАКРЫТИЯ ОКОН ---
    const bsrModals = document.querySelectorAll('.bsr-modal');

    // --- 3. ИНИЦИАЛИЗАЦИЯ МАСКИ ТЕЛЕФОНА ---
    if (typeof IMask !== 'undefined') {
        const phoneInputs = document.querySelectorAll('.js-bsr-phone-mask');

        phoneInputs.forEach(input => {
            const maskPattern = input.getAttribute('data-mask');
            if (maskPattern) {
                // Инициализация маски (видимая всегда)
                const mask = IMask(input, {
                    mask: maskPattern,
                    lazy: false,
                    placeholderChar: '_'
                });

                const form = input.closest('form');
                const isRequired = input.hasAttribute('required');

                // Универсальная функция валидации
                const validatePhone = () => {
                    const isEmpty = mask.unmaskedValue === '';
                    const isComplete = mask.masked.isComplete;

                    // 1. Обязательно, но не заполнено (или заполнено не до конца)
                    if (isRequired && !isComplete) {
                        input.setCustomValidity('Пожалуйста, введите номер полностью.');
                    }
                    // 2. Необязательно, но начали вводить и бросили на половине
                    else if (!isRequired && !isEmpty && !isComplete) {
                        input.setCustomValidity('Пожалуйста, введите номер полностью.');
                    }
                    // 3. Всё правильно (ввели полностью или оставили пустым необязательное)
                    else {
                        input.setCustomValidity('');
                    }
                };

                // ВАЖНО: Запускаем проверку СРАЗУ при открытии окна!
                // Это заблокирует кнопку "Отправить" на нативном уровне браузера.
                validatePhone();

                // Проверяем при каждом введенном символе
                mask.on('accept', validatePhone);

                if (form) {
                    // Перехватываем клик по кнопке отправки
                    const submitBtn = form.querySelector('[type="submit"], .bsr-form__submit');
                    if (submitBtn) {
                        submitBtn.addEventListener('click', () => {
                            validatePhone(); // Перепроверяем на всякий случай

                            // Если поле НЕ обязательное и мы его не заполняли, 
                            // стираем маску перед самой отправкой, чтобы на почту пришла пустота
                            if (!isRequired && mask.unmaskedValue === '') {
                                input.value = '';
                            }
                        });
                    }

                    // Восстанавливаем всё после успешной отправки (сброс от RadicalForm)
                    form.addEventListener('reset', () => {
                        setTimeout(() => {
                            mask.value = '';
                            mask.updateValue();
                            validatePhone(); // Снова блокируем для следующей отправки
                        }, 10);
                    });
                }
            }
        });
    }

    bsrModals.forEach(formModal => {
        const modalId = formModal.id;
        const form = formModal.querySelector('.bsr-form');
        if (!form) return;

        const isAutofill = form.getAttribute('data-autofill') === '1';

        document.addEventListener('click', (e) => {
            const openBtn = e.target.closest('.bsr-open-' + modalId + ', .bsr-open-modal');
            if (openBtn && !e.target.classList.contains('rf-button-send')) {
                // Защита от конфликта общих кнопок
                if (openBtn.classList.contains('bsr-open-modal') && !openBtn.classList.contains('bsr-open-' + modalId)) {
                    if (document.querySelector('.bsr-modal') !== formModal) return;
                }

                e.preventDefault();
                const btnText = openBtn.textContent.trim();
                const title = formModal.querySelector('.bsr-form__title');
                const subject = formModal.querySelector('input[name="rfSubject"]');

                if (isAutofill && btnText && !btnText.toLowerCase().includes('отправить') && !btnText.toLowerCase().includes('send')) {
                    if (title) title.textContent = btnText;
                    if (subject) subject.value = btnText;
                }

                formModal.classList.remove('bsr-modal--hidden');
            }

            // Закрытие по крестику или клику мимо окна
            if (e.target.closest('.bsr-modal__close') || e.target === formModal) {
                formModal.classList.add('bsr-modal--hidden');
            }
        });
    });
});