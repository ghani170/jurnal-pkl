@extends('layout.index')
@section('title', 'Edit Kelas')
@section('content')

<h2 class="text-secondary">Edit Data Kelas</h2>

<form action="{{ route('admin.kelas.update', $kela->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="kelas">Kelas:</label>
    <input type="text" name="kelas" id="kelas" value="{{ $kela->kelas }}" class="form-control mb-3 p-2 border" placeholder="Enter Jurusan">
    @error('kelas')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection