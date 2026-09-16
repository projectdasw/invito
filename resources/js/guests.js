document.addEventListener('DOMContentLoaded', function () {
    /*Guest Search & Filter*/
    const searchInput = document.getElementById('searchGuest');
    const filterStatus = document.getElementById('filterStatus');

    function filterGuests() {
        const search = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const status = filterStatus ? filterStatus.value : '';
        const rows = document.querySelectorAll('#guestTable tr[data-name]');
        rows.forEach(function (row) {
            const name = row.dataset.name;
            const guestStatus = row.dataset.status;
            const matchName = name.includes(search);
            const matchStatus = status === '' || guestStatus === status;
            row.style.display = matchName && matchStatus ? '' : 'none';
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterGuests);
    }

    if (filterStatus) {
        filterStatus.addEventListener('change', filterGuests);
    }

    // CRUD + Alert Message
    // =======================================

    /* Success Alert */
    const successContainer = document.querySelector('[data-success]');
    const successMessage = successContainer ? successContainer.dataset.success : null;

    if (successMessage) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: successMessage,
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    }

    /* Add Guest Form */
    const guestForm = document.getElementById('guestForm');
    if (guestForm) {
        const nameInput = document.getElementById('name');
        const phoneInput = document.getElementById('no_hp');
        const saveButton = document.getElementById('saveGuestButton');

        /* Phone Number - Only Numbers*/
        phoneInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '');
        });

        /* Bootstrap Form Validation */
        guestForm.addEventListener('submit', function (event) {
            event.preventDefault();
            event.stopPropagation();

            /* Trigger Bootstrap validation */
            guestForm.classList.add('was-validated');

            /* Check HTML5 validity*/
            if (!guestForm.checkValidity()) {
                return;
            }

            /* Submit */
            saveButton.disabled = true;
            saveButton.innerHTML = `
                <span
                    class="spinner-border spinner-border-sm me-2"
                    role="status"
                    aria-hidden="true"
                ></span>
                Saving...
            `;

            guestForm.submit();
        });

        /* Remove Validation State While Typing */
        nameInput.addEventListener('input', function () {
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
            }
        });

        phoneInput.addEventListener('input', function () {
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
            }
        });
    }

    /* Delete Guest from guest data view */
    const deleteForms = document.querySelectorAll('.delete-guest-form');
    deleteForms.forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Hapus Tamu?',
                text: 'Data tamu yang dihapus tidak dapat dikembalikan.',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    /* Delete Guest from dashboard */
    document.querySelectorAll('.btn-delete-guest').forEach(function (button) {
        button.addEventListener('click', function () {
            const guestId = this.dataset.id;
            const guestName = this.dataset.name;

            Swal.fire({
                icon: 'warning',
                title: 'Hapus Tamu?',
                text: 'Data tamu yang dihapus tidak dapat dikembalikan.',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(function (result) {

                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${guestId}`).submit();
                }
            });
        });
    });

    // END OF CRUD
    // =======================================
});