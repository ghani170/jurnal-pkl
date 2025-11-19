@extends('layout.index')
@section('title', 'Daftar Siswa')
@section('content')
    <div class="container">
        <h3>Daftar Siswa</h3>
        <table class="table table-striped align-items-center mb-0">
            <thead>
                <tr>
                    <th class="align-middle text-center text-sm">No</th>
                    <th class="align-middle text-center text-sm">Nama</th>
                    <th class="align-middle text-center text-sm">Nis</th>
                    <th class="align-middle text-center text-sm">Jenis Kelamin</th>
                    <th class="align-middle text-center text-sm">Kelas</th>
                    <th class="align-middle text-center text-sm">Jurusan</th>
                    <th class="align-middle text-center text-sm">Dudi</th>
                    <th class="align-middle text-center text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswa as $s)
                    <tr>
                        <td class="align-middle text-center text-sm">{{ $loop->iteration }}</td>
                        <td class="align-middle text-center text-sm">{{ $s->user->name }}</td>
                        <td class="align-middle text-center text-sm">{{ $s->nis_siswa }}</td>
                        <td class="align-middle text-center text-sm">{{ $s->gender }}</td>
                        <td class="align-middle text-center text-sm">{{ $s->kelas->kelas }}</td>
                        <td class="align-middle text-center text-sm">{{ $s->jurusan->jurusan }}</td>
                        <td class="align-middle text-center text-sm">{{ $s->dudi->nama_dudi }}</td>
                        <td class="align-middle text-center text-sm">
                            <a href="{{ route('pembimbing.siswa.kegiatan', $s->id) }}" class="btn btn-sm btn-primary">
                                Lihat Kegiatan
                            </a>
                            <a href="{{ route('pembimbing.siswa.absensi', $s->id) }}" class="btn btn-sm btn-info">
                                Lihat Absensi
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection