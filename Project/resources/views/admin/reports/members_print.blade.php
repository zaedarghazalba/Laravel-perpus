@extends('layouts.report')

@section('content')
<table>
    <thead>
        <tr>
            <th class="text-center" width="50">No</th>
            <th>No. Anggota</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Tgl Bergabung</th>
            <th class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($members as $index => $member)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center"><strong>{{ $member->member_number }}</strong></td>
                <td>{{ $member->name }}</td>
                <td>{{ $member->email }}</td>
                <td>{{ $member->phone }}</td>
                <td>{{ $member->created_at->format('d/m/Y') }}</td>
                <td class="text-center">{{ strtoupper($member->status) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top: 20px;">
    <p><strong>Rekapitulasi Anggota:</strong></p>
    <ul>
        <li>Jumlah Anggota Terdaftar: {{ $members->count() }}</li>
        <li>Anggota Aktif: {{ $members->where('status', 'active')->count() }}</li>
        <li>Anggota Non-Aktif: {{ $members->where('status', 'inactive')->count() }}</li>
    </ul>
</div>
@endsection
