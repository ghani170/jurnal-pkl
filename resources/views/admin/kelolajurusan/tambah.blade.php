@extends('layout.index')

@section('content')

<h2 class="text-secondary">Tambah Data Jurusan</h2>

<form action="{{ route('admin.jurusan.store') }}" method="post">
    @csrf
    <label for="jurusan">Jurusan:</label>
    <input type="text" name="jurusan" id="jurusan" class="form-control mb-3 p-2 border" placeholder="Enter Jurusan" required>
    @error('jurusan')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection