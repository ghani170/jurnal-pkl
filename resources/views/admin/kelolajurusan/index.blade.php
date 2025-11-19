@extends('layout.index')
@section('title', 'Kelola Jurusan')

@section('content')

  <div class="d-flex justify-content-between">
    <h2 class="text-secondary">Data Jurusan</h2>
    <a href="{{ route('admin.jurusan.create') }}" class="btn btn-primary">Create Jurusan</a>
  </div>

  <div class="card-body px-0 pb-2">
    @if (session('success'))
      <div class="alert alert-success text-center small">{{ session('success') }}</div>
    @elseif (session('error'))
      <div class="alert alert-danger text-center text-white small">{{ session('error') }}</div>
    @endif
    <div class="table-responsive p-0">
      <table class="table align-items-center mb-0">

        <thead>
          <tr>
            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">No</th>
            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
            <th class="text-center text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Create
              at</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
            <th class="text-secondary opacity-7"></th>
          </tr>

          @foreach ($jurusan as $data)
            <tbody>
              <tr>
                <td class="align-middle text-center text-sm">
                  {{ $loop->iteration }}
                </td>
                <td class="align-middle text-center text-sm">
                  {{ $data->jurusan }}
                </td>
                <td class="align-middle text-center text-sm">
                  {{ $data->created_at->format('d/m/Y H:i') }}
                </td>
                <td class="align-middle text-center d-flex gap-2 justify-content-center align-items-center">
                  <a href="{{ route('admin.jurusan.edit', $data->id) }}"
                    class="text-black font-weight-bold text-xs btn btn-warning" data-toggle="tooltip"
                    data-original-title="Edit user">
                    Edit
                  </a>
                  <form action="{{ route('admin.jurusan.destroy', $data->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus produk ini?')" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-black font-weight-bold text-xs btn btn-primary" data-toggle="tooltip"
                      data-original-title="Delete product">
                      Delete
                    </button>
                  </form>

                </td>
              </tr>

            </tbody>
          @endforeach

        </thead>

      </table>
    </div>
  </div>
@endsection