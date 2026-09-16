function setupMenuToggle(selectId, inputId, hiddenId, formId) {
    const selectEl = document.getElementById(selectId);
    const inputEl = document.getElementById(inputId);
    const hiddenEl = document.getElementById(hiddenId);
    const formEl = document.getElementById(formId);

    if (!selectEl || !inputEl || !hiddenEl || !formEl) return;

    if (selectEl.value === "__NEW__") {
        inputEl.classList.remove('d-none');
        inputEl.setAttribute("required", "required");
    }

    selectEl.addEventListener("change", function() {
        if (this.value === "__NEW__") {
            inputEl.classList.remove("d-none");
            inputEl.setAttribute("required", "required");
            inputEl.focus();
        } else {
            inputEl.classList.add("d-none");
            inputEl.removeAttribute("required", "required");
            inputEl.value = "";
        }
    });

    formEl.addEventListener("submit", function() {
        if (selectEl.value === "__NEW__") {
            hiddenEl.value = inputEl.value.trim();
        } else {
            hiddenEl.value = selectEl.value;
        }
    });
}

setupMenuToggle(
    "create-category-faq-menu-select",
    "create-category-faq-menu-input",
    "create-category-faq-menu-hidden",
    "createCategoryFaqForm"
);

document.addEventListener('DOMContentLoaded', function() {
    const jenisSelect = document.getElementById('faq-jenis-select');
    const fieldJawaban = document.getElementById('field-jawaban');
    const fieldLink = document.getElementById('field-link');

    function toggleFields() {
        if (jenisSelect.value === 'pdf') {
            fieldLink.classList.remove('d-none');
            fieldJawaban.classList.add('d-none');
        } else if (jenisSelect.value === 'Menu') {
            fieldJawaban.classList.remove('d-none');
            fieldLink.classList.add('d-none');
        }
    }

    jenisSelect.addEventListener('change', toggleFields);
    toggleFields();
});