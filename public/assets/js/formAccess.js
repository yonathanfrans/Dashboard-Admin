document.addEventListener('DOMContentLoaded', function() {
    // Input jenis akses aplikasi dan lainnya
    const aksesApp = document.getElementById('akses_app');
    const wrapperApp = document.getElementById('wrapper-keterangan-app');
    
    const aksesLainnya = document.getElementById('akses_lainnya');
    const wrapperLainnya = document.getElementById('wrapper-keterangan-lainnya');

    function toggleAksesFields() {
        if (aksesApp && wrapperApp) wrapperApp.classList.toggle('d-none', !aksesApp.checked);
        if (aksesLainnya && wrapperLainnya) wrapperLainnya.classList.toggle('d-none', !aksesLainnya.checked);
    }

    if (aksesApp && aksesLainnya) {
        aksesApp.addEventListener('change', toggleAksesFields);
        aksesLainnya.addEventListener('change', toggleAksesFields);
        toggleAksesFields();
    }

    // Input waktu akses untuk keterangan waktu lainnya
    const waktuAkses = document.getElementById('waktu_akses');
    const wrapperWaktu = document.getElementById('wrapper-keterangan-waktu');

    function toggleWaktuField() {
        if (waktuAkses && wrapperWaktu) wrapperWaktu.classList.toggle('d-none', waktuAkses.value !== 'lainnya');
    }

    if (waktuAkses) {
        waktuAkses.addEventListener('change', toggleWaktuField);
        toggleWaktuField();
    }
})