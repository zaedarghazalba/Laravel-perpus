/**
 * Barcode Scanner Component
 * Uses html5-qrcode library for camera-based barcode scanning
 * Supports: CODE_128, EAN_13, QR_CODE, and more
 */

class BarcodeScanner {
    constructor() {
        this.html5QrCode = null;
        this.isScanning = false;
        this.targetInputId = null;
        this.onSuccessCallback = null;
        this.modal = null;
        this.cameraId = null;
        this.lastScannedCode = null;
        this.lastScanTime = 0;
    }

    /**
     * Open scanner modal and start camera
     * @param {string} targetInputId - ID of input field to populate with scanned barcode
     * @param {function} onSuccess - Optional callback when scan succeeds
     */
    async open(targetInputId, onSuccess = null) {
        this.targetInputId = targetInputId;
        this.onSuccessCallback = onSuccess;

        // Show modal
        this.modal = document.getElementById('barcode-scanner-modal');
        if (!this.modal) {
            console.error('Barcode scanner modal not found');
            return;
        }

        // Stop any existing scanner first
        await this.stopScanning();

        this.modal.classList.remove('hidden');
        this.resetUI();

        // Start scanning after a short delay to ensure clean state
        setTimeout(() => {
            this.startScanning();
        }, 100);
    }

    /**
     * Close modal and stop camera
     */
    async close() {
        await this.stopScanning();

        if (this.modal) {
            this.modal.classList.add('hidden');
        }

        this.targetInputId = null;
        this.onSuccessCallback = null;
    }

    /**
     * Reset UI to initial state
     */
    resetUI() {
        const previewArea = document.getElementById('scanner-preview');
        const errorArea = document.getElementById('scanner-error');
        const manualArea = document.getElementById('scanner-manual');
        const manualInput = document.getElementById('manual-barcode-input');

        if (previewArea) previewArea.classList.remove('hidden');
        if (errorArea) errorArea.classList.add('hidden');
        if (manualArea) manualArea.classList.add('hidden');
        if (manualInput) manualInput.value = '';

        // Reset reader display
        const reader = document.getElementById('reader');
        if (reader) {
            reader.innerHTML = '';
        }
    }

    /**
     * Start camera and barcode scanning
     */
    async startScanning() {
        if (this.isScanning) return;

        try {
            // Initialize scanner if not exists
            if (!this.html5QrCode) {
                this.html5QrCode = new Html5Qrcode("reader");
            }

            // Get available cameras
            const cameras = await Html5Qrcode.getCameras();

            if (!cameras || cameras.length === 0) {
                this.showError('no-camera');
                return;
            }

            // Use rear camera on mobile, first camera on desktop
            this.cameraId = cameras.length > 1 ? cameras[1].id : cameras[0].id;

            // Configuration optimized for both 1D (ISBN/EAN) and 2D (QR) barcodes
            const config = {
                fps: 10, // Balanced FPS for stability
                qrbox: function(viewfinderWidth, viewfinderHeight) {
                    // For 1D barcodes (ISBN/EAN), use wider rectangle
                    // For 2D barcodes (QR), use square
                    let width = Math.floor(viewfinderWidth * 0.8); // 80% width
                    let height = Math.floor(viewfinderHeight * 0.5); // 50% height

                    // Ensure minimum sizes
                    width = Math.max(250, Math.min(width, 600));
                    height = Math.max(150, Math.min(height, 300));

                    return {
                        width: width,
                        height: height
                    };
                },
                // Support all major barcode formats - prioritize 1D formats first
                formatsToSupport: [
                    Html5QrcodeSupportedFormats.EAN_13,      // ISBN uses EAN-13
                    Html5QrcodeSupportedFormats.EAN_8,       // Short EAN
                    Html5QrcodeSupportedFormats.CODE_128,    // Library barcodes
                    Html5QrcodeSupportedFormats.CODE_39,     // Common barcodes
                    Html5QrcodeSupportedFormats.UPC_A,       // Product barcodes
                    Html5QrcodeSupportedFormats.UPC_E,       // Short UPC
                    Html5QrcodeSupportedFormats.CODE_93,
                    Html5QrcodeSupportedFormats.ITF,
                    Html5QrcodeSupportedFormats.CODABAR,
                    Html5QrcodeSupportedFormats.QR_CODE,     // 2D codes
                    Html5QrcodeSupportedFormats.DATA_MATRIX,
                    Html5QrcodeSupportedFormats.AZTEC,
                    Html5QrcodeSupportedFormats.PDF_417
                ],
                aspectRatio: 1.777778, // 16:9 aspect ratio
                disableFlip: false, // Allow flipped barcodes
                experimentalFeatures: {
                    useBarCodeDetectorIfSupported: true // Use native detector if available
                },
                videoConstraints: {
                    facingMode: { ideal: "environment" },
                    width: { min: 640, ideal: 1280, max: 1920 },
                    height: { min: 480, ideal: 720, max: 1080 },
                    focusMode: { ideal: "continuous" }, // Auto-focus for clearer image
                    whiteBalanceMode: { ideal: "continuous" }
                }
            };

            // Start scanning with multiple format support
            await this.html5QrCode.start(
                this.cameraId,
                config,
                (decodedText, decodedResult) => {
                    console.log('Barcode detected:', decodedText);
                    this.handleScanSuccess(decodedText, decodedResult);
                },
                (errorMessage) => {
                    // Scanning errors are normal, ignore them
                    // They occur when no barcode is in view
                    // Only log serious errors
                    if (errorMessage && !errorMessage.includes('No MultiFormat Readers')) {
                        console.debug('Scan error:', errorMessage);
                    }
                }
            );

            this.isScanning = true;
            console.log('Camera started successfully');
            this.updateScanningStatus('Scanning... Arahkan kamera ke barcode');

        } catch (err) {
            console.error('Error starting scanner:', err);

            const errorMessage = err.message || '';
            const errorName = err.name || '';

            if (errorName === 'NotAllowedError' || errorMessage.includes('Permission')) {
                this.showError('permission-denied');
            } else if (errorName === 'NotReadableError' || errorMessage.includes('busy') || errorMessage.includes('video source')) {
                this.showError('camera-busy');
            } else if (errorMessage.includes('camera') || errorMessage.includes('device')) {
                this.showError('no-camera');
            } else {
                this.showError('general');
            }
        }
    }

    /**
     * Stop camera and scanning
     */
    async stopScanning() {
        if (!this.html5QrCode) return;

        try {
            if (this.isScanning) {
                console.log('Stopping camera...');
                await this.html5QrCode.stop();
                this.isScanning = false;
                console.log('Camera stopped successfully');
            }

            // Clear the scanner state
            const reader = document.getElementById('reader');
            if (reader) {
                reader.innerHTML = '';
            }
        } catch (err) {
            console.error('Error stopping scanner:', err);
            this.isScanning = false;
        }
    }

    /**
     * Handle successful barcode scan
     */
    handleScanSuccess(decodedText, decodedResult) {
        // Prevent multiple rapid scans of the same code
        if (this.lastScannedCode === decodedText && Date.now() - this.lastScanTime < 2000) {
            console.log('Duplicate scan ignored:', decodedText);
            return;
        }

        this.lastScannedCode = decodedText;
        this.lastScanTime = Date.now();

        // Stop scanning immediately
        this.stopScanning();

        // Sanitize barcode (remove special characters except dash and underscore)
        const sanitizedBarcode = decodedText.trim().replace(/[^a-zA-Z0-9\-_]/g, '');

        // Validate barcode length (reasonable range)
        if (sanitizedBarcode.length < 3 || sanitizedBarcode.length > 50) {
            console.warn('Invalid barcode length:', sanitizedBarcode);
            this.showError('general');
            return;
        }

        console.log('Valid barcode scanned:', sanitizedBarcode, '(original:', decodedText + ')');

        // Show confirmation with actual scanned value
        this.showScanConfirmation(sanitizedBarcode, decodedText);
    }

    /**
     * Show scan confirmation to user
     */
    showScanConfirmation(sanitizedBarcode, originalBarcode) {
        const statusEl = document.getElementById('scanner-status');
        const previewArea = document.getElementById('scanner-preview');

        if (statusEl && previewArea) {
            previewArea.classList.add('hidden');
            statusEl.innerHTML = `
                <div class="p-6 bg-white">
                    <div class="text-center mb-4">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Barcode Terdeteksi!</h3>
                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <p class="text-sm text-gray-600 mb-1">Hasil Scan:</p>
                            <p class="text-2xl font-mono font-bold text-indigo-600">${sanitizedBarcode}</p>
                            ${sanitizedBarcode !== originalBarcode ? `<p class="text-xs text-gray-500 mt-1">(Original: ${originalBarcode})</p>` : ''}
                        </div>
                        <p class="text-sm text-gray-600">Apakah barcode ini sudah benar?</p>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="barcodeScanner.confirmScan('${sanitizedBarcode.replace(/'/g, "\\'")}', '${originalBarcode.replace(/'/g, "\\'")}')"
                                class="flex-1 px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold transition-colors">
                            ✓ Ya, Gunakan Barcode Ini
                        </button>
                        <button onclick="barcodeScanner.retryScan()"
                                class="px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-colors">
                            ✕ Scan Ulang
                        </button>
                    </div>
                </div>
            `;
            statusEl.classList.remove('hidden');
        }
    }

    /**
     * Confirm and use the scanned barcode
     */
    confirmScan(sanitizedBarcode, originalBarcode) {
        // Populate target input field
        if (this.targetInputId) {
            const targetInput = document.getElementById(this.targetInputId);
            if (targetInput) {
                targetInput.value = sanitizedBarcode;
                targetInput.dispatchEvent(new Event('input', { bubbles: true }));
            }
        }

        // Show success message
        this.showSuccessMessage(sanitizedBarcode);

        // Call custom callback if provided
        if (this.onSuccessCallback) {
            this.onSuccessCallback(sanitizedBarcode, { decodedText: originalBarcode });
        }

        // Auto-close after 1 second
        setTimeout(() => {
            this.close();
        }, 1000);
    }

    /**
     * Retry scanning
     */
    retryScan() {
        this.resetUI();
        this.lastScannedCode = null;
        this.lastScanTime = 0;
        setTimeout(() => {
            this.startScanning();
        }, 100);
    }

    /**
     * Show success message
     */
    showSuccessMessage(barcode) {
        const statusEl = document.getElementById('scanner-status');
        if (statusEl) {
            statusEl.innerHTML = `
                <div class="flex items-center justify-center text-green-600 font-semibold">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Berhasil! Barcode: ${barcode}
                </div>
            `;
        }
    }

    /**
     * Update scanning status message
     */
    updateScanningStatus(message) {
        const statusEl = document.getElementById('scanner-status');
        if (statusEl) {
            statusEl.innerHTML = `
                <div class="flex items-center justify-center text-gray-600">
                    <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    ${message}
                </div>
            `;
        }
    }

    /**
     * Show error message and manual input option
     */
    showError(errorType) {
        const previewArea = document.getElementById('scanner-preview');
        const errorArea = document.getElementById('scanner-error');
        const manualArea = document.getElementById('scanner-manual');

        if (previewArea) previewArea.classList.add('hidden');
        if (manualArea) manualArea.classList.remove('hidden');

        let errorMessage = '';
        let errorIcon = '⚠️';

        switch(errorType) {
            case 'permission-denied':
                errorMessage = 'Akses kamera ditolak. Silakan aktifkan izin kamera di pengaturan browser Anda.';
                errorIcon = '🚫';
                break;
            case 'no-camera':
                errorMessage = 'Kamera tidak terdeteksi. Silakan gunakan input manual.';
                errorIcon = '📷';
                break;
            case 'camera-busy':
                errorMessage = 'Kamera sedang digunakan oleh aplikasi lain atau browser tab lain. Tutup aplikasi/tab tersebut, refresh halaman ini, dan coba lagi.';
                errorIcon = '⏸️';
                break;
            default:
                errorMessage = 'Terjadi kesalahan saat mengakses kamera. Silakan gunakan input manual.';
        }

        if (errorArea) {
            errorArea.innerHTML = `
                <div class="text-center p-6">
                    <div class="text-6xl mb-4">${errorIcon}</div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Kamera Tidak Tersedia</h3>
                    <p class="text-gray-600">${errorMessage}</p>
                </div>
            `;
            errorArea.classList.remove('hidden');
        }
    }

    /**
     * Use manually entered barcode
     */
    useManualBarcode() {
        const manualInput = document.getElementById('manual-barcode-input');
        if (!manualInput || !manualInput.value.trim()) {
            alert('Silakan masukkan barcode');
            return;
        }

        const barcode = manualInput.value.trim();
        const sanitizedBarcode = barcode.replace(/[^a-zA-Z0-9\-_]/g, '');

        // Populate target input
        if (this.targetInputId) {
            const targetInput = document.getElementById(this.targetInputId);
            if (targetInput) {
                targetInput.value = sanitizedBarcode;
                targetInput.dispatchEvent(new Event('input', { bubbles: true }));
            }
        }

        // Call callback
        if (this.onSuccessCallback) {
            this.onSuccessCallback(sanitizedBarcode);
        }

        this.close();
    }

    /**
     * Switch to manual input mode
     */
    async showManualInput() {
        await this.stopScanning();

        const previewArea = document.getElementById('scanner-preview');
        const manualArea = document.getElementById('scanner-manual');

        if (previewArea) previewArea.classList.add('hidden');
        if (manualArea) manualArea.classList.remove('hidden');

        // Focus on manual input
        const manualInput = document.getElementById('manual-barcode-input');
        if (manualInput) {
            setTimeout(() => manualInput.focus(), 100);
        }
    }

    /**
     * Retry scanning
     */
    async retry() {
        await this.stopScanning();
        this.resetUI();
        setTimeout(() => {
            this.startScanning();
        }, 100);
    }
}

// Global instance
let barcodeScanner = null;

/**
 * Initialize barcode scanner (called once when page loads)
 */
function initBarcodeScanner() {
    if (!barcodeScanner) {
        barcodeScanner = new BarcodeScanner();
    }
}

/**
 * Open barcode scanner for a specific input field
 * @param {string} inputId - ID of the input field to populate
 * @param {function} callback - Optional callback function
 */
function openBarcodeScanner(inputId, callback = null) {
    if (!barcodeScanner) {
        initBarcodeScanner();
    }
    barcodeScanner.open(inputId, callback);
}

/**
 * Close barcode scanner
 */
function closeBarcodeScanner() {
    if (barcodeScanner) {
        barcodeScanner.close();
    }
}

/**
 * Use manual barcode input
 */
function useManualBarcode() {
    if (barcodeScanner) {
        barcodeScanner.useManualBarcode();
    }
}

/**
 * Show manual input mode
 */
function showManualInput() {
    if (barcodeScanner) {
        barcodeScanner.showManualInput();
    }
}

/**
 * Retry scanning
 */
function retryScanning() {
    if (barcodeScanner) {
        barcodeScanner.retry();
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initBarcodeScanner);
} else {
    initBarcodeScanner();
}

// Cleanup on page unload
window.addEventListener('beforeunload', () => {
    if (barcodeScanner) {
        barcodeScanner.close();
    }
});

// Note: Visibility change handler disabled to prevent camera from stopping unexpectedly
// The modal close() method already handles camera cleanup properly
// document.addEventListener('visibilitychange', () => {
//     if (document.hidden && barcodeScanner && barcodeScanner.isScanning) {
//         barcodeScanner.stopScanning();
//     }
// });
