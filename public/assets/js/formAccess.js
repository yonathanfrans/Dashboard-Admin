document.addEventListener('DOMContentLoaded', function() {
    const aksesApp = document.getElementById('akses_app');
    const wrapperApp = document.getElementById('wrapper-keterangan-app');
    
    const aksesLainnya = document.getElementById('akses_lainnya');
    const wrapperLainnya = document.getElementById('wrapper-keterangan-lainnya');

    function toggleAksesFields() {
        if (aksesApp.checked) {
            wrapperApp.classList.remove('d-none');
        } else {
            wrapperApp.classList.add('d-none');
        }

        if (aksesLainnya.checked) {
            wrapperLainnya.classList.remove('d-none');
        } else {
            wrapperLainnya.classList.add('d-none');
        }
    }

    aksesApp.addEventListener('change', toggleAksesFields);
    aksesLainnya.addEventListener('change', toggleAksesFields);
    toggleAksesFields();

    const waktuAkses = document.getElementById('waktu_akses');
    const wrapperWaktu = document.getElementById('wrapper-keterangan-waktu');

    function toggleWaktuField() {
        if (waktuAkses.value === 'lainnya') {
            wrapperWaktu.classList.remove('d-none');
        } else {
            wrapperWaktu.classList.add('d-none');
        }
    }

    waktuAkses.addEventListener('change', toggleWaktuField);
    toggleWaktuField();
})