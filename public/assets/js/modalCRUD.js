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
        form.action = `/dashboard/faqs/${id}`;

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
        form.action = `/dashboard/access-requests/${id}`;

        deleteAccessRequestModal.querySelector(
            "#delete-access-request",
        ).textContent = nama;
    });
}

// Handling Modal view progress SIUP
const viewProgressSiupModal = document.getElementById("viewProgressSiupModal");
if (viewProgressSiupModal) {
    viewProgressSiupModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;

        const id = button.getAttribute("data-id");
        const nomorAgenda = button.getAttribute("data-nomor-agenda");
        const tglPermohonan = button.getAttribute("data-tgl-permohonan");
        const namaPemilik = button.getAttribute("data-nama-pemilik");
        const keterangan = button.getAttribute("data-keterangan");
        const jenisIzin = button.getAttribute("data-nama-jenis-izin");
        const statusIzin = button.getAttribute("data-nama-status-izin");
        const nomorIzin = button.getAttribute("data-nomor-izin");
        
        const catatanStopProses = button.getAttribute("data-catatan-stop-proses");
        const statusTerbit = button.getAttribute("data-status-terbit");
        const statusBatal = button.getAttribute("data-status-batal");

        // Set Text Data
        viewProgressSiupModal.querySelector("#view-progress-id").textContent = id;
        viewProgressSiupModal.querySelector("#view-progress-nomor-agenda").textContent = nomorAgenda;
        viewProgressSiupModal.querySelector("#view-progress-tgl-permohonan").textContent = tglPermohonan;
        viewProgressSiupModal.querySelector("#view-progress-nama-pemilik").textContent = namaPemilik;
        viewProgressSiupModal.querySelector("#view-progress-keterangan").textContent = keterangan && keterangan !== 'null' ? `${keterangan}` : '';
        viewProgressSiupModal.querySelector("#view-progress-jenis-status").textContent = `${jenisIzin} - ${statusIzin}`;
        viewProgressSiupModal.querySelector("#view-progress-nomor-izin").textContent = nomorIzin && nomorIzin !== 'null' ? nomorIzin : '-';

        // Status Terbit Badge styling
        const badgeStatus = viewProgressSiupModal.querySelector("#view-progress-status-terbit");
        badgeStatus.textContent = statusTerbit || statusBatal; // Tampilkan status terbit atau batal
        // Cek apakah status batal bernilai 1 (True)
        if (statusBatal === "1" || statusBatal === "true") {
            badgeStatus.textContent = "BATAL";
            badgeStatus.className = 'badge bg-danger';
        } else {
            // Jika tidak batal, cek status terbit
            badgeStatus.textContent = statusTerbit || 'Tidak diketahui';

            if (statusTerbit === 'TERBIT') {
                badgeStatus.className = 'badge bg-success';
            } else if (statusTerbit === 'PROSES') {
                badgeStatus.className = 'badge bg-secondary'; 
            } else {
                badgeStatus.className = 'badge bg-danger';
            }
        }

        // Helper untuk memproses dan menampilkan item timeline jika data tersedia
        function checkAndRenderTimeline(rawProgress, itemId, descId) {
            const itemElement = viewProgressSiupModal.querySelector(`#${itemId}`);
            
            if (!rawProgress || rawProgress === 'null' || rawProgress.trim() === '') {
                itemElement.classList.add('d-none'); // Sembunyikan jika kosong
                return false;
            }

            // Parsing string format "WaktuMulai | WaktuSelesai"
            const parts = rawProgress.split('|');
            const waktuMulai = parts[0] ? parts[0].trim() : '';
            const waktuSelesai = parts[1] ? parts[1].trim() : waktuMulai;

            // viewProgressSiupModal.querySelector(`#${dateId}`).textContent = `Waktu Selesai: ${waktuSelesai}`;
            viewProgressSiupModal.querySelector(`#${descId}`).textContent = `Mulai: ${waktuMulai} | Selesai: ${waktuSelesai}`;
            
            itemElement.classList.remove('d-none'); // Tampilkan jika ada datanya
            return true;
        }

        // Cek dan render masing-masing progress
        const p1  = checkAndRenderTimeline(button.getAttribute("data-progress1"), 'item-progress1', 'desc-progress1');
        const p3  = checkAndRenderTimeline(button.getAttribute("data-progress3"), 'item-progress3', 'desc-progress3');
        const p4  = checkAndRenderTimeline(button.getAttribute("data-progress4"), 'item-progress4', 'desc-progress4');
        const p5  = checkAndRenderTimeline(button.getAttribute("data-progress5"), 'item-progress5', 'desc-progress5');
        const p7a = checkAndRenderTimeline(button.getAttribute("data-progress7a"), 'item-progress7a', 'desc-progress7a');
        const p7b = checkAndRenderTimeline(button.getAttribute("data-progress7b"), 'item-progress7b', 'desc-progress7b');

        // Tampilkan pesan jika seluruh progress kosong
        const emptyTimeline = viewProgressSiupModal.querySelector("#empty-timeline");
        if (!p1 && !p3 && !p4 && !p5 && !p7a && !p7b) {
            emptyTimeline.classList.remove('d-none');
        } else {
            emptyTimeline.classList.add('d-none');
        }

        // Catatan stop proses
        const wrapperCatatan = viewProgressSiupModal.querySelector("#wrapper-catatan");
        if (catatanStopProses && catatanStopProses !== 'null') {
            wrapperCatatan.classList.remove('d-none');
            viewProgressSiupModal.querySelector("#view-progress-catatan-stop-proses").textContent = catatanStopProses;
        } else {
            wrapperCatatan.classList.add('d-none');
        }
    });
}