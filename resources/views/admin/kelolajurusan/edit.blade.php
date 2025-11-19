@extends('layout.index')
@section('title', 'Edit Jurusan')
@section('content')

<h2 class="text-secondary">Tambah Data Jurusan</h2>

<form action="{{ route('admin.jurusan.update', $jurusan->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="jurusan">Jurusan:</label>
    <input type="text" name="jurusan" id="jurusan" value="{{ $jurusan->jurusan }}" class="form-control mb-3 p-2 border" placeholder="Enter Jurusan">
    @error('jurusan')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection