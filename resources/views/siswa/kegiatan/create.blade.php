@extends('layout.index')

@section('content')
    <div class="card-header p-4 rounded bg-gradient-dark">
        <h3 class="text-light fw-bold">Tambah kegiatan</h3>
    </div>
    <div class="p-3 card-body">

        @if ($errors->any())
            <div class="alert alert-danger small">
                {{ $errors->first() }}
            </div>
        @endif
        <form action="{{ route('siswa.kegiatan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="input-group input-group-outline my-3 is-filled">
                <label class="form-label">Tanggal Kegiatan</label>
                <input type="date" name="tanggal_kegiatan" class="form-control" required>
            </div>

            <div class="input-group input-group-outline my-3 is-filled">
                <label class="form-label">Mulai Kegiatan</label>
                <input type="time" name="mulai_kegiatan" class="form-control" required>
            </div>

            <div class="input-group input-group-outline my-3 is-filled">
                <label class="form-label">Akhir Kegiatan</label>
                <input type="time" name="akhir_kegiatan" class="form-control" required>
            </div>

            <div class="input-group input-group-outline my-3 is-filled">
                <label class="form-label">Dokumentasi</label>
                <input type="file" name="dokumentasi" class="form-control">
            </div>

            <div class="input-group input-group-outline my-3 is-filled">
                <label class="form-label">Keterangan Kegiatan</label>
                <textarea name="keterangan_kegiatan" class="form-control" rows="3" required></textarea>
            </div>

            <div class="d-flex gap-3">
                <button type="submit" class="btn bg-gradient-dark my-4 mb-2">Tambah Data</button>
                <a href="{{ route('siswa.kegiatan.index') }}" class="btn bg-gradient-primary my-4 mb-2">Kembali</a>
            </div>
        </form>

    </div>
@endsection