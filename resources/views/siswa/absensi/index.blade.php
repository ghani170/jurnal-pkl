@extends('layout.index')

@section('title', 'Absensi Siswa')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Kalender -->
        <div class="col-lg-8 col-12 px-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <button class="btn btn-outline-light" id="prevMonth">
                        <i class="material-symbols-rounded">arrow_back_ios</i>
                    </button>
                    <h5 class="mb-0 text-white" id="monthTitle"></h5>
                    <button class="btn btn-outline-light" id="nextMonth">
                        <i class="material-symbols-rounded">arrow_forward_ios</i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="calendar-container mb-4">
                        <div class="calendar-header">
                            <div class="day-header">Minggu</div>
                            <div class="day-header">Senin</div>
                            <div class="day-header">Selasa</div>
                            <div class="day-header">Rabu</div>
                            <div class="day-header">Kamis</div>
                            <div class="day-header">Jum'at</div>
                            <div class="day-header">Sabtu</div>
                        </div>
                        <div class="calendar-body" id="calendarDays"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Absensi -->
        <div class="col-lg-4 col-12 px-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    Detail Absensi
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa.absensi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tanggal_absen" id="selectedDate">
                        <p>Tanggal: <span id="tanggalDisplay" class="fw-bold text-primary">-</span></p>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="status" id="Hadir" value="Hadir" required>
                            <label class="form-check-label fw-bold" for="Hadir">Hadir</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="status" id="Izin" value="Izin">
                            <label class="form-check-label fw-bold" for="Izin">Izin</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="status" id="Sakit" value="Sakit">
                            <label class="form-check-label fw-bold" for="Sakit">Sakit</label>
                        </div>

                        <div id="HadirBox" class="mt-3" style="display: none;">
                            <label for="jam_mulai" class="form-label">Jam Mulai Pelajaran:</label>
                            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control mb-2 border px-2">
                            <label for="jam_selesai" class="form-label">Jam Selesai Pelajaran:</label>
                            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control border px-2">
                        </div>

                        <div id="keteranganBox" class="mt-3" style="display: none;">
                            <label for="keterangan" class="form-label">Keterangan:</label>
                            <textarea name="keterangan" id="keterangan" class="form-control border px-2" rows="3" placeholder="Tulis alasan..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-dark mt-3 w-100">Simpan</button>
                    </form>
                </div>
            </div>

            <!-- Card Status Hari Ini -->
            <div class="card mt-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📅 Status Absensi</h5>
                </div>
                <div class="card-body" id="statusCard">
                    <p class="text-muted mb-0">Belum ada data absensi untuk tanggal ini.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .calendar-container {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
    }

    .calendar-header {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        background-color: #f8f9fa;
        border-bottom: 1px solid #e0e0e0;
    }

    .day-header {
        padding: 10px;
        text-align: center;
        font-weight: 600;
        color: #495057;
    }

    .calendar-body {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
    }

    .calendar-day {
        min-height: 90px;
        padding: 6px;
        border-right: 1px solid #e0e0e0;
        border-bottom: 1px solid #e0e0e0;
        text-align: left;
        cursor: pointer;
        position: relative;
    }

    .calendar-day:hover {
        background-color: #f1f1f1;
    }

    .calendar-day.other-month {
        background-color: #f8f9fa;
        color: #adb5bd;
    }

    .calendar-day.today {
        background-color: #333 !important;
        color: #fff !important;
    }

    .badge {
        position: absolute;
        top: 4px;
        right: 4px;
        font-size: 0.75rem;
        padding: 4px 6px;
        border-radius: 4px;
        color: #fff;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const absensiData = @json($absensi);
        const calendarDays = document.getElementById('calendarDays');
        const monthTitle = document.getElementById('monthTitle');
        const prevMonthBtn = document.getElementById('prevMonth');
        const nextMonthBtn = document.getElementById('nextMonth');
        const statusCard = document.getElementById('statusCard');
        const tanggalDisplay = document.getElementById('tanggalDisplay');
        const selectedDateInput = document.getElementById('selectedDate');

        const radios = document.querySelectorAll('input[name="status"]');
        const HadirBox = document.getElementById('HadirBox');
        const keteranganBox = document.getElementById('keteranganBox');

        let currentMonth = new Date().getMonth() + 1;
        let currentYear = new Date().getFullYear();

        function renderCalendar(month, year) {
            calendarDays.innerHTML = '';
            monthTitle.textContent = new Date(year, month - 1).toLocaleString('id-ID', {
                month: 'long',
                year: 'numeric'
            });

            const firstDay = new Date(year, month - 1, 1);
            const lastDay = new Date(year, month, 0);
            const startDay = firstDay.getDay();
            const monthLength = lastDay.getDate();
            const today = new Date();

            // --- Hari dari bulan sebelumnya ---
            const prevLastDay = new Date(year, month - 1, 0);
            const prevMonthDays = prevLastDay.getDate();
            for (let i = startDay - 1; i >= 0; i--) {
                const prevDate = prevMonthDays - i;
                const prevMonth = month === 1 ? 12 : month - 1;
                const prevYear = month === 1 ? year - 1 : year;
                const dateStr = `${prevYear}-${String(prevMonth).padStart(2,'0')}-${String(prevDate).padStart(2,'0')}`;

                const day = document.createElement('div');
                day.className = 'calendar-day other-month';
                day.innerHTML = `<div class="day-number">${prevDate}</div>`;
                day.addEventListener('click', () => {
                    currentMonth = prevMonth;
                    currentYear = prevYear;
                    renderCalendar(currentMonth, currentYear);
                });
                calendarDays.appendChild(day);
            }

            // --- Hari bulan saat ini ---
            for (let i = 1; i <= monthLength; i++) {
                const dateStr = `${year}-${String(month).padStart(2,'0')}-${String(i).padStart(2,'0')}`;
                const day = document.createElement('div');
                day.className = 'calendar-day';
                day.dataset.date = dateStr;
                day.innerHTML = `<div class="day-number">${i}</div>`;

                const absen = absensiData.find(a => a.tanggal_absen === dateStr);
                if (absen) {
                    day.innerHTML += `<span class="badge" style="background-color:${absen.warna}">${absen.status}</span>`;
                }

                if (today.toISOString().split('T')[0] === dateStr) {
                    day.classList.add('today');
                }

                day.addEventListener('click', function() {
                    selectedDateInput.value = dateStr;
                    tanggalDisplay.textContent = dateStr;
                    updateForm();
                    updateStatusCard(dateStr);
                });

                calendarDays.appendChild(day);
            }

            // --- Hari dari bulan berikutnya ---
            const totalCells = startDay + monthLength;
            const nextDays = 7 - (totalCells % 7);
            if (nextDays < 7) {
                for (let i = 1; i <= nextDays; i++) {
                    const nextMonth = month === 12 ? 1 : month + 1;
                    const nextYear = month === 12 ? year + 1 : year;
                    const dateStr = `${nextYear}-${String(nextMonth).padStart(2,'0')}-${String(i).padStart(2,'0')}`;
                    const day = document.createElement('div');
                    day.className = 'calendar-day other-month';
                    day.innerHTML = `<div class="day-number">${i}</div>`;
                    day.addEventListener('click', () => {
                        currentMonth = nextMonth;
                        currentYear = nextYear;
                        renderCalendar(currentMonth, currentYear);
                    });
                    calendarDays.appendChild(day);
                }
            }
        }

        function updateForm() {
            radios.forEach(r => r.checked = false);
            document.getElementById('jam_mulai').value = '';
            document.getElementById('jam_selesai').value = '';
            document.getElementById('keterangan').value = '';
            HadirBox.style.display = 'none';
            keteranganBox.style.display = 'none';
        }

        function updateStatusCard(date) {
            const data = absensiData.find(a => a.tanggal_absen === date);
            if (data) {
                let jamInfo = '';
                if (data.status === 'Hadir') {
                    jamInfo = `<p><strong>Jam:</strong> ${data.jam_mulai ?? '-'} - ${data.jam_selesai ?? '-'}</p>`;
                }
                let ketInfo = `<p><strong>Keterangan:</strong> ${data.keterangan ? data.keterangan : '<span class="text-danger">Belum diisi</span>'}</p>`;
                statusCard.innerHTML = `
                <p><strong>Status:</strong> ${data.status}</p>
                ${jamInfo}
                ${ketInfo}
            `;
            } else {
                statusCard.innerHTML = `<p class="text-muted mb-0">❌ Belum ada absensi untuk tanggal ini.</p>`;
            }
        }

        radios.forEach(radio => {
            radio.addEventListener('change', () => {
                if (radio.id === 'Hadir') {
                    HadirBox.style.display = 'block';
                    keteranganBox.style.display = 'none';
                } else if (radio.id === 'Izin' || radio.id === 'Sakit') {
                    HadirBox.style.display = 'none';
                    keteranganBox.style.display = 'block';
                } else {
                    HadirBox.style.display = 'none';
                    keteranganBox.style.display = 'none';
                }
            });
        });

        prevMonthBtn.addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 1) {
                currentMonth = 12;
                currentYear--;
            }
            renderCalendar(currentMonth, currentYear);
        });

        nextMonthBtn.addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 12) {
                currentMonth = 1;
                currentYear++;
            }
            renderCalendar(currentMonth, currentYear);
        });

        renderCalendar(currentMonth, currentYear);

        const todayStr = new Date().toISOString().split('T')[0];
        selectedDateInput.value = todayStr;
        tanggalDisplay.textContent = todayStr;
        updateForm();
        updateStatusCard(todayStr);
    });
</script>
@endsection