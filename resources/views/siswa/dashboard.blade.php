@extends('layout.index')
@section('title', 'dashboard')

@section('content')

<div class="container-fluid py-2">
  <div class="row">
    <div class="ms-3">
      <h3 class="mb-0 h4 font-weight-bolder">Dashboard</h3>
      <p class="mb-4">
        Check the sales, value and bounce rate by country.
      </p>
    </div>
    
    <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-2 ps-3">
          <div class="d-flex justify-content-between">
            <div>
              <p class="text-sm mb-0 text-capitalize">Total Kegiatan</p>
              <h4 class="mb-0">{{ $totalKegiatan }}</h4>
            </div>
            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
              <i class="material-symbols-rounded opacity-10">leaderboard</i>
            </div>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-2 ps-3">
          <p class="mb-0 text-sm"><span class="text-danger font-weight-bolder"></span><a href="{{ route('siswa.kegiatan.index') }}">Lihat Kegiatan</a></p>
        </div>
      </div>
    </div>
    <div class="col-xl-6 col-sm-6">
      <div class="card">
        <div class="card-header p-2 ps-3">
          <div class="d-flex justify-content-between">
            <div>
              <p class="text-sm mb-0 text-capitalize">Total Absensi</p>
              <h4 class="mb-0">{{ $totalAbsensi }}</h4>
            </div>
            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
              <i class="material-symbols-rounded opacity-10">weekend</i>
            </div>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-2 ps-3">
          <p class="mb-0 text-sm"><span class="text-success font-weight-bolder"></span><a href="{{ route('siswa.absensi.index') }}">Lihat Absensi</a></p>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection