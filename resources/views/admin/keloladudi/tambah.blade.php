@extends('layout.index')
@section('title', 'Tambah Dudi')
@section('content')

<h2 class="text-secondary">Tambah Data Dudi</h2>

<form action="{{ route('admin.dudi.store') }}" method="post">
    @csrf
    <label for="nama_dudi">Nama Dudi:</label>
    <input type="text" name="nama_dudi" id="nama_dudi" class="form-control  p-2 border" placeholder="Enter Nama Dudi" >
    @error('nama_dudi')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    <label for="jenis_usaha">Jenis Usaha:</label>
    <input type="text" name="jenis_usaha" id="jenis_usaha" class="form-control  p-2 border" placeholder="Enter Jenis Usaha" >
    @error('jenis_usaha')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    <label for="alamat">Alamat:</label>
    <textarea name="alamat" id="alamat" class="form-control  p-2 border" placeholder="Enter Alamat" ></textarea>
    @error('alamat')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    <label for="kontak">Kontak:</label>
    <input type="text" name="kontak" id="alamat" class="form-control  p-2 border" placeholder="Enter Kontak" >
    @error('kontak')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    <label for="nama_pimpinan">Nama Pemimpin:</label>
    <input type="text" name="nama_pimpinan" id="nama_pimpinan" class="form-control  p-2 border" placeholder="Enter Nama Pemimpin" >
    @error('nama_pimpinan')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    <label for="nama_pembimbing">Nama Pembimbing:</label>
    <input type="text" name="nama_pembimbing" id="nama_pembimbing" class="form-control  p-2 border" placeholder="Enter Nama Pembimbing" >
    @error('nama_pembimbing')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection