@extends('layout.index')

@section('content')
    <div class="container">
        <h3>Daftar Absensi Siswa</h3>

        <form action="{{ url()->current() }}" method="GET" class="mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="filter_nama_siswa" class="form-label">Nama Siswa</label>
                    <input type="text" class="form-control border p-2" id="filter_nama_siswa" name="nama_siswa"
                        value="{{ request('nama_siswa') }}" placeholder="Cari Nama Siswa...">
                </div>
                <div class="col-md-3">
                    <label for="filter_tanggal" class="form-label">Tanggal Kegiatan</label>
                    <input type="date" class="form-control border p-2" id="filter_tanggal" name="tanggal"
                        value="{{ request('tanggal') }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ url()->current() }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-striped align-items-center mb-0">
            <thead>
                <tr>
                    <th class="align-middle text-center text-sm">No</th>
                    <th class="align-middle text-center text-sm">Nama Siswa</th>
                    <th class="align-middle text-center text-sm">Jam mulai - akhir</th>
                    <th class="align-middle text-center text-sm">Tanggal Absen</th>
                    <th class="align-middle text-center text-sm">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($absensis as $a)
                    <tr>
                        <td class="align-middle text-center text-sm">{{ $loop->iteration }}</td>
                        <td class="align-middle text-center text-sm">{{ $a->siswa->user->name }}</td>
                        <td class="align-middle text-center text-sm">
                            {{ $a->jam_mulai ? \Carbon\Carbon::parse($a->jam_mulai)->format('H:i') : '-'}} -
                            {{ $a->jam_akhir ? \Carbon\Carbon::parse($a->jam_akhir)->format('H:i') : '-' }}</td>
                        <td class="align-middle text-center text-sm">{{ $a->tanggal_absen }}</td>
                        <td class="align-middle text-center text-sm">{{ $a->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>
@endsection