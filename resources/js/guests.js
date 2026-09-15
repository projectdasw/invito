document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Guest Search & Filter
    |--------------------------------------------------------------------------
    */

    const searchInput = document.getElementById('searchGuest');
    const filterStatus = document.getElementById('filterStatus');

    function filterGuests() {

        const search = searchInput
            ? searchInput.value.toLowerCase().trim()
            : '';

        const status = filterStatus
            ? filterStatus.value
            : '';

        const rows = document.querySelectorAll(
            '#guestTable tr[data-name]'
        );

        rows.forEach(function (row) {

            const name = row.dataset.name;
            const guestStatus = row.dataset.status;

            const matchName = name.includes(search);

            const matchStatus =
                status === '' || guestStatus === status;

            row.style.display =
                matchName && matchStatus
                    ? ''
                    : 'none';

        });
    }

    if (searchInput) {
        searchInput.addEventListener(
            'input',
            filterGuests
        );
    }

    if (filterStatus) {
        filterStatus.addEventListener(
            'change',
            filterGuests
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Guest
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '.btn-delete-guest'
    ).forEach(function (button) {

        button.addEventListener('click', function () {

            const guestId = this.dataset.id;
            const guestName = this.dataset.name;

            Swal.fire({
                title: 'Hapus tamu?',
                text: `Data "${guestName}" akan dihapus.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(function (result) {

                if (result.isConfirmed) {

                    document
                        .getElementById(
                            `delete-form-${guestId}`
                        )
                        .submit();

                }

            });

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Add Guest Validation
    |--------------------------------------------------------------------------
    */

    const guestForm = document.getElementById('guestForm');

    if (guestForm) {

        const nameInput = document.getElementById('name');
        const saveButton = document.getElementById('saveGuestButton');

        guestForm.addEventListener('submit', function (event) {

            let isValid = true;

            if (!nameInput.value.trim()) {

                nameInput.classList.add('is-invalid');

                isValid = false;

            } else {

                nameInput.classList.remove('is-invalid');

            }


            if (!isValid) {

                event.preventDefault();

                return;

            }


            saveButton.disabled = true;

            saveButton.innerHTML = `
                <span
                    class="spinner-border spinner-border-sm me-2"
                    role="status"
                    aria-hidden="true"
                ></span>
                Saving...
            `;

        });


        nameInput.addEventListener('input', function () {

            if (this.value.trim()) {
                this.classList.remove('is-invalid');
            }

        });

    }

});