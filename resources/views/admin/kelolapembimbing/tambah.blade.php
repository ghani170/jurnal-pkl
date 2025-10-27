@extends('layout.index')

@section('content')

<h2 class="text-secondary">Isi Data Pembimbing</h2>

<form action="{{ route('admin.pembimbing.store') }}" method="post">
    @csrf
    <label for="name">Name</label>
    <input type="text" name="name" id="name" class="form-control mb-3 p-2 border" placeholder="Enter Name" required>
    <label for="email">Email</label>
    <input type="email" name="email" id="email" class="form-control mb-3 p-2 border" placeholder="Enter Email" required>
    <label for="password">Password</label>
    <input type="password" name="password" id="password" class="form-control mb-3 p-2 border" placeholder="Enter Password" required>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection