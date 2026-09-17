// Hardware Barcode Scanner & Camera device function
// =======================================

import { Html5Qrcode } from 'html5-qrcode'; // HTML5 QRCode (install via npm)

/* Camera device */
let html5QrCode = null;
let cameraScanning = false;

/* Start Camera device */
async function startCameraScanner() {
    if (cameraScanning) {
        return;
    }

    try {
        html5QrCode = new Html5Qrcode('qrReader');
        const cameras = await Html5Qrcode.getCameras();

        if (!cameras || cameras.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Kamera Tidak Ditemukan',
                text: 'Tidak ada kamera yang tersedia pada perangkat ini.'
            });

            return;
        }

        const cameraId = cameras[0].id;

        await html5QrCode.start(
            cameraId,
            {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            },
            function (decodedText) {
                handleCameraScan(decodedText);
            },
            function () {
                // QR belum terbaca.
                // Tidak perlu menampilkan error.
            }
        );

        cameraScanning = true;

    } catch (error) {
        console.error('Camera scanner error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Kamera Tidak Dapat Digunakan',
            text: 'Pastikan browser memiliki izin untuk menggunakan kamera.'
        });
    }
}

/* Handle Camera device (browser) */
function handleCameraScan(decodedText) {
    const qrCode = decodedText.trim();

    if (!qrCode) {
        return;
    }

    lookupGuest(qrCode);
}

/* Stop Camera Scanner (if browser permission got reject from user) */
async function stopCameraScanner() {
    if (!html5QrCode || !cameraScanning) {
        return;
    }

    try {
        await html5QrCode.stop();
        html5QrCode.clear();
        cameraScanning = false;

    } catch (error) {
        console.error('Failed to stop camera scanner:', error);
    }
}

/* Hardware QR Scanner */
const hardwareMode = document.getElementById('hardwareMode');
const cameraMode = document.getElementById('cameraMode');
const hardwareScanner = document.getElementById('hardwareScanner');
const cameraScanner = document.getElementById('cameraScanner');
const qrScannerInput = document.getElementById('qrScannerInput');
const scanResult = document.getElementById('scanResult');
const scanResultValue = document.getElementById('scanResultValue');

/* Hardware Scanner Input */
if (qrScannerInput) {
    qrScannerInput.focus();
    qrScannerInput.addEventListener('keydown', function (event) {
        if (event.key !== 'Enter') {
            return;
        }

        event.preventDefault();
        const qrCode = this.value.trim();

        if (!qrCode) {
            return;
        }

        this.value = '';
        this.focus();
        lookupGuest(qrCode);
    });
}

/* Hardware Mode */
if (hardwareMode) {
    hardwareMode.addEventListener('click', async function () {
        await stopCameraScanner();
        hardwareMode.classList.remove('btn-outline-primary');
        hardwareMode.classList.add('btn-primary');
        cameraMode.classList.remove('btn-primary');
        cameraMode.classList.add('btn-outline-primary');
        hardwareScanner.classList.remove('d-none');
        cameraScanner.classList.add('d-none');
        qrScannerInput.focus();
    });
}

/* Camera Mode */
if (cameraMode) {
    cameraMode.addEventListener('click', async function () {
        cameraMode.classList.remove('btn-outline-primary');
        cameraMode.classList.add('btn-primary');
        hardwareMode.classList.remove('btn-primary');
        hardwareMode.classList.add('btn-outline-primary');
        cameraScanner.classList.remove('d-none');
        hardwareScanner.classList.add('d-none');
        await startCameraScanner();
    });
}

// END OF SOURCE CODE
// =======================================

// Lookup, Display, Check In Guest
// =======================================

// Guest function
// =======================================

/* Lookup Guest */
async function lookupGuest(qrCode) {
    try {
        const response = await fetch('/scan/lookup', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },
            body: JSON.stringify({
                qr_code: qrCode
            })
        });

        const data = await response.json();
        if (!response.ok) {
            Swal.fire({
                icon: 'error',
                title: 'QR Tidak Terdaftar',
                text: data.message || 'QR Code tidak ditemukan.'
            });

            return;
        }
        
        displayGuest(data.guest);
    } catch (error) {
        console.error('Lookup error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: 'Data tamu tidak dapat diperiksa.'
        });
    }
}

/* Display Guest */
function displayGuest(guest) {
    currentGuestQrCode = guest.qr_code;
    document.getElementById('guestName').textContent = guest.name || '-';
    document.getElementById('guestPhone').textContent = guest.no_hp || '-';
    document.getElementById('guestAddress').textContent = guest.address || '-';
    document.getElementById('scanResultValue').textContent = guest.qr_code;
    document.getElementById('guestStatus').innerHTML = getGuestStatusBadge(guest.status);
    scanResult.classList.remove('d-none');
    updateCheckInButton(guest.status);
}

/* Guest Status Badge */
function getGuestStatusBadge(status) {
    if (status === 'checked_in') {
        return `
            <span class="badge text-bg-success">
                Checked In
            </span>
        `;
    }

    return `
        <span class="badge text-bg-secondary">
            Pending
        </span>
    `;
}

/* Check In function button */
function updateCheckInButton(status) {
    if (!checkInButton) {
        return;
    }

    if (status === 'checked_in') {
        checkInButton.disabled = true;
        checkInButton.classList.remove('btn-success');
        checkInButton.classList.add('btn-secondary');
        checkInButton.innerHTML = `
            <i class="fa-solid fa-circle-check me-2"></i>
            Sudah Check-in
        `;

        return;
    }

    checkInButton.disabled = false;
    checkInButton.classList.remove('btn-secondary');
    checkInButton.classList.add('btn-success');
    checkInButton.innerHTML = `
        <i class="fa-solid fa-check me-2"></i>
        Check-in Tamu
    `;
}

// END OF SOURCE CODE - Guest function
// =======================================

/* Check-in Guest */
const checkInButton = document.getElementById('checkInButton');
let currentGuestQrCode = null;

if (checkInButton) {
    checkInButton.addEventListener('click', function () {
        if (!currentGuestQrCode) {
            return;
        }

        Swal.fire({
            icon: 'question',
            title: 'Check-in Tamu?',
            text: 'Pastikan data tamu sudah benar.',
            showCancelButton: true,
            confirmButtonText: 'Ya, Check-in',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then(async function (result) {
            if (!result.isConfirmed) {
                return;
            }

            checkInButton.disabled = true;
            checkInButton.innerHTML = `
                <span
                    class="spinner-border spinner-border-sm me-2"
                    role="status"
                    aria-hidden="true"
                ></span>
                Processing...
            `;

            try {
                const response = await fetch('/scan/check-in', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },

                    body: JSON.stringify({
                        qr_code: currentGuestQrCode
                    })

                });

                const data = await response.json();

                if (!response.ok) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Check-in Gagal',
                        text: data.message || 'Tamu tidak dapat melakukan check-in.'
                    });

                    updateCheckInButton(data.guest?.status || 'pending');
                    return;
                }

                document.getElementById('guestStatus').innerHTML = getGuestStatusBadge('checked_in');
                updateCheckInButton('checked_in');

                Swal.fire({
                    icon: 'success',
                    title: 'Check-in Berhasil!',
                    text: `${data.guest.name} berhasil melakukan check-in.`,
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            } catch (error) {
                console.error('Check-in error:', error);

                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Proses check-in tidak dapat dilakukan.'
                });

                updateCheckInButton('pending');
            }
        });
    });
}

// END OF SOURCE CODE
// =======================================