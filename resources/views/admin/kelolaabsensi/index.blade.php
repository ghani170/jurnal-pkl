@extends('layout.index')
@section('title', 'Kelola Jurusan')

@section('content')

<div class="d-flex justify-content-between">
  <h2 class="text-secondary">Data Dudi</h2>
  <a href="{{ route('admin.dudi.create') }}" class="btn btn-primary">Create Jurusan</a>
</div>

<div class="card-body px-0 pb-2">
  <div class="table-responsive p-0">
    <table class="table align-items-center mb-0">

      <thead>
        <tr>
          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">No</th>
          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Nama Siswa</th>
          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Absen</th>
          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Jam Mulai</th>
          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Jam Selesai</th>
          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Keterangan</th>
          
          <th class="text-secondary opacity-7"></th>
        </tr>

        @foreach ($absensis as $data )
      <tbody>
        <tr>
          <td class="align-middle text-center text-sm">
            {{ $loop->iteration }}
          </td>
          <td class="align-middle text-center text-sm">
            {{ $data->siswa->user->name}}
          </td>
          <td class="align-middle text-center text-sm">
            {{ $data->tanggal_absen }}
          </td>
          <td class="align-middle text-center text-sm">
            {{ $data->jam_mulai }}
          </td>
          <td class="align-middle text-center text-sm">
            {{ $data->jam_akhir }}
          </td>
          <td class="align-middle text-center text-sm">
            {{ $data->status }}
          </td>
          <td class="align-middle text-center text-sm">
            {{ $data->keterangan }}
          </td>
          
        </tr>

      </tbody>
      @endforeach

      </thead>

    </table>
  </div>
</div>
@endsection