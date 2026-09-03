// Handling Modal Edit Category
const editCategoryModal = document.getElementById("editCategoryModal");
if (editCategoryModal) {
    editCategoryModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;

        const slug = button.getAttribute("data-slug");
        const title = button.getAttribute("data-title");

        const form = editCategoryModal.querySelector("form");

        form.action = `/dashboard/news-categories/${slug}`;

        editCategoryModal.querySelector("#edit-category-title").value = title;
    });
}

// Handling Modal Delete Category
const deleteCategoryModal = document.getElementById("deleteCategoryModal");
if (deleteCategoryModal) {
    deleteCategoryModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute("data-id");
        const title = button.getAttribute("data-title");

        const form = deleteCategoryModal.querySelector("form");
        form.action = `/dashboard/news-categories/${id}`;

        deleteCategoryModal.querySelector(
            "#delete-category-title",
        ).textContent = title;
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

// Handling Modal Delete File
const deleteFileModal = document.getElementById("deleteFileModal");
if (deleteFileModal) {
    deleteFileModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute("data-id");
        const fileName = button.getAttribute("data-file");

        const form = deleteFileModal.querySelector("form");
        form.action = `/dashboard/news/files/${id}`;

        deleteFileModal.querySelector("#delete-file-name").textContent = fileName;
    })
}