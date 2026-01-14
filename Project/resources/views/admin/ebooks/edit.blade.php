@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Edit Ebook</h2>
            <a href="{{ route('admin.ebooks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>

        <form action="{{ route('admin.ebooks.update', $ebook) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Ebook *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $ebook->title) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700">Penulis *</label>
                    <input type="text" name="author" id="author" value="{{ old('author', $ebook->author) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('author') border-red-500 @enderror">
                    @error('author')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="publisher" class="block text-sm font-medium text-gray-700">Penerbit</label>
                    <input type="text" name="publisher" id="publisher" value="{{ old('publisher', $ebook->publisher) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('publisher') border-red-500 @enderror">
                    @error('publisher')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN</label>
                    <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $ebook->isbn) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('isbn') border-red-500 @enderror">
                    @error('isbn')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="publication_year" class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
                    <input type="number" name="publication_year" id="publication_year" value="{{ old('publication_year', $ebook->publication_year) }}" min="1000" max="{{ date('Y') + 1 }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('publication_year') border-red-500 @enderror">
                    @error('publication_year')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori *</label>
                    <select name="category_id" id="category_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('category_id') border-red-500 @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $ebook->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="cover_image" class="block text-sm font-medium text-gray-700">Cover Ebook</label>

                    @if($ebook->cover_image)
                        <div class="mt-2 mb-3">
                            <img src="{{ asset($ebook->cover_image) }}" alt="{{ $ebook->title }}" class="h-32 w-24 object-cover rounded shadow">
                            <p class="text-xs text-gray-500 mt-1">Cover saat ini</p>
                        </div>
                    @endif

                    <input type="file" name="cover_image" id="cover_image" accept="image/jpeg,image/jpg,image/png"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('cover_image') border-red-500 @enderror">
                    @error('cover_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        @if($ebook->cover_image)
                            Upload gambar baru untuk mengganti cover
                        @else
                            Format: JPG, JPEG, PNG. Maksimal 2MB
                        @endif
                    </p>
                </div>

                <div>
                    <label for="file_path" class="block text-sm font-medium text-gray-700">File PDF</label>

                    @if($ebook->file_path)
                        <div class="mt-2 mb-3 bg-gray-50 p-3 rounded">
                            <div class="flex items-center">
                                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">File PDF saat ini</p>
                                    <p class="text-xs text-gray-500">{{ basename($ebook->file_path) }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ number_format($ebook->view_count) }} views | {{ number_format($ebook->download_count) }} downloads
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <input type="file" name="file_path" id="file_path" accept="application/pdf"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 @error('file_path') border-red-500 @enderror">
                    @error('file_path')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        @if($ebook->file_path)
                            Upload file baru untuk mengganti PDF. Kosongkan jika tidak ingin mengganti.
                        @else
                            Format: PDF. Maksimal 20MB
                        @endif
                    </p>
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="description" id="description" rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $ebook->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $ebook->is_published) ? 'checked' : '' }}
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="is_published" class="ml-2 block text-sm text-gray-900">
                            Publikasikan ebook (centang untuk membuat ebook dapat diakses publik)
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.ebooks.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Batal
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
