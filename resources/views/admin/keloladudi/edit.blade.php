@extends('layout.index')
@section('title', 'Edit Dudi')
@section('content')

<h2 class="text-secondary">Edit Data Dudi</h2>

<form action="{{ route('admin.dudi.update', $dudi->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="nama_dudi">Nama Dudi:</label>
    <input type="text" name="nama_dudi" id="nama_dudi" value="{{ $dudi->nama_dudi }}" class="form-control mb-3 p-2 border" placeholder="Enter Nama Dudi">
    @error('nama_dudi')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    <label for="jenis_usaha">Jenis Usaha:</label>
    <input type="text" name="jenis_usaha" id="jenis_usaha" value="{{ $dudi->jenis_usaha }}" class="form-control mb-3 p-2 border" placeholder="Enter Jenis Usaha">
    @error('jenis_usaha')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    <label for="alamat">Alamat:</label>
    <input type="text" name="alamat" id="alamat" value="{{ $dudi->alamat }}" class="form-control mb-3 p-2 border" placeholder="Enter Alamat">
    @error('alamat')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    <label for="kontak">Kontak:</label>
    <input type="text" name="kontak" id="jurusan" value="{{ $dudi->kontak }}" class="form-control mb-3 p-2 border" placeholder="Enter Kontak">
    @error('kontak')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    <label for="nama_pimpinan">Nama Pimpinan:</label>
    <input type="text" name="nama_pimpinan" id="jurusan" value="{{ $dudi->nama_pimpinan }}" class="form-control mb-3 p-2 border" placeholder="Enter Nama Pimpinan">
    @error('nama_pimpinan')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    <label for="nama_pembimbing">Nama Pembimbing:</label>
    <input type="text" name="nama_pembimbing" id="nama_pembimbing" value="{{ $dudi->nama_pembimbing }}" class="form-control mb-3 p-2 border" placeholder="Enter Nama Pembimbing">
    @error('nama_pembimbing')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection