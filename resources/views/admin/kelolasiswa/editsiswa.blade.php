@extends('layout.index')

@section('content')

<h2 class="text-secondary">Edit Siswa</h2>

@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('admin.siswa.update', $siswa->id) }}" method="post">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="name">Nama</label>
      <input type="text" name="name" id="name" value="{{ old('name', $siswa->name) }}" class="form-control mb-3 p-2 border" required>
    </div>

    <div class="mb-3">
      <label for="email">Email</label>
      <input type="email" name="email" id="email" value="{{ old('email', $siswa->email) }}" class="form-control mb-3 p-2 border" required>
    </div>

    <div class="mb-3">
      <label for="password">Password (kosongkan jika tidak diubah)</label>
      <input type="password" name="password" id="password" class="form-control mb-3 p-2 border" placeholder="Password baru (opsional)">
    </div>

    <div class="mb-3">
      <label for="nis_siswa">NIS</label>
      <input type="text" name="nis_siswa" id="nis_siswa" value="{{ old('nis_siswa', $datasiswa->nis_siswa ?? '') }}" class="form-control mb-3 p-2 border" placeholder="NIS siswa">
    </div>

    <div class="mb-3">
      <label for="id_kelas">Kelas</label>
      <select name="id_kelas" id="id_kelas" class="form-control mb-3 p-2 border">
        <option value="">-- Pilih Kelas --</option>
        @isset($kela)
          @foreach($kela as $k)
            <option value="{{ $k->id }}" {{ (string) old('id_kelas', $datasiswa->id_kelas ?? '') === (string) $k->id ? 'selected' : '' }}>
              {{ $k->kelas ?? $k->name ?? $k->id }}
            </option>
          @endforeach
        @endisset
      </select>
    </div>

    <div class="mb-3">
      <label for="id_jurusan">Jurusan</label>
      <select name="id_jurusan" id="id_jurusan" class="form-control mb-3 p-2 border">
        <option value="">-- Pilih Jurusan --</option>
        @isset($jurusan)
          @foreach($jurusan as $j)
            <option value="{{ $j->id }}" {{ (string) old('id_jurusan', $datasiswa->id_jurusan ?? '') === (string) $j->id ? 'selected' : '' }}>
              {{ $j->jurusan ?? $j->name ?? $j->id }}
            </option>
          @endforeach
        @endisset
      </select>
    </div>

    <div class="mb-3">
      <label for="id_dudi">Dudi</label>
      <select name="id_dudi" id="id_dudi" class="form-control mb-3 p-2 border">
        <option value="">-- Pilih Dudi --</option>
        @isset($dudi)
          @foreach($dudi as $d)
            <option value="{{ $d->id }}" {{ (string) old('id_dudi', $datasiswa->id_dudi ?? '') === (string) $d->id ? 'selected' : '' }}>
              {{ $d->nama_dudi ?? $d->name ?? $d->id }}
            </option>
          @endforeach
        @endisset
      </select>
    </div>

    <div class="mb-3">
      <label for="id_pembimbing">Pembimbing</label>
      <select name="id_pembimbing" id="id_pembimbing" class="form-control mb-3 p-2 border">
        <option value="">-- Pilih Pembimbing --</option>
        @isset($pembimbing)
          @foreach($pembimbing as $p)
            <option value="{{ $p->id }}" {{ (string) old('id_pembimbing', $datasiswa->id_pembimbing ?? '') === (string) $p->id ? 'selected' : '' }}>
              {{ $p->name ?? $p->nama ?? $p->id }}
            </option>
          @endforeach
        @endisset
      </select>
    </div>

    

    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Batal</a>
    </div>
</form>
@endsection