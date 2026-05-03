/* assets/js/script.js */
document.addEventListener('DOMContentLoaded', () => {
    // --- 1. ПЕРЕХВАТЧИК AJAX ЗАПРОСОВ ---
    const oldSend = XMLHttpRequest.prototype.send;
    XMLHttpRequest.prototype.send = function (data) {

        this.addEventListener('load', function () {
            // Ждем только ответы от плагина RadicalForm
            if (this.responseURL.includes('radicalform') && this.status === 200) {

                // Ищем форму, на которой ИМЕННО НАЖАЛИ КНОПКУ "ОТПРАВИТЬ"
                const submittingForm = document.querySelector('.bsr-form.is-submitting');

                // Если кнопку никто не нажимал, значит это фоновая загрузка файла. Просто игнорируем!
                if (!submittingForm) return;

                try {
                    const res = JSON.parse(this.responseText);

                    // Проверяем, вернул ли плагин ошибки (например, не заполнено Имя)
                    if (res.error || res.success === false || (res.messages && res.messages.error)) {
                        // Ошибка есть! Снимаем блокировку, оставляем окно открытым
                        submittingForm.classList.remove('is-submitting');
                        submittingForm.style.opacity = "1";
                        return;
                    }
                } catch (e) { } // Если ответ не читается, идем дальше

                // --- ЕСЛИ ОШИБОК НЕТ, ЗНАЧИТ ФОРМА УСПЕШНО ОТПРАВЛЕНА! ---
                submittingForm.classList.remove('is-submitting');

                const activeModal = submittingForm.closest('.bsr-modal');
                const successBox = activeModal.querySelector('.bsr-success');
                const redirectUrl = submittingForm.getAttribute('data-redirect');
                const goalId = submittingForm.getAttribute('data-goal');

                // Отправка в Яндекс Метрику
                if (goalId && typeof ym !== 'undefined') {
                    try { ym.apply(null, [null, 'reachGoal', goalId]); } catch (e) { }
                }

                // Завершение работы (Редирект или показ сообщения "Отлично!")
                if (redirectUrl) {
                    window.location.href = redirectUrl;
                } else {
                    if (successBox) successBox.style.display = "block";
                    submittingForm.style.display = "none";

                    // Через 3 секунды закрываем окно и возвращаем форму в исходное состояние
                    setTimeout(() => {
                        activeModal.classList.add('bsr-modal--hidden');
                        setTimeout(() => {
                            if (successBox) successBox.style.display = "none";
                            submittingForm.style.display = "block";
                            submittingForm.style.opacity = "1";
                            submittingForm.reset();

                            // Очищаем список прикрепленных файлов (удаляем надписи с именами)
                            const fileList = submittingForm.querySelector('.rf-filenames-list');
                            if (fileList) fileList.innerHTML = '';
                        }, 500);
                    }, 3000);
                }
            }
        });

        oldSend.apply(this, arguments);
    };

    // --- 2. ИНИЦИАЛИЗАЦИЯ ФОРМ И КНОПОК ---
    const bsrModals = document.querySelectorAll('.bsr-modal');

    bsrModals.forEach(formModal => {
        const modalId = formModal.id;
        const form = formModal.querySelector('.bsr-form');
        if (!form) return;

        const isAutofill = form.getAttribute('data-autofill') === '1';

        // Открытие и закрытие модального окна
        document.addEventListener('click', (e) => {
            const openBtn = e.target.closest('.bsr-open-' + modalId + ', .bsr-open-modal');
            if (openBtn && !e.target.classList.contains('rf-button-send')) {
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

            if (e.target.closest('.bsr-modal__close') || e.target === formModal) {
                formModal.classList.add('bsr-modal--hidden');
            }
        });

        // Отслеживаем ИМЕННО НАЖАТИЕ на кнопку отправки формы
        const submitBtn = form.querySelector('.bsr-form__submit.rf-button-send');
        if (submitBtn) {
            submitBtn.addEventListener('click', () => {
                // Ставим метку "Форма в процессе отправки"
                form.classList.add('is-submitting');
                form.style.opacity = "0.5";

                // Защита: если вдруг сервер завис, через 15 секунд возвращаем форму к жизни
                setTimeout(() => {
                    form.classList.remove('is-submitting');
                    form.style.opacity = "1";
                }, 15000);
            });
        }
    });
});