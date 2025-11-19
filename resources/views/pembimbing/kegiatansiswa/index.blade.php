@extends('layout.index')

@section('content')
    <div class="container">
        <h3>Daftar Kegiatan Siswa</h3>

        <form action="{{ url()->current() }}" method="GET" class="mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="filter_nama_siswa" class="form-label">Nama Siswa</label>
                    <input type="text" class="form-control border p-2" id="filter_nama_siswa" name="nama_siswa"
                        value="{{ request('nama_siswa') }}" placeholder="Cari Nama Siswa...">
                </div>
                <div class="col-md-3">
                    <label for="filter_tanggal" class="form-label">Tanggal Kegiatan</label>
                    <input type="date" class="form-control border p-2" id="filter_tanggal" name="tanggal"
                        value="{{ request('tanggal') }}">
                </div>
                <div class="col-md-3">
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
                    <th class="align-middle text-center text-sm">Tanggal</th>
                    <th class="align-middle text-center text-sm">Waktu</th>
                    <th class="align-middle text-center text-sm">Keterangan</th>
                    <th class="align-middle text-center text-sm">Catatan Pembimbing</th>
                    <th class="align-middle text-center text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kegiatans as $k)
                    <tr>
                        <td class="align-middle text-center text-sm">{{ $loop->iteration }}</td>
                        <td class="align-middle text-center text-sm">{{ $k->siswa->user->name ?? '-' }}</td>
                        <td class="align-middle text-center text-sm">{{ $k->tanggal_kegiatan }}</td>
                        <td class="align-middle text-center text-sm">
                            {{ $k->mulai_kegiatan ? \Carbon\Carbon::parse($k->mulai_kegiatan)->format('H:i') : '-'}} -
                            {{ $k->akhir_kegiatan ? \Carbon\Carbon::parse($k->akhir_kegiatan)->format('H:i') : '-' }}
                        </td>
                        <td class="align-middle text-center text-sm">{{ Str::limit($k->keterangan_kegiatan, 60) }} </td>
                        <td class="align-middle text-center text-sm">{{ Str::limit($k->catatan_pembimbing, 60) ?? '-' }}</td>
                        <td class="align-middle text-center text-sm">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                Catatan
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @foreach($kegiatans as $k)
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true"> -->
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form action="{{ route('pembimbing.kegiatansiswa.update', $k->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editProfileLabel">Kegiatan Siswa</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="form-group">
                                                <label for="name">Nama Siswa</label>
                                                <input type="text" class="form-control border" id="name" name="name"
                                                    value="{{ $k->siswa->user->name ?? '-' }}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="keterangan_kegiatan">Keterangan Kegiatan:</label>

                                                <textarea class="form-control border" name="keterangan_kegiatan" id=""
                                                    disabled>{{ $k->keterangan_kegiatan }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="tanggal_kegiatan">Tanggal:</label>
                                                <input type="text" class="form-control border" id="tanggal_kegiatan"
                                                    name="tanggal_kegiatan" value="{{ $k->tanggal_kegiatan ?? '-' }}" disabled>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="mulai_kegiatan">Mulai Kegiatan:</label>
                                                    <input type="text" class="form-control border" id="mulai_kegiatan"
                                                        name="mulai_kegiatan" value="{{ $k->mulai_kegiatan ?? '-' }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="akhir_kegiatan">Akhir Kegiatan:</label>
                                                    <input type="text" class="form-control border" id="akhir_kegiatan"
                                                        name="akhir_kegiatan" value="{{ $k->akhir_kegiatan ?? '-' }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="catatan_pembimbing_{{ $k->id }}">Catatan Pembimbing</label>
                                            <textarea class="form-control border" id="catatan_pembimbing_{{ $k->id }}"
                                                name="catatan_pembimbing" rows="4">{{ $k->catatan_pembimbing }}</textarea>
                                        </div>


                                    </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>


@endsection