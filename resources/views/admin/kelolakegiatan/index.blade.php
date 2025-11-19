@extends('layout.index')
@section('title', 'Lihat Kegiatan')

@section('content')

  <div class="d-flex justify-content-between">
    <h2 class="text-secondary">Data Dudi</h2>
  </div>

  <div class="card-body px-0 pb-2">
    <div class="table-responsive p-0">
      <table class="table align-items-center mb-0">

        <thead>
          <tr>
            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">No</th>
            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Nama Siswa</th>
            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Tanggal </th>
            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Jam Mulai</th>
            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Jam Selesai</th>
            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Kegiatan</th>
            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Catatan</th>
            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Detail</th>

            <th class="text-secondary opacity-7"></th>
          </tr>

          @foreach ($kegiatans as $data)
            <tbody>
              <tr>
                <td class="align-middle text-center text-sm">
                  {{ $loop->iteration }}
                </td>
                <td class="align-middle text-center text-sm">
                  {{ $data->siswa->user->name}}
                </td>
                <td class="align-middle text-center text-sm">
                  {{ $data->tanggal_kegiatan }}
                </td>
                <td class="align-middle text-center text-sm">
                  {{ $data->mulai_kegiatan }}
                </td>
                <td class="align-middle text-center text-sm">
                  {{ $data->akhir_kegiatan }}
                </td>
                <td class="align-middle text-center text-sm">
                  {{ $data->keterangan_kegiatan }}
                </td>
                <td class="align-middle text-center text-sm">
                  {{ $data->catatan_pembimbing }}
                </td>
                <td class="align-middle text-center text-sm">
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $data->id }}">
                    Catatan
                  </button>
                </td>

              </tr>

            </tbody>
          @endforeach

        </thead>

      </table>

      @foreach($kegiatans as $k)
          <div class="modal fade" id="staticBackdrop{{ $k->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"> -->
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                  <form action="{{ route('pembimbing.kegiatansiswa.update', $k->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                      <h5 class="modal-title" id="editProfileLabel">Kegiatan Siswa</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                      <div class="row g-3">
                        <div class="form-group">
                          <label for="name">Nama Siswa</label>
                          <input type="text" class="form-control border" id="name" name="name"
                            value="{{ $k->siswa->user->name ?? '-' }}" disabled>
                        </div>
                        <div class="form-group">
                          <label for="keterangan_kegiatan">Keterangan Kegiatan:</label>

                          <textarea class="form-control border" name="keterangan_kegiatan" id=""
                            disabled>{{ $k->keterangan_kegiatan }}</textarea>
                        </div>
                        <div class="form-group">
                          <label for="tanggal_kegiatan">Tanggal:</label>
                          <input type="text" class="form-control border" id="tanggal_kegiatan" name="tanggal_kegiatan"
                            value="{{ $k->tanggal_kegiatan ?? '-' }}" disabled>
                        </div>

                        <div class="form-group">
                          <label for="mulai_kegiatan">Dokumentasi:</label>
                          @if ($k->dokumentasi)
                            <img src="{{ asset('storage/' . $k->dokumentasi) }}" class="img-fluid rounded shadow-sm"
                              style="max-height: 350px; object-fit: cover;" alt="Dokumentasi Kegiatan">
                          @else
                            <p class="text-muted">Tidak ada dokumentasi</p>
                          @endif
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="mulai_kegiatan">Mulai Kegiatan:</label>
                            <input type="text" class="form-control border" id="mulai_kegiatan" name="mulai_kegiatan"
                              value="{{ $k->mulai_kegiatan ?? '-' }}" disabled>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="akhir_kegiatan">Akhir Kegiatan:</label>
                            <input type="text" class="form-control border" id="akhir_kegiatan" name="akhir_kegiatan"
                              value="{{ $k->akhir_kegiatan ?? '-' }}" disabled>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="catatan_pembimbing_{{ $k->id }}">Catatan Pembimbing</label>
                        <textarea class="form-control border" id="catatan_pembimbing_{{ $k->id }}" name="catatan_pembimbing"
                          rows="4" disabled>{{ $k->catatan_pembimbing }}</textarea>
                      </div>


                    </div>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      @endforeach
  </div>
  </div>
@endsection