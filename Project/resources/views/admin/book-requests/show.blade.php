@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('admin.book-requests.index') }}" class="text-indigo-600 hover:text-indigo-800 mb-2 inline-block">
                ← Kembali ke Daftar
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Detail Permintaan Buku</h1>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Request Details -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gray-50 border-b">
                <h2 class="text-lg font-semibold text-gray-900">Informasi Permintaan</h2>
            </div>
            <div class="px-6 py-4 space-y-4">
                <!-- Title -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">Judul Buku</div>
                    <div class="col-span-2 text-sm text-gray-900 font-semibold">{{ $bookRequest->title }}</div>
                </div>

                <!-- Author -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">Penulis</div>
                    <div class="col-span-2 text-sm text-gray-900">{{ $bookRequest->author ?? '-' }}</div>
                </div>

                <!-- Publisher -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">Penerbit</div>
                    <div class="col-span-2 text-sm text-gray-900">{{ $bookRequest->publisher ?? '-' }}</div>
                </div>

                <!-- ISBN -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">ISBN</div>
                    <div class="col-span-2 text-sm text-gray-900">{{ $bookRequest->isbn ?? '-' }}</div>
                </div>

                <!-- Request Type -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">Jenis Permintaan</div>
                    <div class="col-span-2">
                        <span class="px-2 py-1 text-xs rounded-full {{ $bookRequest->request_type == 'book' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ $bookRequest->request_type_label }}
                        </span>
                    </div>
                </div>

                <!-- Description -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">Keterangan</div>
                    <div class="col-span-2 text-sm text-gray-900">{{ $bookRequest->description ?? '-' }}</div>
                </div>

                <!-- Status -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">Status</div>
                    <div class="col-span-2">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $bookRequest->status_badge }}">
                            {{ $bookRequest->status_label }}
                        </span>
                    </div>
                </div>

                <!-- Request Date -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">Tanggal Permintaan</div>
                    <div class="col-span-2 text-sm text-gray-900">{{ $bookRequest->created_at->format('d F Y H:i') }}</div>
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gray-50 border-b">
                <h2 class="text-lg font-semibold text-gray-900">Informasi Pengguna</h2>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">Nama</div>
                    <div class="col-span-2 text-sm text-gray-900">{{ $bookRequest->user->name }}</div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-sm font-medium text-gray-500">Email</div>
                    <div class="col-span-2 text-sm text-gray-900">{{ $bookRequest->user->email }}</div>
                </div>
            </div>
        </div>

        <!-- Processing Info (if processed) -->
        @if($bookRequest->processed_at)
            <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h2 class="text-lg font-semibold text-gray-900">Informasi Pemrosesan</h2>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-sm font-medium text-gray-500">Diproses Oleh</div>
                        <div class="col-span-2 text-sm text-gray-900">{{ $bookRequest->processor->name ?? '-' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-sm font-medium text-gray-500">Tanggal Diproses</div>
                        <div class="col-span-2 text-sm text-gray-900">{{ $bookRequest->processed_at->format('d F Y H:i') }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-sm font-medium text-gray-500">Catatan Admin</div>
                        <div class="col-span-2 text-sm text-gray-900">{{ $bookRequest->admin_note ?? '-' }}</div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Actions (if pending) -->
        @if($bookRequest->status == 'pending')
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h2 class="text-lg font-semibold text-gray-900">Tindakan</h2>
                </div>
                <div class="px-6 py-6 space-y-4">
                    <!-- Approve -->
                    <form action="{{ route('admin.book-requests.approve', $bookRequest) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="approve_note" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan (Opsional)
                            </label>
                            <textarea
                                name="admin_note"
                                id="approve_note"
                                rows="3"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                placeholder="Tambahkan catatan untuk persetujuan..."
                            ></textarea>
                        </div>
                        <button
                            type="submit"
                            class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition"
                        >
                            ✓ Setujui Permintaan
                        </button>
                    </form>

                    <hr class="my-4">

                    <!-- Reject -->
                    <form action="{{ route('admin.book-requests.reject', $bookRequest) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="reject_note" class="block text-sm font-medium text-gray-700 mb-2">
                                Alasan Penolakan <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                name="admin_note"
                                id="reject_note"
                                rows="3"
                                required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                                placeholder="Jelaskan alasan penolakan permintaan..."
                            ></textarea>
                        </div>
                        <button
                            type="submit"
                            class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition"
                        >
                            ✗ Tolak Permintaan
                        </button>
                    </form>
                </div>
            </div>
        @elseif($bookRequest->status == 'approved')
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h2 class="text-lg font-semibold text-gray-900">Tandai sebagai Terpenuhi</h2>
                </div>
                <div class="px-6 py-6">
                    <form action="{{ route('admin.book-requests.fulfill', $bookRequest) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="fulfill_note" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan (Opsional)
                            </label>
                            <textarea
                                name="admin_note"
                                id="fulfill_note"
                                rows="3"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Tambahkan catatan (contoh: Buku sudah ditambahkan ke koleksi)"
                            ></textarea>
                        </div>
                        <button
                            type="submit"
                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
                        >
                            ✓ Tandai sebagai Terpenuhi
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <!-- Delete Action (for any status except pending) -->
        @if($bookRequest->status != 'pending')
            <div class="mt-6">
                <form action="{{ route('admin.book-requests.destroy', $bookRequest) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus permintaan ini?')">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition"
                    >
                        Hapus Permintaan
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
