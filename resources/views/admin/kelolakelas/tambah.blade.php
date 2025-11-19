@extends('layout.index')
@section('title', 'Tambah Kelas')
@section('content')

<h2 class="text-secondary">Tambah Data Kelas</h2>

<form action="{{ route('admin.kelas.store') }}" method="post">
    @csrf
    <label for="kelas">Kelas:</label>
    <input type="text" name="kelas" id="kelas" class="form-control p-2 border" placeholder="Enter Kelas" >
    @error('kelas')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    <button type="submit" class="btn btn-primary mt-2">Submit</button>
</form>
@endsection