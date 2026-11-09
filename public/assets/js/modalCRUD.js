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

// Handling Modal view detail sub alat tangkap
const viewSubAlatTangkapModal = document.getElementById("viewSubAlatTangkapModal");
if (viewSubAlatTangkapModal) {
    viewSubAlatTangkapModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;

        // Helper function untuk membersihkan nilai '-' menjadi kosong jika digabung
        const val = (attr) => {
            const v = button.getAttribute(attr);
            return (!v || v === 'null' || v === '-') ? '' : v;
        };

        const getAttr = (attr) => button.getAttribute(attr) ?? '-';

        // Ambil data penting
        const kode = getAttr("data-kode");
        const keterangan = getAttr("data-keterangan");
        const namaEpit = getAttr("data-nama-epit");
        const kelompokApiIzin = getAttr("data-kelompok-api-izin");
        const nmEn = getAttr("data-nm-en");
        const pnbp = getAttr("data-pnbp");
        const kelompokAkt = getAttr("data-kelompok-akt");
        const koefisien = getAttr("data-koefisien");
        const palkah = getAttr("data-palkah");
        const kuota = getAttr("data-kuota");
        const harga = getAttr("data-harga");
        const statusPengangkut = getAttr("data-status-pengangkut");
        const statusRumpon = getAttr("data-status-rumpon");
        const statusArmada = getAttr("data-status-armada");
        const aktif = getAttr("data-aktif");
        const kodeKbli = getAttr("data-kbli");
        const grupSilat = getAttr("data-grup-silat");
        const keteranganGroup = getAttr("data-keterangan-group");
        const jumlahHariMelaut = getAttr("data-jumlah-hari-melaut");
        const pascaProduksi = getAttr("data-pasca-produksi");
        const alatTangkapSama = getAttr("data-alat-tangkap-sama");
        const alatTangkapAlias = getAttr("data-alat-tangkap-alias");
        const display = getAttr("data-display");
        const statusSatuKesatuanUsaha = getAttr("data-status-satu-kesatuan-usaha");
        const groupApi = getAttr("data-group-api");
        const kelompokApi = getAttr("data-kelompok-api");
        const validasiUkuranKapal = getAttr("data-validasi-ukuran-kapal");
        const listJenisIzin = getAttr("data-list-jenis-izin");
        const periodeIzin = getAttr("data-periode-izin");
        
        // ID fields
        const idSubAlatTangkap = getAttr("data-id-sub-alat-tangkap");
        const idSubAlatTangkapLama = getAttr("data-id-sub-alat-tangkap-lama");
        const idSubAlatTangkapBaru = getAttr("data-id-sub-alat-tangkap-baru");
        const idAlatTangkap = getAttr("data-id-alat-tangkap");
        const idFishingGear = getAttr("data-id-fishing-gear");
        const idJenisIzin = getAttr("data-id-jenis-izin");
        const idAlatTangkapPusdatin = getAttr("data-id-alat-tangkap-pusdatin");
        const idSubAlatTangkapMigrasi = getAttr("data-id-sub-alat-tangkap-migrasi");
        const idPenggunaBuat = getAttr("data-id-pengguna-buat");
        const tanggalBuat = getAttr("data-tanggal-buat");
        const idPenggunaUbah = getAttr("data-id-pengguna-ubah");
        const tanggalUbah = getAttr("data-tanggal-ubah");
        const idPenggunaHapus = getAttr("data-id-pengguna-hapus");
        const tanggalHapus = getAttr("data-tanggal-hapus");
        const id2000 = getAttr("data-id2000");

        // Set Text Data ke Elemen Modal
        viewSubAlatTangkapModal.querySelector("#detail-kode").textContent = kode;
        viewSubAlatTangkapModal.querySelector("#detail-keterangan").textContent = keterangan;
        viewSubAlatTangkapModal.querySelector("#detail-nama-epit").textContent = namaEpit;
        
        // Penggabungan aman untuk Kelompok API
        const formatKelompokApi = [kelompokApi, kelompokApiIzin].filter(Boolean).join(' / ');
        viewSubAlatTangkapModal.querySelector("#detail-kelompok-api-izin").textContent = formatKelompokApi || '-';

        viewSubAlatTangkapModal.querySelector("#detail-nm-en").textContent = nmEn;
        viewSubAlatTangkapModal.querySelector("#detail-pnbp").textContent = pnbp;
        viewSubAlatTangkapModal.querySelector("#detail-kelompok-akt").textContent = kelompokAkt;
        viewSubAlatTangkapModal.querySelector("#detail-koefisien").textContent = koefisien;
        viewSubAlatTangkapModal.querySelector("#detail-palkah").textContent = palkah;
        viewSubAlatTangkapModal.querySelector("#detail-kuota").textContent = kuota;
        viewSubAlatTangkapModal.querySelector("#detail-harga").textContent = harga;
        viewSubAlatTangkapModal.querySelector("#detail-status-armada").textContent = statusArmada;

        // Penggabungan aman untuk Grup API SILAT
        const formatGrupSilat = [groupApi, grupSilat].filter(Boolean).join(' / ');
        viewSubAlatTangkapModal.querySelector("#detail-grup-api-silat").textContent = formatGrupSilat || '-';

        viewSubAlatTangkapModal.querySelector("#detail-kode-kbli").textContent = kodeKbli;
        viewSubAlatTangkapModal.querySelector("#detail-keterangan-group").textContent = keteranganGroup;
        viewSubAlatTangkapModal.querySelector("#detail-jumlah-hari-melaut").textContent = jumlahHariMelaut !== '-' ? `${jumlahHariMelaut} hari` : '-';
        viewSubAlatTangkapModal.querySelector("#detail-alat-tangkap-sama").textContent = alatTangkapSama;
        viewSubAlatTangkapModal.querySelector("#detail-alat-tangkap-alias").textContent = alatTangkapAlias; 
        viewSubAlatTangkapModal.querySelector("#detail-display").textContent = display;
        viewSubAlatTangkapModal.querySelector("#detail-validasi-ukuran-kapal").textContent = validasiUkuranKapal;
        viewSubAlatTangkapModal.querySelector("#detail-list-jenis-izin").textContent = listJenisIzin;
        viewSubAlatTangkapModal.querySelector("#detail-periode-izin").textContent = periodeIzin !== '-' ? `${periodeIzin} hari` : '-';
        
        viewSubAlatTangkapModal.querySelector("#detail-id-sub-alat-tangkap").textContent = idSubAlatTangkap;
        viewSubAlatTangkapModal.querySelector("#detail-id-sub-alat-tangkap-lama").textContent = idSubAlatTangkapLama;
        viewSubAlatTangkapModal.querySelector("#detail-id-sub-alat-tangkap-baru").textContent = idSubAlatTangkapBaru;
        viewSubAlatTangkapModal.querySelector("#detail-id-alat-tangkap").textContent = idAlatTangkap;
        viewSubAlatTangkapModal.querySelector("#detail-id-fishing-gear").textContent = idFishingGear;
        viewSubAlatTangkapModal.querySelector("#detail-id-alat-tangkap-pusdatin").textContent = idAlatTangkapPusdatin;
        viewSubAlatTangkapModal.querySelector("#detail-id-jenis-izin").textContent = idJenisIzin;
        viewSubAlatTangkapModal.querySelector("#detail-id-sub-alat-tangkap-migrasi").textContent = idSubAlatTangkapMigrasi;
        viewSubAlatTangkapModal.querySelector("#detail-id-pengguna-buat").textContent = idPenggunaBuat;
        viewSubAlatTangkapModal.querySelector("#detail-tanggal-buat").textContent = tanggalBuat;
        viewSubAlatTangkapModal.querySelector("#detail-id-pengguna-ubah").textContent = idPenggunaUbah;
        viewSubAlatTangkapModal.querySelector("#detail-tanggal-ubah").textContent = tanggalUbah;
        viewSubAlatTangkapModal.querySelector("#detail-id-pengguna-hapus").textContent = idPenggunaHapus;
        viewSubAlatTangkapModal.querySelector("#detail-tanggal-hapus").textContent = tanggalHapus;
        viewSubAlatTangkapModal.querySelector("#detail-id-2000").textContent = id2000;

        // Styling Badge Aktif
        const badgeAktif = viewSubAlatTangkapModal.querySelector("#detail-aktif");
        badgeAktif.textContent = aktif;
        if (aktif === 'YA') {
            badgeAktif.className = 'badge bg-success';
        } else if (aktif === 'TIDAK') {
            badgeAktif.className = 'badge bg-danger';
        } else {
            badgeAktif.className = '';
        }

        // Styling Badge Pengangkut
        const badgePengangkut = viewSubAlatTangkapModal.querySelector("#detail-status-pengangkut");
        badgePengangkut.textContent = statusPengangkut;
        if (statusPengangkut === 'YA') {
            badgePengangkut.className = 'badge bg-info';
        } else if (statusPengangkut === 'TIDAK') {
            badgePengangkut.className = 'badge bg-danger';
        } else {
            badgePengangkut.className = '';
        }

        // Styling Badge Rumpon
        const badgeRumpon = viewSubAlatTangkapModal.querySelector("#detail-status-rumpon");
        badgeRumpon.textContent = statusRumpon;
        if (statusRumpon === 'YA') {
            badgeRumpon.className = 'badge bg-warning';
        } else if (statusRumpon === 'TIDAK') {
            badgeRumpon.className = 'badge bg-danger';
        } else {
            badgeRumpon.className = '';
        }

        // Styling Badge Pasca Produksi
        const badgePascaProduksi = viewSubAlatTangkapModal.querySelector("#detail-pasca-produksi");
        badgePascaProduksi.textContent = pascaProduksi;
        if (pascaProduksi === 'YA') {
            badgePascaProduksi.className = 'badge bg-primary';
        } else if (pascaProduksi === 'TIDAK') {
            badgePascaProduksi.className = 'badge bg-danger';
        } else {
            badgePascaProduksi.className = '';
        }

        // Styling Badge Satu Kesatuan Usaha
        const badgeSatuKesatuanUsaha = viewSubAlatTangkapModal.querySelector("#detail-status-satu-kesatuan-usaha");
        badgeSatuKesatuanUsaha.textContent = statusSatuKesatuanUsaha;
        if (statusSatuKesatuanUsaha === 'YA') {
            badgeSatuKesatuanUsaha.className = 'badge bg-info';
        } else if (statusSatuKesatuanUsaha === 'TIDAK') {
            badgeSatuKesatuanUsaha.className = 'badge bg-danger';
        } else {
            badgeSatuKesatuanUsaha.className = '';
        }
    });
}