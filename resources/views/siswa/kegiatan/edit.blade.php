@extends('layout.index')

@section('title', 'Edit Kegiatan')
@section('page-title', 'Edit Kegiatan')

@section('content')
    <div class="container-fluid py-4">

        <div class="card shadow-sm border-0 p-4 rounded-3">
            <h4 class="fw-bold mb-3">Edit Kegiatan</h4>

            <form action="{{ route('siswa.kegiatan.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Keterangan Kegiatan --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Keterangan Kegiatan</label>
                    <input type="text" name="keterangan_kegiatan" class="form-control p-2 border"
                        value="{{ $kegiatan->keterangan_kegiatan }}" required>
                </div>

                {{-- Tanggal Kegiatan --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tanggal</label>
                    <input type="date" name="tanggal_kegiatan" class="form-control p-2 border"
                        value="{{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('Y-m-d') }}" required>
                </div>

                {{-- Waktu Mulai dan Akhir --}}
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label fw-semibold">Mulai</label>
                        <input type="time" name="mulai_kegiatan" class="form-control p-2 border"
                            value="{{ \Carbon\Carbon::parse($kegiatan->mulai_kegiatan)->format('H:i') }}" required>
                    </div>
                    <div class="col">
                        <label class="form-label fw-semibold">Akhir</label>
                        <input type="time" name="akhir_kegiatan" class="form-control p-2 border"
                            value="{{ \Carbon\Carbon::parse($kegiatan->akhir_kegiatan)->format('H:i') }}" required>
                    </div>
                </div>


                {{-- Dokumentasi --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Dokumentasi (Opsional)</label><br>

                    @if ($kegiatan->dokumentasi)
                        <img src="{{ asset('storage/' . $kegiatan->dokumentasi) }}" class="rounded mb-2" width="150">
                        <br>
                    @endif

                    <input type="file" name="dokumentasi" class="form-control p-2 border">
                    <small class="text-muted">Biarkan kosong jika tidak mengubah dokumentasi.</small>
                </div>


                {{-- Tombol --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('siswa.kegiatan.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-dark">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

    </div>
@endsection