@extends('layouts.report')

@section('content')
<table>
    <thead>
        <tr>
            <th class="text-center" width="50">No</th>
            <th>Judul Buku</th>
            <th>Penulis</th>
            <th>ISBN</th>
            <th>Klasifikasi</th>
            <th>Kategori</th>
            <th class="text-center">Stok</th>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $index => $book)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->isbn }}</td>
                <td>{{ $book->classification_code }}</td>
                <td>{{ $book->category->name }}</td>
                <td class="text-center">{{ $book->quantity }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top: 20px;">
    <p><strong>Ringkasan:</strong></p>
    <ul>
        <li>Total Judul: {{ $books->count() }}</li>
        <li>Total Eksemplar: {{ $books->sum('quantity') }}</li>
    </ul>
</div>
@endsection
