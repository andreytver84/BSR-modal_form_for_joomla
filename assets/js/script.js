/* assets/js/script.js */
document.addEventListener('DOMContentLoaded', () => {
    const isSafeRedirect = (url) => {
        if (!url || typeof url !== 'string') {
            return false;
        }

        const trimmed = url.trim();

        if (!trimmed.startsWith('/') || trimmed.startsWith('//') || trimmed.includes('\\')) {
            return false;
        }

        const lower = trimmed.toLowerCase();

        return !lower.includes('javascript:') && !lower.includes('data:') && !lower.includes('vbscript:');
    };

    const getMetrikaCounterIds = () => {
        const ids = [];

        try {
            if (window.Ya && Ya._metrika && typeof Ya._metrika.getCounters === 'function') {
                (Ya._metrika.getCounters() || []).forEach((counter) => {
                    if (counter && counter.id) {
                        ids.push(counter.id);
                    }
                });
            }
        } catch (e) { }

        if (!ids.length && typeof ym !== 'undefined' && Array.isArray(ym.a)) {
            ym.a.forEach((args) => {
                if (args && args[0]) {
                    ids.push(args[0]);
                }
            });
        }

        return ids;
    };

    const reachYmGoal = (goalId) => {
        if (!goalId || typeof ym !== 'function') {
            return;
        }

        const counterIds = getMetrikaCounterIds();

        if (!counterIds.length) {
            return;
        }

        counterIds.forEach((id) => {
            try {
                ym(id, 'reachGoal', goalId);
            } catch (e) { }
        });
    };

    const cssEscape = (value) => {
        if (window.CSS && typeof CSS.escape === 'function') {
            return CSS.escape(value);
        }

        return String(value).replace(/[^A-Za-z0-9_-]/g, '\\$&');
    };

    if (!window.__bsrFormXhrPatched) {
        window.__bsrFormXhrPatched = true;

        const oldSend = XMLHttpRequest.prototype.send;

        XMLHttpRequest.prototype.send = function (data) {
            let isFinalSubmit = false;

            if (data instanceof FormData) {
                if (data.has('rfSubject') || data.has('acception')) {
                    isFinalSubmit = true;
                }
            } else if (typeof data === 'string' && (data.includes('rfSubject=') || data.includes('acception='))) {
                isFinalSubmit = true;
            }

            this.addEventListener('load', () => {
                if (!this.responseURL || this.responseURL.indexOf('radicalform') === -1 || this.status !== 200) {
                    return;
                }

                if (!isFinalSubmit) {
                    return;
                }

                const activeModal = document.querySelector('.bsr-modal:not(.bsr-modal--hidden)');
                if (!activeModal) {
                    return;
                }

                const form = activeModal.querySelector('.bsr-form');
                if (!form) {
                    return;
                }

                let res;

                try {
                    res = JSON.parse(this.responseText);
                } catch (e) {
                    return;
                }

                if (!res || res.error || res.success === false || (res.messages && res.messages.error)) {
                    return;
                }

                const successBox = activeModal.querySelector('.bsr-success');
                const redirectUrl = form.getAttribute('data-redirect');
                const goalId = form.getAttribute('data-goal');

                reachYmGoal(goalId);

                if (isSafeRedirect(redirectUrl)) {
                    window.location.href = redirectUrl;
                    return;
                }

                if (successBox) {
                    successBox.style.display = 'block';
                }
                form.style.display = 'none';

                setTimeout(() => {
                    activeModal.classList.add('bsr-modal--hidden');
                    setTimeout(() => {
                        if (successBox) {
                            successBox.style.display = 'none';
                        }
                        form.style.display = 'block';
                        form.reset();

                        const fileList = form.querySelector('.rf-filenames-list');
                        if (fileList) {
                            fileList.innerHTML = '';
                        }
                    }, 500);
                }, 3000);
            });

            oldSend.apply(this, arguments);
        };
    }

    if (typeof IMask !== 'undefined') {
        const phoneInputs = document.querySelectorAll('.js-bsr-phone-mask');

        phoneInputs.forEach((input) => {
            const maskPattern = input.getAttribute('data-mask');
            if (!maskPattern) {
                return;
            }

            const phoneError = input.getAttribute('data-phone-error') || '';
            const mask = IMask(input, {
                mask: maskPattern,
                lazy: false,
                placeholderChar: '_'
            });

            const form = input.closest('form');
            const isRequired = input.hasAttribute('required');

            const validatePhone = () => {
                const isEmpty = mask.unmaskedValue === '';
                const isComplete = mask.masked.isComplete;

                if ((isRequired && !isComplete) || (!isRequired && !isEmpty && !isComplete)) {
                    input.setCustomValidity(phoneError);
                } else {
                    input.setCustomValidity('');
                }
            };

            validatePhone();
            mask.on('accept', validatePhone);

            if (form) {
                const submitBtn = form.querySelector('[type="submit"], .bsr-form__submit');
                if (submitBtn) {
                    submitBtn.addEventListener('click', () => {
                        validatePhone();

                        if (!isRequired && mask.unmaskedValue === '') {
                            input.value = '';
                        }
                    });
                }

                form.addEventListener('reset', () => {
                    setTimeout(() => {
                        mask.value = '';
                        mask.updateValue();
                        validatePhone();
                    }, 10);
                });
            }
        });
    }

    document.addEventListener('click', (e) => {
        const closeBtn = e.target.closest('.bsr-modal__close');
        if (closeBtn) {
            e.preventDefault();
            const modal = closeBtn.closest('.bsr-modal');
            if (modal) {
                modal.classList.add('bsr-modal--hidden');
            }
            return;
        }

        if (e.target.classList.contains('bsr-modal')) {
            e.target.classList.add('bsr-modal--hidden');
            return;
        }

        if (e.target.classList.contains('rf-button-send')) {
            return;
        }

        const firstModal = document.querySelector('.bsr-modal');
        const modals = document.querySelectorAll('.bsr-modal');

        modals.forEach((formModal) => {
            const modalId = formModal.id;
            const form = formModal.querySelector('.bsr-form');
            if (!modalId || !form) {
                return;
            }

            const openBtn = e.target.closest('.bsr-open-' + cssEscape(modalId) + ', .bsr-open-modal');
            if (!openBtn) {
                return;
            }

            if (openBtn.classList.contains('bsr-open-modal') && !openBtn.classList.contains('bsr-open-' + modalId)) {
                if (firstModal !== formModal) {
                    return;
                }
            }

            e.preventDefault();

            const isAutofill = form.getAttribute('data-autofill') === '1';
            const isQuickOrder = form.getAttribute('data-quick-order') === '1';
            const qoContainer = form.getAttribute('data-qo-container') || '';
            const qoSelector = form.getAttribute('data-qo-selector') || '';
            const qoMode = form.getAttribute('data-qo-mode') || 'consult';
            const qoTopic = (form.getAttribute('data-qo-topic') || '').trim();
            const btnText = openBtn.textContent.trim();
            const title = formModal.querySelector('.bsr-form__title');
            const subject = formModal.querySelector('input[name="rfSubject"]');
            const topic = formModal.querySelector('.bsr-form__topic');

            if (!form.dataset.bsrOriginalTitle) {
                form.dataset.bsrOriginalTitle = title ? title.textContent : '';
                form.dataset.bsrOriginalSubject = subject ? subject.value : '';
            }

            if (title) {
                title.textContent = form.dataset.bsrOriginalTitle || '';
            }
            if (subject) {
                subject.value = form.dataset.bsrOriginalSubject || '';
            }
            if (topic) {
                topic.textContent = '';
                topic.hidden = true;
            }

            const canAutofill = isAutofill && btnText
                && !btnText.toLowerCase().includes('отправить')
                && !btnText.toLowerCase().includes('send');

            const applyAutofill = () => {
                if (!canAutofill) {
                    return;
                }

                if (title) {
                    title.textContent = btnText;
                }
                if (subject) {
                    subject.value = btnText;
                }
            };

            const extractQuickOrderText = () => {
                if (!isQuickOrder || !qoSelector) {
                    return '';
                }

                try {
                    let root = openBtn;

                    if (qoContainer) {
                        root = openBtn.closest('.' + cssEscape(qoContainer));
                    }

                    if (!root) {
                        return '';
                    }

                    const el = root.querySelector(qoSelector);

                    return el ? el.textContent.replace(/\s+/g, ' ').trim() : '';
                } catch (err) {
                    return '';
                }
            };

            const extracted = extractQuickOrderText();

            if (extracted) {
                if (qoMode === 'order') {
                    const combined = (btnText + ' ' + extracted).trim();

                    if (title) {
                        title.textContent = combined;
                    }
                    if (subject) {
                        subject.value = combined;
                    }
                } else {
                    applyAutofill();

                    const heading = title ? title.textContent.trim() : btnText;
                    const topicLine = (qoTopic + ' ' + extracted).trim();

                    if (topic) {
                        topic.textContent = topicLine;
                        topic.hidden = false;
                    }
                    if (subject) {
                        subject.value = (heading + ' ' + topicLine).trim();
                    }
                }
            } else {
                applyAutofill();
            }

            formModal.classList.remove('bsr-modal--hidden');
        });
    });
});
