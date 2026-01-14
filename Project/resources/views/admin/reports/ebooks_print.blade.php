@extends('layouts.report')

@section('content')
<table>
    <thead>
        <tr>
            <th class="text-center" width="50">No</th>
            <th>Judul E-Book</th>
            <th>Penulis</th>
            <th>Kategori</th>
            <th class="text-center">Tahun</th>
            <th class="text-center">Views</th>
            <th class="text-center">Downloads</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ebooks as $index => $ebook)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $ebook->title }}</td>
                <td>{{ $ebook->author }}</td>
                <td>{{ $ebook->category->name }}</td>
                <td class="text-center">{{ $ebook->publication_year }}</td>
                <td class="text-center">{{ number_format($ebook->view_count) }}</td>
                <td class="text-center">{{ number_format($ebook->download_count) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top: 20px;">
    <p><strong>Statistik Digital:</strong></p>
    <ul>
        <li>Total Koleksi E-Book: {{ $ebooks->count() }}</li>
        <li>Total Akses (Views): {{ number_format($ebooks->sum('view_count')) }}</li>
        <li>Total Unduhan: {{ number_format($ebooks->sum('download_count')) }}</li>
    </ul>
</div>
@endsection
