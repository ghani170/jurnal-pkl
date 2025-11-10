@extends('layout.index')

@section('title', 'Detail Kegiatan')
@section('page-title', 'Detail Kegiatan')

@section('content')
<div class="container-fluid py-4">

    <div class="card shadow-sm border-0 rounded-3 p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-dark mb-0">
                {{ $kegiatan->keterangan_kegiatan }}
            </h4>

            <a href="{{ route('siswa.kegiatan.index') }}" class="btn btn-sm bg-gradient-secondary">
                <i class="material-symbols-rounded me-1">arrow_back</i>
                Kembali
            </a>
        </div>

        <p class="text-muted mb-4">
            <i class="material-symbols-rounded me-1">event</i>
            {{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d F Y') }}
        </p>

        {{-- Waktu kegiatan --}}
        <div class="mb-3">
            <h6 class="fw-bold text-dark">Waktu Kegiatan</h6>
            <p class="text-dark">
                <i class="material-symbols-rounded me-1">schedule</i>
                {{ \Carbon\Carbon::parse($kegiatan->mulai_kegiatan)->format('H:i') }}
                
                {{ \Carbon\Carbon::parse($kegiatan->akhir_kegiatan)->format('H:i') }}
            </p>
        </div>

        {{-- Dokumentasi --}}
        <div class="mb-4">
            <h6 class="fw-bold text-dark">Dokumentasi</h6>

            @if ($kegiatan->dokumentasi)
                <img src="{{ asset('storage/' . $kegiatan->dokumentasi) }}"
                     class="img-fluid rounded shadow-sm"
                     style="max-height: 350px; object-fit: cover;"
                     alt="Dokumentasi Kegiatan">
            @else
                <p class="text-muted">Tidak ada dokumentasi</p>
            @endif
        </div>

        {{-- Catatan pembimbing --}}
        <div class="mb-4">
            <h6 class="fw-bold text-dark">Catatan Pembimbing</h6>
            <div class="bg-light p-3 rounded">
                @if ($kegiatan->catatan_pembimbing)
                    <p class="text-dark">{{ $kegiatan->catatan_pembimbing }}</p>
                @else
                    <p class="text-muted">Belum ada catatan pembimbing.</p>
                @endif
            </div>
        </div>

        {{-- Tombol Edit & Hapus --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('siswa.kegiatan.edit', $kegiatan->id) }}" class="btn btn-warning">
                <i class="material-symbols-rounded">edit</i> Edit
            </a>

            <form action="{{ route('siswa.kegiatan.destroy', $kegiatan->id) }}" method="POST" onsubmit="return confirm('Hapus kegiatan ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger">
                    <i class="material-symbols-rounded">delete</i> Hapus
                </button>
            </form>
        </div>

    </div>

</div>
@endsection
