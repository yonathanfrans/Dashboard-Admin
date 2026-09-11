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