@extends('layout.index')

@section('title', 'Absensi Siswa')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <!-- Form Sidebar -->
    <div class="col-md-3">
      <div class="card p-3 shadow-sm border-0">
        <h5 class="fw-bold mb-3 text-secondary">Absensi Hari Ini</h5>
        <form id="absenForm">
          @csrf
          <div class="mb-3">
            <label class="form-label fw-semibold">Tanggal</label>
            <input type="date" name="tanggal_absen" id="tanggal_absen" class="form-control" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Status Kehadiran</label>
            <select name="status" id="status" class="form-select" required>
              <option value="">-- Pilih Status --</option>
              <option value="hadir">Hadir</option>
              <option value="sakit">Sakit</option>
              <option value="izin">Izin</option>
              <option value="alpha">Alpha</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Keterangan (Opsional)</label>
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
      <div class="card p-3 shadow-sm border-0">
        <div id="calendar"></div>
      </div>
    </div>
  </div>
</div>

<!-- FullCalendar + jQuery -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  });

  document.addEventListener('DOMContentLoaded', function () {
    const today = new Date().toISOString().split('T')[0];
    $('#tanggal_absen').val(today);

    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'id',
      selectable: true,
      eventDisplay: 'block',
      eventTextColor: '#fff',
      height: 600,

      // Ambil data event dari route Laravel
      events: "{{ route('siswa.absensi.index') }}?ajax=1",

      dateClick: function (info) {
        const tanggal = info.dateStr;

        $('#tanggal_absen').val(tanggal);
        $('#status').val('');
        $('#keterangan').val('');
        $('#infoBox').addClass('d-none');
        $('#absenDetail').addClass('d-none');

        $.get("{{ route('siswa.absensi.getByDate') }}", { tanggal: tanggal })
          .done(function (data) {
            if (data) {
              $('#status').val(data.status);
              $('#keterangan').val(data.keterangan);
              $('#absenDetail').removeClass('d-none');
              $('#detailStatus').text(data.status.toUpperCase());
              $('#detailKeterangan').text(data.keterangan ?? '-');
            } else {
              $('#infoBox')
                .removeClass('d-none alert-success alert-danger')
                .addClass('alert-secondary')
                .html('<strong>Info:</strong> Belum ada absensi untuk tanggal ini.');
            }
          })
          .fail(function (xhr, status, error) {
            console.error("AJAX gagal:", status, error);
          });
      },

      eventDidMount: function (info) {
        $(info.el).tooltip({
          title: info.event.title,
          placement: 'top',
          trigger: 'hover',
          container: 'body'
        });
      }
    });

    calendar.render();

    // Submit absensi
    $('#absenForm').on('submit', function (e) {
      e.preventDefault();

      $.ajax({
        url: "{{ route('siswa.absensi.store') }}",
        type: 'POST',
        data: $(this).serialize(),
        success: function (res) {
          $('#infoBox')
            .removeClass('d-none alert-secondary alert-danger')
            .addClass('alert-success')
            .html('<strong>Berhasil!</strong> Data absensi disimpan.');

          calendar.refetchEvents();
          $('#status').val('');
          $('#keterangan').val('');
          $('#absenDetail').addClass('d-none');
        },
        error: function (err) {
          let message = 'Gagal menyimpan absensi!';
          if (err.status === 409) {
            message = JSON.parse(err.responseText).message;
          }

          $('#infoBox')
            .removeClass('d-none alert-secondary alert-success')
            .addClass('alert-danger')
            .html('<strong>Error:</strong> ' + message);
        }
      });
    });
  });
</script>
@endsection
