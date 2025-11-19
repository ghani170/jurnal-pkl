@extends('layout.index')
@section('title', 'Kelola Jurusan')

@section('content')


    <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0">
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
    </div>
@endsection