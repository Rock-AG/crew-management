import './bootstrap';

import flatpickr from "flatpickr";
import Accordion from "accordion-js";

/**
 * Localize flatpickr
 */
// const German = require("flatpickr/dist/l10n/de.js");
import { German } from "flatpickr/dist/l10n/de.js";

/**
 * Add flatpickr for events
 */
function addEvents() {
    const e = new Date();
    e.setHours(0);
    flatpickr(".datetimepicker", {
        minDate: e,
        enableTime: true,
        time_24hr: true,
        locale: German,
        altInput: true,
        altFormat: 'd. F Y, H:i',
    });

    flatpickr(".datepicker", {
        enableTime: false,
        locale: German,
        altInput: true,
        altFormat: 'd. F Y',
    });

    const el = document.getElementById('start');
    if (el !== null) {
        el.addEventListener("change",
            (function () {
                const e1 = new Date(document.getElementById('start').value);
                const e2 = new Date(e1);
                e2.setHours(e2.getHours() + 1);
                document.getElementById('end').flatpickr({
                    defaultDate: e2,
                    minDate: e1,
                    enableTime: true,
                    time_24hr: true,
                    locale: 'de',
                    altInput: true,
                    altFormat: 'd. F Y, H:i',
                });
            })
        );
    }
}

/**
 * Add a confirmation dialog before deleting a shift
 */
function deleteWithConfirm() {
    const forms = document.querySelectorAll('form.delete-with-confirm');
    if (forms.length > 0) {
        forms.forEach((form) => {
            const msg = form.dataset['confirmDeleteMsg'];
            form.addEventListener('submit', function (event) {
                if (!confirm(msg)) {
                    event.preventDefault();
                }
            });
        });
    }
}

document.addEventListener('DOMContentLoaded', addEvents);
document.addEventListener('DOMContentLoaded', deleteWithConfirm);

function openImport() {
    document.getElementById('importForm').style['display'] = 'block';
    this.style['display'] = 'none';
}
function registerOpenImport() {
    var button = document.getElementById('openImportButton');
    if (button) {
        button.onclick = openImport;
        document.getElementById('import').onchange = function () {
            document.getElementById('importPlanForm').submit();
        };
    }
}
document.addEventListener('DOMContentLoaded', registerOpenImport);

function createAccordion() {
    const options = {
        showMultiple: true,
    };
    const accordions = Array.from(document.querySelectorAll(".accordion-container"));
    new Accordion(accordions, options);
}
document.addEventListener('DOMContentLoaded', createAccordion);

function registerCopyLink() {
    const copyButtons = Array.from(document.querySelectorAll(".js-copy-link"));
    copyButtons.forEach(function (e) {
        e.addEventListener('click', function () {
            const textField = document.getElementById(this.dataset.inputId);
            textField.select();
            textField.setSelectionRange(0, 9999);

            navigator.clipboard.writeText(textField.value)
                .then(() => {
                    this.querySelector('span').textContent = this.dataset.successText;
                    textField.blur();
                })
                .catch(err => {
                    console.error('Failed to copy text: ', err);
                });

        });
    });
}
document.addEventListener('DOMContentLoaded', registerCopyLink);

function registerCopyText() {
    const copyButtons = Array.from(document.querySelectorAll(".js-copy-text"));
    copyButtons.forEach(function (e) {
        e.addEventListener('click', function () {
            const text = this.dataset.text;

            navigator.clipboard.writeText(text)
                .then(() => {
                    this.querySelector('span').textContent = this.dataset.successText;
                })
                .catch(err => {
                    console.error('Failed to copy text: ', err);
                });

        });
    });
}
document.addEventListener('DOMContentLoaded', registerCopyText);