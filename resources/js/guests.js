document.addEventListener('DOMContentLoaded', function () {
    // CRUD, Alert Message, Search Filter
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

    // END OF SOURCE CODE
    // =======================================

    // Download & Print QRCode Function
    // =======================================

    /* Download QR Code */
    const downloadQrButton = document.getElementById('downloadQrCode');
    if (downloadQrButton) {
        downloadQrButton.addEventListener('click', function () {
            const qrContainer = document.getElementById('guestQrCode');
            const svg = qrContainer.querySelector('svg');

            if (!svg) {
                return;
            }

            const filename = this.dataset.filename;
            const serializer = new XMLSerializer();
            const svgData = serializer.serializeToString(svg);
            const svgBlob = new Blob(
                [svgData],
                {
                    type: 'image/svg+xml;charset=utf-8'
                }
            );
            const url = URL.createObjectURL(svgBlob);
            const image = new Image();

            image.onload = function () {
                const canvas = document.createElement('canvas');
                const size = 1000;
                canvas.width = size;
                canvas.height = size;
                const context = canvas.getContext('2d');
                context.fillStyle = '#ffffff';
                context.fillRect(0, 0, size, size);
                context.drawImage(
                    image,
                    0,
                    0,
                    size,
                    size
                );

                URL.revokeObjectURL(url);
                const downloadLink = document.createElement('a');
                downloadLink.download = filename;
                downloadLink.href = canvas.toDataURL('image/png');
                downloadLink.click();
            };

            image.src = url;
        });
    }

    /* Print QR Code */
    const printQrButton = document.getElementById('printQrCode');
    if (printQrButton) {
        printQrButton.addEventListener('click', function () {
            const printArea = document.getElementById('printQrArea');

            if (!printArea) {
                return;
            }

            const printWindow = window.open(
                '',
                '_blank',
                'width=600,height=700'
            );

            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                    <head>
                        <title>Print QR Code</title>
                        <style>
                            body {
                                margin: 0;
                                padding: 40px;
                                font-family: Arial, sans-serif;
                            }

                            .print-container {
                                text-align: center;
                            }

                            h4 {
                                font-size: 24px;
                                margin-bottom: 20px;
                            }

                            svg {
                                width: 300px;
                                height: 300px;
                            }

                            .qr-code {
                                margin-top: 15px;
                                font-size: 16px;
                                font-weight: 600;
                            }

                            @media print {
                                body {
                                    padding: 20px;
                                }
                            }
                        </style>

                    </head>
                    <body>
                        <div class="print-container">
                            ${printArea.innerHTML}
                        </div>
                    </body>
                </html>
            `);

            printWindow.document.close();
            printWindow.focus();
            printWindow.onload = function () {
                printWindow.print();
                printWindow.close();
            };
        });
    }
    
    // END OF SOURCE CODE
    // =======================================
});