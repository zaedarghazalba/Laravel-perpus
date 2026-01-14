{{-- Barcode Scanner Modal Component --}}
<div id="barcode-scanner-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="scanner-title" role="dialog" aria-modal="true">
    {{-- Overlay --}}
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        {{-- Background overlay --}}
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeBarcodeScanner()"></div>

        {{-- Center modal --}}
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        {{-- Modal panel --}}
        <div class="inline-block w-full align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-white" id="scanner-title">
                            Scan Barcode
                        </h3>
                    </div>
                    <button onclick="closeBarcodeScanner()" type="button" class="text-white hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-white rounded-full p-1 transition-colors" aria-label="Close">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Body --}}
            <div class="bg-white">
                {{-- Camera Preview Area --}}
                <div id="scanner-preview" class="relative">
                    {{-- Status Message --}}
                    <div id="scanner-status" class="bg-indigo-50 px-6 py-3 border-b border-indigo-100">
                        <div class="flex items-center justify-center text-gray-600">
                            <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memuat kamera...
                        </div>
                    </div>

                    {{-- Camera View --}}
                    <div id="reader" class="w-full bg-black"></div>

                    {{-- Help Text --}}
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600 text-center mb-2">
                            <strong>💡 Tips untuk scan berhasil:</strong>
                        </p>
                        <ul class="text-xs text-gray-600 space-y-1 max-w-md mx-auto">
                            <li>✓ Pastikan pencahayaan cukup terang (tidak backlight)</li>
                            <li>✓ Jarak kamera 10-20 cm dari barcode</li>
                            <li>✓ Tahan kamera dengan stabil (jangan goyang)</li>
                            <li>✓ Barcode harus sejajar dengan kamera (tidak miring)</li>
                            <li>✓ <strong>Untuk ISBN:</strong> Arahkan secara horizontal, seluruh barcode harus dalam frame</li>
                            <li>✓ Barcode bersih (tidak lecet, kotor, atau rusak)</li>
                            <li>✓ <strong>Setelah scan:</strong> Cek nomor yang terdeteksi, konfirmasi atau scan ulang jika salah</li>
                        </ul>
                        <p class="text-xs text-gray-500 text-center mt-2">
                            Support: <strong>ISBN (EAN-13)</strong>, QR Code, CODE-128, UPC, dan 10+ format lainnya
                        </p>
                    </div>
                </div>

                {{-- Error Message Area --}}
                <div id="scanner-error" class="hidden px-6 py-8">
                    {{-- Error content will be inserted here by JavaScript --}}
                </div>

                {{-- Manual Input Area --}}
                <div id="scanner-manual" class="hidden px-6 py-6">
                    <div class="mb-4">
                        <label for="manual-barcode-input" class="block text-sm font-medium text-gray-700 mb-2">
                            Atau masukkan barcode secara manual:
                        </label>
                        <input
                            type="text"
                            id="manual-barcode-input"
                            placeholder="Ketik atau paste barcode di sini"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-lg"
                            autocomplete="off"
                            onkeypress="if(event.key === 'Enter') useManualBarcode()"
                        >
                        <p class="mt-2 text-xs text-gray-500">
                            Tekan Enter atau klik tombol "Gunakan Barcode" setelah memasukkan kode
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <button
                            onclick="useManualBarcode()"
                            type="button"
                            class="flex-1 px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 font-semibold transition-colors"
                        >
                            ✓ Gunakan Barcode
                        </button>
                        <button
                            onclick="retryScanning()"
                            type="button"
                            class="px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 font-medium transition-colors"
                        >
                            📷 Coba Scan Lagi
                        </button>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <button
                        onclick="showManualInput()"
                        type="button"
                        class="text-sm text-indigo-600 hover:text-indigo-800 font-medium focus:outline-none focus:underline transition-colors"
                    >
                        ⌨️ Input Manual
                    </button>
                    <button
                        onclick="closeBarcodeScanner()"
                        type="button"
                        class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 font-medium transition-colors"
                    >
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scanner Optimizations --}}
<style>
    /* Reader container */
    #reader {
        min-height: 450px;
        max-height: 600px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    /* Video element - make it fill container properly */
    #reader video {
        border-radius: 0;
        width: 100% !important;
        height: auto !important;
        max-height: 600px;
        object-fit: cover;
    }

    /* Scanner box styling - optimized for 1D barcodes (ISBN/EAN) */
    #reader__scan_region {
        background: rgba(0, 0, 0, 0.5) !important;
    }

    #reader__scan_region img {
        border: 3px solid #22c55e !important;
        box-shadow: 0 0 0 2000px rgba(0, 0, 0, 0.5) !important;
    }

    /* Dashboard (scan region) */
    #reader__dashboard {
        position: absolute !important;
        bottom: 0 !important;
        width: 100% !important;
        background: rgba(0, 0, 0, 0.7) !important;
        padding: 10px !important;
    }

    #reader__dashboard_section {
        color: white !important;
        font-size: 14px !important;
    }

    /* Mobile Optimizations */
    @media (max-width: 640px) {
        #barcode-scanner-modal .sm\:max-w-2xl {
            max-width: 100%;
            margin: 0;
            min-height: 100vh;
            border-radius: 0;
        }

        #reader {
            min-height: 70vh !important;
            max-height: 70vh !important;
        }

        #reader video {
            max-height: 70vh;
        }

        /* Make buttons touch-friendly */
        button {
            min-height: 44px;
        }
    }

    /* Desktop optimizations */
    @media (min-width: 641px) {
        #reader {
            min-height: 500px;
        }
    }
</style>
