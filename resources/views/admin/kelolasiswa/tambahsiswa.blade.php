@extends('layout.index')
@section('title', '')
@section('content')

<h2 class="text-secondary">Tambah Siswa</h2>

@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('admin.siswa.store') }}" method="post">
    @csrf

    <div class="mb-3">
      <label for="name">Nama</label>
      <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control border p-2" placeholder="Nama lengkap">
      @error('name')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    </div>

    <div class="mb-3">
      <label for="email">Email</label>
      <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control border p-2" placeholder="Email">
      @error('email')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    </div>

    <div class="mb-3">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" class="form-control border p-2" placeholder="Password">
      @error('password')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    </div>


    <div class="mb-3">
      <label for="nis_siswa">NIS</label>
      <input type="text" name="nis_siswa" id="nis_siswa" value="{{ old('nis_siswa') }}" class="form-control border p-2" placeholder="NIS siswa">
      @error('nis_siswa')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    </div>

    <div class="mb-3">
      <label for="id_kelas">Kelas</label>
      <select name="id_kelas" id="id_kelas" class="form-control border p-2">
        <option value="">-- Pilih Kelas --</option>
        @isset($kela)
          @foreach($kela as $k)
            <option value="{{ $k->id }}" {{ old('id_kelas') == $k->id ? 'selected' : '' }}>{{ $k->kelas ?? $k->name ?? $k->nama ?? $k->id }}</option>
          @endforeach
        @endisset
      </select>
      
    </div>

    <div class="mb-3">
      <label for="id_jurusan">Jurusan</label>
      <select name="id_jurusan" id="id_jurusan" class="form-control border p-2">
        <option value="">-- Pilih Jurusan --</option>
        @isset($jurusan)
          @foreach($jurusan as $j)
            <option value="{{ $j->id }}" {{ old('id_jurusan') == $j->id ? 'selected' : '' }}>{{ $j->jurusan ?? $j->name ?? $j->id }}</option>
          @endforeach
        @endisset
      </select>
    </div>

    <div class="mb-3">
      <label for="id_dudi">Dudi</label>
      <select name="id_dudi" id="id_dudi" class="form-control border p-2">
        <option value="">-- Pilih Dudi --</option>
        @isset($dudi)
          @foreach($dudi as $d)
            <option value="{{ $d->id }}" {{ old('id_dudi') == $d->id ? 'selected' : '' }}>{{ $d->nama_dudi ?? $d->name ?? $d->id }}</option>
          @endforeach
        @endisset
      </select>
    </div>

    <div class="mb-3">
      <label for="id_pembimbing">Pembimbing</label>
      <select name="id_pembimbing" id="id_pembimbing" class="form-control border p-2">
        <option value="">-- Pilih Pembimbing --</option>
        @isset($pembimbing)
          @foreach($pembimbing as $p)
            <option value="{{ $p->id }}" {{ old('id_pembimbing') == $p->id ? 'selected' : '' }}>{{ $p->name ?? $p->nama ?? $p->id }}</option>
          @endforeach
        @endisset
      </select>
    </div>

    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-primary">Submit</button>
      <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Batal</a>
    </div>
</form>
@endsection