@extends('layouts.report')

@section('content')
<table>
    <thead>
        <tr>
            <th class="text-center" width="40">No</th>
            <th>Buku</th>
            <th>Peminjam</th>
            <th class="text-center">Tgl Pinjam</th>
            <th class="text-center">Jatuh Tempo</th>
            <th class="text-center">Tgl Kembali</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($borrowings as $index => $borrowing)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $borrowing->book->title }}</td>
                <td>{{ $borrowing->member->name }}<br><small>({{ $borrowing->member->member_number }})</small></td>
                <td class="text-center">{{ $borrowing->borrow_date->format('d/m/Y') }}</td>
                <td class="text-center">{{ $borrowing->due_date->format('d/m/Y') }}</td>
                <td class="text-center">{{ $borrowing->return_date ? $borrowing->return_date->format('d/m/Y') : '-' }}</td>
                <td>{{ strtoupper($borrowing->status) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top: 20px;">
    <p><strong>Ringkasan Transaksi:</strong></p>
    <ul>
        <li>Total Transaksi: {{ $borrowings->count() }}</li>
        <li>Buku Kembali: {{ $borrowings->where('status', 'returned')->count() }}</li>
        <li>Buku Masih Dipinjam: {{ $borrowings->where('status', 'borrowed')->count() }}</li>
    </ul>
</div>
@endsection
