<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $ebook->title }} - Reader</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                margin: 0;
                padding: 0;
                overflow: hidden;
            }

            #pdf-container {
                width: 100vw;
                height: 100vh;
                display: flex;
                flex-direction: column;
            }

            #pdf-toolbar {
                background-color: #1f2937;
                color: white;
                padding: 0.75rem 1rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            #pdf-viewer {
                flex: 1;
                width: 100%;
                border: none;
            }

            .toolbar-btn {
                background-color: #4f46e5;
                color: white;
                padding: 0.5rem 1rem;
                border-radius: 0.375rem;
                font-size: 0.875rem;
                font-weight: 500;
                cursor: pointer;
                border: none;
                transition: background-color 0.15s;
            }

            .toolbar-btn:hover {
                background-color: #4338ca;
            }

            .toolbar-title {
                font-size: 1.125rem;
                font-weight: 600;
                max-width: 60%;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            @media (max-width: 768px) {
                .toolbar-title {
                    font-size: 0.875rem;
                    max-width: 40%;
                }
            }
        </style>
    </head>
    <body>
        <div id="pdf-container">
            <!-- Toolbar -->
            <div id="pdf-toolbar">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('ebooks.show', $ebook) }}" class="toolbar-btn">
                        <svg class="h-5 w-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                    <div class="toolbar-title">{{ $ebook->title }}</div>
                </div>

                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-300 hidden md:inline">{{ $ebook->author }}</span>
                    <a href="{{ route('ebooks.download', $ebook) }}" class="toolbar-btn">
                        <svg class="h-5 w-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span class="hidden md:inline">Unduh</span>
                    </a>
                </div>
            </div>

            <!-- PDF Viewer - Served securely with authorization check -->
            <iframe id="pdf-viewer" src="{{ route('files.ebook.view', $ebook) }}#toolbar=1&navpanes=1&scrollbar=1" type="application/pdf"></iframe>
        </div>

        <script>
            // Handle keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // ESC to go back
                if (e.key === 'Escape') {
                    window.location.href = "{{ route('ebooks.show', $ebook) }}";
                }
            });

            // Fallback for browsers that don't support PDF in iframe
            window.addEventListener('load', function() {
                const iframe = document.getElementById('pdf-viewer');

                iframe.onerror = function() {
                    const container = document.getElementById('pdf-container');
                    container.innerHTML = `
                        <div class="flex items-center justify-center h-screen bg-gray-100">
                            <div class="text-center p-8">
                                <svg class="h-24 w-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">Browser tidak mendukung PDF Viewer</h2>
                                <p class="text-gray-600 mb-6">Silakan unduh file PDF untuk membacanya.</p>
                                <a href="{{ route('ebooks.download', $ebook) }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Unduh PDF
                                </a>
                                <div class="mt-4">
                                    <a href="{{ route('ebooks.show', $ebook) }}" class="text-indigo-600 hover:text-indigo-700">
                                        ← Kembali ke Detail Ebook
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                };
            });
        </script>
    </body>
</html>
