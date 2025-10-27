@extends('layouts.app')

@section('content')
  <div class="container-fluid py-4">
    <div class="row">
      <!-- Sidebar Form -->
      <div class="col-md-3">
        <div class="card p-3 shadow-sm">
          <h5 class="fw-bold mb-3">Absensi Hari Ini</h5>
          <form id="absenForm">
            @csrf
            <div class="mb-3">
              <label class="form-label">Tanggal</label>
              <input type="date" name="tanggal_absensi" id="tanggal_absensi" class="form-control" readonly>
            </div>

            <div class="mb-3">
              <label class="form-label">Status Kehadiran</label>
              <select name="status" id="status" class="form-select" required>
                <option value="">-- Pilih Status --</option>
                <option value="hadir">Hadir</option>
                <option value="sakit">Sakit</option>
                <option value="izin">Izin</option>
                <option value="alpa">Alpa</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Keterangan (Opsional)</label>
              <textarea name="keterangan" id="keterangan" rows="3" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-dark w-100">Simpan</button>
          </form>

          <!-- InfoBox -->
          <div id="infoBox" class="alert alert-secondary mt-3 small d-none">
            <strong>Info:</strong> Klik tanggal di kalender untuk melihat atau menambah absensi.
          </div>

          <!-- Detail Absensi -->
          <div id="absenDetail" class="mt-3 d-none">
            <div class="card bg-light border-0 shadow-sm">
              <div class="card-body">
                <h6 class="fw-bold mb-2 text-secondary">Status Kehadiran:</h6>
                <p id="detailStatus" class="mb-2"></p>
                <h6 class="fw-bold mb-2 text-secondary">Keterangan:</h6>
                <p id="detailKeterangan" class="mb-0 text-muted fst-italic"></p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Calendar -->
      <div class="col-md-9">
        <div class="card p-3 shadow-sm">
          <div id="calendar"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- FullCalendar -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

  <script>
    $.ajaxSetup({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    document.addEventListener('DOMContentLoaded', function () {
      const calendarEl = document.getElementById('calendar');
      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        selectable: true,
        events: @json($events),

        dateClick: function (info) {
          const tanggal = info.dateStr;
          console.log("Tanggal diklik:", tanggal);

          // Reset tampilan form dan info
          $('#tanggal_absensi').val(tanggal);
          $('#status').val('');
          $('#keterangan').val('');
          $('#infoBox').addClass('d-none');
          $('#absenDetail').addClass('d-none');

          // Fetch data absensi untuk tanggal yang diklik
          $.get("{{ route('siswa.absen.by-date') }}", { tanggal: tanggal })
            .done(function (data) {
              console.log("Response data:", data);

              if (data) {
                // Tampilkan detail absensi
                $('#status').val(data.status);
                $('#keterangan').val(data.keterangan);
                $('#absenDetail').removeClass('d-none');
                $('#detailStatus').text(data.status);
                $('#detailKeterangan').text(data.keterangan ?? '-');
              } else {
                // Jika belum ada absen
                $('#infoBox').removeClass('d-none').text('Belum ada absensi untuk tanggal ini.');
              }
            })
            .fail(function (xhr, status, error) {
              console.error("AJAX gagal:", status, error);
              console.log(xhr.responseText);
            });
        }
      });

      calendar.render();

      // Submit form via AJAX
      $('#absenForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
          url: "{{ route('siswa.absen.store') }}",
          type: 'POST',
          data: $(this).serialize(),
          success: function (res) {
            alert('Absensi berhasil disimpan!');

            // Update tampilan
            $('#infoBox').text('Data absensi berhasil disimpan!').removeClass('d-none');
            $('#absenDetail').addClass('d-none');

            // Refresh event kalender tanpa reload halaman
            calendar.refetchEvents();
          },
          error: function (err) {
            alert('Gagal menyimpan absensi!');
            console.error(err.responseText);
          }
        });
      });
    });
  </script>
@endsection