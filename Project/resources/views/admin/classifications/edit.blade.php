@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Klasifikasi</h2>
            <p class="mt-1 text-sm text-gray-600">Perbarui informasi klasifikasi DDC</p>
        </div>
        <a href="{{ route('admin.classifications.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        <div class="p-8">
            <form action="{{ route('admin.classifications.update', $classification) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Kode -->
                <div>
                    <label for="code" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kode DDC <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="code" id="code" value="{{ old('code', $classification->code) }}" required
                           placeholder="Contoh: 005 atau 005.1"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-opacity-50 focus:border-transparent transition-all @error('code') border-red-500 @enderror"
                           style="focus:ring-color: #007FFF;">
                    @error('code')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">Masukkan kode DDC sesuai standar (contoh: 000, 005, 005.1, 005.13)</p>
                </div>

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Klasifikasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $classification->name) }}" required
                           placeholder="Contoh: Pemrograman Komputer"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-opacity-50 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                           style="focus:ring-color: #007FFF;">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi (Opsional)
                    </label>
                    <textarea name="description" id="description" rows="4"
                              placeholder="Deskripsi singkat tentang klasifikasi ini..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-opacity-50 focus:border-transparent transition-all @error('description') border-red-500 @enderror"
                              style="focus:ring-color: #007FFF;">{{ old('description', $classification->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Level -->
                <div>
                    <label for="level" class="block text-sm font-semibold text-gray-700 mb-2">
                        Level <span class="text-red-500">*</span>
                    </label>
                    <select name="level" id="level" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-opacity-50 focus:border-transparent transition-all @error('level') border-red-500 @enderror"
                            style="focus:ring-color: #007FFF;">
                        <option value="">Pilih Level</option>
                        <option value="1" {{ old('level', $classification->level) == '1' ? 'selected' : '' }}>Level 1 - Kelas Utama (000, 100, 200, ...)</option>
                        <option value="2" {{ old('level', $classification->level) == '2' ? 'selected' : '' }}>Level 2 - Divisi (010, 020, 030, ...)</option>
                        <option value="3" {{ old('level', $classification->level) == '3' ? 'selected' : '' }}>Level 3 - Seksi (005, 015, 025, ...)</option>
                        <option value="4" {{ old('level', $classification->level) == '4' ? 'selected' : '' }}>Level 4 - Spesifik (005.1, 005.2, ...)</option>
                    </select>
                    @error('level')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Parent Classification -->
                <div>
                    <label for="parent_code" class="block text-sm font-semibold text-gray-700 mb-2">
                        Klasifikasi Parent (Opsional)
                    </label>
                    <select name="parent_code" id="parent_code"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-opacity-50 focus:border-transparent transition-all @error('parent_code') border-red-500 @enderror"
                            style="focus:ring-color: #007FFF;">
                        <option value="">Tidak Ada Parent</option>
                        @foreach($parentClassifications as $parent)
                            <option value="{{ $parent->code }}" {{ old('parent_code', $classification->parent_code) == $parent->code ? 'selected' : '' }}>
                                {{ $parent->code }} - {{ $parent->name }} (Level {{ $parent->level }})
                            </option>
                        @endforeach
                    </select>
                    @error('parent_code')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">Pilih parent untuk membuat hierarki klasifikasi</p>
                </div>

                <!-- Current Parent Info (if exists) -->
                @if($classification->parent)
                    <div class="rounded-lg p-4 bg-gray-50 border border-gray-200">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Parent Saat Ini:</p>
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 text-sm font-bold rounded-lg text-white" style="background-color: #007FFF;">
                                {{ $classification->parent->code }}
                            </span>
                            <span class="text-sm text-gray-700">{{ $classification->parent->name }}</span>
                        </div>
                    </div>
                @endif

                <!-- Info Box -->
                <div class="rounded-lg p-4 border-l-4" style="background-color: #E6F3FF; border-color: #007FFF;">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5" style="color: #007FFF;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-semibold" style="color: #007FFF;">Contoh Klasifikasi DDC:</p>
                            <ul class="mt-2 text-sm text-gray-700 space-y-1 list-disc list-inside">
                                <li>000 - Ilmu Komputer, Informasi & Karya Umum (Level 1)</li>
                                <li>004 - Pemrosesan Data & Ilmu Komputer (Level 2, Parent: 000)</li>
                                <li>005 - Pemrograman Komputer (Level 3, Parent: 004)</li>
                                <li>005.1 - Programming Languages (Level 4, Parent: 005)</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.classifications.index') }}"
                       class="px-6 py-3 text-sm font-semibold text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all duration-200">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-3 text-sm font-semibold text-white rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200"
                            style="background-color: #007FFF;">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Klasifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
