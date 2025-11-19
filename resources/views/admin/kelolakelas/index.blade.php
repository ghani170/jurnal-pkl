@extends('layout.index')
@section('title', 'Kelola Kelas')

@section('content')

    <div class="d-flex justify-content-between">
        <h2 class="text-secondary">Data Kelas</h2>
        <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary">Create Kelas</a>
    </div>

    <div class="card-body px-0 pb-2">
        @if (session('success'))
            <div class="alert alert-success text-center small">{{ session('success') }}</div> 
        @elseif (session('error'))
            <div class="alert alert-danger text-center text-white small">{{ session('error') }}</div>
        @endif
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0" id="kelas">

                <thead>
                    <tr>
                        <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                        <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Kelas
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Create
                            at</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($kelas as $data)
                        <tr>
                            <td class="align-middle text-center text-sm">
                                {{ $loop->iteration }}
                            </td>
                            <td class="align-middle text-center text-sm">
                                {{ $data->kelas }}
                            </td>
                            <td class="align-middle text-center text-sm">
                                {{ $data->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="align-middle text-center d-flex gap-2 justify-content-center align-items-center">
                                <a href="{{ route('admin.kelas.edit', $data->id) }}"
                                    class="text-black font-weight-bold text-xs btn btn-warning" data-toggle="tooltip"
                                    data-original-title="Edit user">
                                    Edit
                                </a>
                                <form action="{{ route('admin.kelas.destroy', $data->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus produk ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-black font-weight-bold text-xs btn btn-primary"
                                        data-toggle="tooltip" data-original-title="Delete product">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#kelas').DataTable();
        });
    </script>
@endsection