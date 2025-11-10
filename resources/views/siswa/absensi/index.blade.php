@extends('layout.index')

@section('title', 'Absensi Siswa')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
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

                        {{-- PERUBAHAN RADIO BUTTON: ID & VALUE MENJADI HURUF KECIL --}}
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="status" id="hadir" value="hadir"
                                required>
                            <label class="form-check-label fw-bold" for="hadir">Hadir</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="status" id="izin" value="izin">
                            <label class="form-check-label fw-bold" for="izin">Izin</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="status" id="sakit" value="sakit">
                            <label class="form-check-label fw-bold" for="sakit">Sakit</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="status" id="libur" value="libur">
                            <label class="form-check-label fw-bold" for="libur">Libur</label>
                        </div>

                        <div id="HadirBox" class="mt-3" style="display: none;">
                            <label class="form-label">Jam Mulai Pelajaran:</label>
                            <div class="input-group mb-2">
                                <input type="time" name="jam_mulai" id="jam_mulai" class="form-control border px-2">
                                <button type="button" class="btn btn-sm btn-dark" id="btnJamMulai">Set Sekarang</button>
                            </div>

                            <label class="form-label">Jam Selesai Pelajaran:</label>
                            <div class="input-group">
                                <input type="time" name="jam_akhir" id="jam_akhir" class="form-control border px-2">
                                <button type="button" class="btn btn-sm btn-dark" id="btnJamAkhir">Set Sekarang</button>
                            </div>
                        </div>

                        <div id="keteranganBox" class="mt-3" style="display: none;">
                            <label for="keterangan" class="form-label">Keterangan:</label>
                            <textarea name="keterangan" id="keterangan" class="form-control border px-2" rows="3"
                                placeholder="Tulis alasan..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-dark mt-3 w-100">Simpan</button>
                    </form>
                </div>
            </div>

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
        // Catatan: HadirBox tetap menggunakan H besar sesuai id di HTML/View Anda
        const HadirBox = document.getElementById('HadirBox');
        const keteranganBox = document.getElementById('keteranganBox');

        const jamMulai = document.getElementById('jam_mulai');
        const jamAkhir = document.getElementById('jam_akhir');
        const btnMulai = document.getElementById('btnJamMulai');
        const btnAkhir = document.getElementById('btnJamAkhir');
        const keteranganInput = document.getElementById('keterangan');
        const submitBtn = document.querySelector('button[type="submit"]');


        let currentMonth = new Date().getMonth() + 1;
        let currentYear = new Date().getFullYear();

        function renderCalendar(month, year) {
            calendarDays.innerHTML = '';
            monthTitle.textContent = new Date(year, month - 1)
                .toLocaleString('id-ID', {
                    month: 'long',
                    year: 'numeric'
                });

            const firstDay = new Date(year, month - 1, 1);
            const lastDay = new Date(year, month, 0);
            const startDay = firstDay.getDay();
            const monthLength = lastDay.getDate();
            const today = new Date();

            const prevLastDay = new Date(year, month - 1, 0);
            const prevMonthDays = prevLastDay.getDate();

            // Hari bulan sebelumnya
            for (let i = startDay - 1; i >= 0; i--) {
                const d = prevMonthDays - i;
                const prevMonth = month === 1 ? 12 : month - 1;
                const prevYear = month === 1 ? year - 1 : year;
                const day = document.createElement('div');
                day.className = 'calendar-day other-month';
                day.innerHTML = `<div class="day-number">${d}</div>`;
                day.addEventListener('click', () => {
                    currentMonth = prevMonth;
                    currentYear = prevYear;
                    renderCalendar(currentMonth, currentYear);
                });
                calendarDays.appendChild(day);
            }

            // Hari bulan sekarang
            for (let i = 1; i <= monthLength; i++) {
                const dateStr = `${year}-${String(month).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
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

            // Hari bulan berikutnya
            const totalCells = startDay + monthLength;
            const nextDays = 7 - (totalCells % 7);
            if (nextDays < 7) {
                for (let i = 1; i <= nextDays; i++) {
                    const nextMonth = month === 12 ? 1 : month + 1;
                    const nextYear = month === 12 ? year + 1 : year;
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

        // --- Fungsi untuk Mengisi Form ---
        function updateForm() {
            radios.forEach(r => r.checked = false);
            jamMulai.value = '';
            jamAkhir.value = '';
            keteranganInput.value = '';
            HadirBox.style.display = 'none';
            keteranganBox.style.display = 'none';

            const selected = absensiData.find(a => a.tanggal_absen === selectedDateInput.value);

            if (selected) {
                // Set radio sesuai status sebelumnya (harus diubah ke huruf kecil karena id radio button Anda adalah huruf kecil)
                const statusLowerCase = selected.status.toLowerCase(); // <--- PENTING: Mengubah status DB menjadi huruf kecil
                const r = document.getElementById(statusLowerCase);
                if (r) r.checked = true;

                // Jika status 'hadir', tampilkan jam
                if (statusLowerCase === 'hadir') { // <--- PENTING: Perbandingan status menjadi huruf kecil
                    HadirBox.style.display = 'block';
                    jamMulai.value = selected.jam_mulai ?? '';
                    jamAkhir.value = selected.jam_akhir ?? '';
                }

                // Jika 'izin' atau 'sakit', tampil keterangan
                if (statusLowerCase === 'izin' || statusLowerCase === 'sakit') { // <--- PENTING: Perbandingan status menjadi huruf kecil
                    keteranganBox.style.display = 'block';
                    keteranganInput.value = selected.keterangan ?? '';
                }
            }
        }


        // --- Fungsi untuk Mengatur Status Card dan Disabled Field ---
        function updateStatusCard(date) {
            const data = absensiData.find(a => a.tanggal_absen === date);

            // Reset semua field ke enabled
            radios.forEach(r => r.disabled = false);
            jamMulai.disabled = false;
            jamAkhir.disabled = false;
            btnMulai.disabled = false;
            btnAkhir.disabled = false;
            keteranganInput.disabled = false;
            submitBtn.disabled = false;


            // 1. Kalau tidak ada data absensi (Form Baru)
            if (!data) {
                statusCard.innerHTML =
                    `<p class="text-muted">Belum ada absensi untuk tanggal ini.</p>`;
                
                // Set HadirBox & KeteranganBox ke default tersembunyi
                HadirBox.style.display = 'none';
                keteranganBox.style.display = 'none';
                
                // Disabled default untuk Jam dan Keterangan (sebelum radio dipilih)
                jamMulai.disabled = true; 
                jamAkhir.disabled = true;
                btnMulai.disabled = true;
                btnAkhir.disabled = true;
                keteranganInput.disabled = true; 
                submitBtn.disabled = true; // Submit disabled sampai radio dipilih

                const selectedRadio = document.querySelector('input[name="status"]:checked');
                if(selectedRadio){
                    
                    submitBtn.disabled = false; 
                    
                    if (selectedRadio.id === 'hadir') { // <--- PENTING: Perbandingan status radio button (id)
                        keteranganInput.disabled = true; 
                        jamMulai.disabled = true; 
                        jamAkhir.disabled = true;
                        btnMulai.disabled = true;
                        btnAkhir.disabled = true;
                    } else if (selectedRadio.id === 'izin' || selectedRadio.id === 'sakit') { 
                        keteranganBox.style.display = 'block';
                        keteranganInput.disabled = false; 
                        jamMulai.disabled = true; 
                        jamAkhir.disabled = true;
                        btnMulai.disabled = true;
                        btnAkhir.disabled = true;
                    } else { // libur
                        keteranganInput.disabled = true; 
                        jamMulai.disabled = true; 
                        jamAkhir.disabled = true;
                        btnMulai.disabled = true;
                        btnAkhir.disabled = true;
                    }
                }

                return;
            }

            // 2. Sudah ada absensi (Data sudah tersimpan)
            radios.forEach(r => r.disabled = true);
            const statusData = data.status.toLowerCase(); // <--- PENTING: Ambil status DB (huruf kecil)

            // tampilkan status
            let jamInfo = statusData === 'hadir' ? // <--- PENTING: Perbandingan status
                `<p><strong>Jam:</strong> ${data.jam_mulai ?? '-'} - ${data.jam_akhir ?? '-'}</p>` :
                '';

            let ketInfo = (statusData === 'izin' || statusData === 'sakit') ? // <--- PENTING: Perbandingan status
                `<p><strong>Keterangan:</strong> ${data.keterangan ?? '-'}</p>` :
                '';

            statusCard.innerHTML = `
                <p><strong>Status:</strong> ${data.status}</p>
                ${jamInfo}
                ${ketInfo}
            `;

            // 3. Kalau statusnya Hadir → jam_mulai & jam_akhir boleh diedit
            if (statusData === 'hadir') { // <--- PENTING: Perbandingan status
                HadirBox.style.display = 'block';

                jamMulai.disabled = false;
                jamAkhir.disabled = false;
                btnMulai.disabled = false;
                btnAkhir.disabled = false;
                
                // Keterangan dikunci
                keteranganInput.disabled = true;

                submitBtn.disabled = false; // Boleh submit untuk update jam
            } else {
                // 4. Jika bukan Hadir → semua selain radio dikunci (tidak bisa diubah)
                HadirBox.style.display = 'none';
                // Tampilkan keterangan box jika statusnya izin/sakit agar keterangan sebelumnya terlihat
                if (statusData === 'izin' || statusData === 'sakit') {
                    keteranganBox.style.display = 'block'; 
                } else {
                    keteranganBox.style.display = 'none';
                }

                jamMulai.disabled = true;
                jamAkhir.disabled = true;
                btnMulai.disabled = true;
                btnAkhir.disabled = true;

                keteranganInput.disabled = true;

                submitBtn.disabled = true;
            }
        }


        // --- Event Listener Perubahan Radio Button (Form Baru) ---
        radios.forEach(radio => {
            radio.addEventListener('change', () => {
                // hanya berlaku untuk form baru (belum absen)
                const selected = absensiData.find(a => a.tanggal_absen === selectedDateInput.value);
                if (selected) return; 

                // Tombol submit diaktifkan saat radio diubah
                submitBtn.disabled = false;

                // ID radio button diasumsikan huruf kecil: 'hadir', 'izin', 'sakit', 'libur'
                if (radio.id === 'hadir') { // <--- PENTING: Perbandingan status radio button (id)
                    // Saat pilih Hadir (form baru), Jam Mulai/Akhir disembunyikan dan disabled
                    HadirBox.style.display = 'none'; 
                    keteranganBox.style.display = 'none';

                    // Semua form Jam dan Keterangan harus disabled (karena jam diisi belakangan)
                    jamMulai.disabled = true;
                    jamAkhir.disabled = true;
                    btnMulai.disabled = true;
                    btnAkhir.disabled = true;
                    keteranganInput.disabled = true; 
                }

                else if (radio.id === 'izin' || radio.id === 'sakit') { // <--- PENTING: Perbandingan status radio button (id)
                    HadirBox.style.display = 'none';
                    keteranganBox.style.display = 'block';
                    
                    // Keterangan diaktifkan, Jam disabled
                    jamMulai.disabled = true; 
                    jamAkhir.disabled = true;
                    btnMulai.disabled = true;
                    btnAkhir.disabled = true;
                    keteranganInput.disabled = false; // Keterangan enabled
                }

                else if (radio.id === 'libur') { // <--- PENTING: Perbandingan status radio button (id)
                    HadirBox.style.display = 'none';
                    keteranganBox.style.display = 'none';
                    
                    // Semua form disabled
                    jamMulai.disabled = true; 
                    jamAkhir.disabled = true;
                    btnMulai.disabled = true;
                    btnAkhir.disabled = true;
                    keteranganInput.disabled = true; 
                }
            });
        });



        btnMulai.addEventListener('click', () => {
            const now = new Date();
            jamMulai.value = now.toTimeString().slice(0, 5);
        });

        btnAkhir.addEventListener('click', () => {
            const now = new Date();
            jamAkhir.value = now.toTimeString().slice(0, 5);
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