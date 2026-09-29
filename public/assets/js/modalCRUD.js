// Handling Modal Edit Category FAQ
const editCategoryFaqModal = document.getElementById("editCategoryFaqModal");
if (editCategoryFaqModal) {
    editCategoryFaqModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;

        const id = button.getAttribute("data-id");
        const menu = button.getAttribute("data-menu");
        const subMenu = button.getAttribute("data-sub-menu");
        const noUrut = button.getAttribute("data-no-urut");
        const aktif = button.getAttribute("data-aktif");

        const form = editCategoryFaqModal.querySelector("#editCategoryFaqForm");

        form.action = `/dashboard/faq-menus/${id}`;

        editCategoryFaqModal.querySelector("#update-category-faq-menu").value = menu;
        editCategoryFaqModal.querySelector("#update-category-faq-sub-menu").value = subMenu;
        editCategoryFaqModal.querySelector("#update-category-faq-no-urut").value = noUrut;
        editCategoryFaqModal.querySelector("#update-category-faq-status").value = aktif;
    });
}

// Handling Modal Delete Category FAQ
const deleteCategoryFaqModal = document.getElementById("deleteCategoryFaqModal");
if (deleteCategoryFaqModal) {
    deleteCategoryFaqModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute("data-id");
        const subMenu = button.getAttribute("data-sub-menu");

        const form = deleteCategoryFaqModal.querySelector("#deleteCategoryFaqForm");
        form.action = `/dashboard/faq-menus/${id}`;

        deleteCategoryFaqModal.querySelector(
            "#delete-category-faq-sub-menu",
        ).textContent = subMenu;
    });
}

// Handling Modal Delete FAQ
const deleteFaqModal = document.getElementById("deleteFaqModal");
if (deleteFaqModal) {
    deleteFaqModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute("data-id");
        const pertanyaan = button.getAttribute("data-pertanyaan");

        const form = deleteFaqModal.querySelector("#deleteFaqForm");
        form.action = `/dashboard/faq/${id}`;

        deleteFaqModal.querySelector(
            "#delete-faq",
        ).textContent = pertanyaan;
    });
}

// Handling Modal Delete News
const deleteNewsModal = document.getElementById("deleteNewsModal");
if (deleteNewsModal) {
    deleteNewsModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute("data-id");
        const title = button.getAttribute("data-title");

        const form = deleteNewsModal.querySelector("form");
        form.action = `/dashboard/news/${id}`;

        deleteNewsModal.querySelector("#delete-news-title").textContent = title;
    })
}

// Handling Modal Delete Access Request
const deleteAccessRequestModal = document.getElementById("deleteAccessRequestModal");
if (deleteAccessRequestModal) {
    deleteAccessRequestModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute("data-id");
        const nama = button.getAttribute("data-nama");

        const form = deleteAccessRequestModal.querySelector("#deleteAccessRequestForm");
        form.action = `/dashboard/access-request/${id}`;

        deleteAccessRequestModal.querySelector(
            "#delete-access-request",
        ).textContent = nama;
    });
}