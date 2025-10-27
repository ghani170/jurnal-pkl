@extends('layout.index')

@section('content')

<h2 class="text-secondary">Edit Data Pembimbing</h2>

<form action="{{ route('admin.pembimbing.update', $pembimbing->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="name">Nama Pembimbing:</label>
    <input type="text" name="name" id="name" value="{{ $pembimbing->name }}" class="form-control mb-3 p-2 border" placeholder="Enter Name" required>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="{{ $pembimbing->email }}" class="form-control mb-3 p-2 border" placeholder="Enter Email" required>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" value="" class="form-control mb-3 p-2 border" placeholder="Enter Password">

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection