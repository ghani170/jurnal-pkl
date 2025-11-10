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
                    <form action="{{ route('siswa.absensi.store') }}" method="POST" id="absensiForm">
                        @csrf
                        <input type="hidden" name="tanggal_absen" id="selectedDate">
                        <p>Tanggal: <span id="tanggalDisplay" class="fw-bold text-primary">-</span></p>

                        {{-- PERHATIKAN: ID & VALUE MENGGUNAKAN HURUF KECIL --}}
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

                        {{-- BLOK HADIR DENGAN PERUBAHAN INPUT TERSEMBUNYI DAN TOMBOL KHUSUS --}}
                        <div id="HadirBox" class="mt-3" style="display: none;">

                            {{-- Input Tersembunyi untuk menyimpan nilai lama. Controller akan mengambil dari sini jika field input time kosong --}}
                            <input type="hidden" name="existing_jam_mulai" id="existing_jam_mulai">
                            <input type="hidden" name="existing_jam_akhir" id="existing_jam_akhir">

                            {{-- Jam Mulai --}}
                            <label class="form-label">Jam Mulai Pelajaran:</label>
                            <div class="input-group mb-2">
                                <input type="time" name="jam_mulai" id="jam_mulai" class="form-control border px-2">
                                <button type="button" class="btn btn-sm btn-dark" id="btnJamMulai">Set Sekarang</button>
                                <button type="submit" class="btn btn-sm btn-success btn-update-jam" data-field="jam_mulai">Simpan Jam Masuk</button>
                            </div>

                            {{-- Jam Selesai --}}
                            <label class="form-label">Jam Selesai Pelajaran:</label>
                            <div class="input-group">
                                <input type="time" name="jam_akhir" id="jam_akhir" class="form-control border px-2">
                                <button type="button" class="btn btn-sm btn-dark" id="btnJamAkhir">Set Sekarang</button>
                                <button type="submit" class="btn btn-sm btn-success btn-update-jam" data-field="jam_akhir">Simpan Jam Keluar</button>
                            </div>
                        </div>

                        <div id="keteranganBox" class="mt-3" style="display: none;">
                            <label for="keterangan" class="form-label">Keterangan:</label>
                            <textarea name="keterangan" id="keterangan" class="form-control border px-2" rows="3"
                                placeholder="Tulis alasan..."></textarea>
                        </div>

                        {{-- Tombol Simpan Umum untuk Update Status/Absen Baru --}}
                        <button type="submit" class="btn btn-dark mt-3 w-100" id="submitStatus">Simpan Status Absensi</button>
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
    /* ... (CSS Anda) ... */
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

        const jamMulai = document.getElementById('jam_mulai');
        const jamAkhir = document.getElementById('jam_akhir');

        // Input Hidden untuk menyimpan nilai jam dari DB
        const existingJamMulai = document.getElementById('existing_jam_mulai');
        const existingJamAkhir = document.getElementById('existing_jam_akhir');

        const btnMulai = document.getElementById('btnJamMulai');
        const btnAkhir = document.getElementById('btnJamAkhir');
        const keteranganInput = document.getElementById('keterangan');

        const submitStatusBtn = document.getElementById('submitStatus'); // Tombol umum
        const updateJamBtns = document.querySelectorAll('.btn-update-jam'); // Tombol update khusus


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
            // 1. Reset Form
            radios.forEach(r => r.checked = false);
            jamMulai.value = '';
            jamAkhir.value = '';
            keteranganInput.value = '';
            HadirBox.style.display = 'none';
            keteranganBox.style.display = 'none';

            // **PENTING: Reset Input Hidden**
            existingJamMulai.value = '';
            existingJamAkhir.value = '';

            const selected = absensiData.find(a => a.tanggal_absen === selectedDateInput.value);

            if (selected) {
                // Set radio sesuai status sebelumnya
                const statusLowerCase = selected.status.toLowerCase();
                const r = document.getElementById(statusLowerCase);
                if (r) r.checked = true;

                // Jika status 'hadir', tampilkan jam
                if (statusLowerCase === 'hadir') {
                    HadirBox.style.display = 'block';

                    // Set nilai pada field Time yang terlihat
                    jamMulai.value = selected.jam_mulai ?? '';
                    jamAkhir.value = selected.jam_akhir ?? '';

                    // **PENTING: Set nilai pada field Hidden**
                    existingJamMulai.value = selected.jam_mulai ?? '';
                    existingJamAkhir.value = selected.jam_akhir ?? '';
                }

                // Jika 'izin' atau 'sakit', tampil keterangan
                if (statusLowerCase === 'izin' || statusLowerCase === 'sakit') {
                    keteranganBox.style.display = 'block';
                    keteranganInput.value = selected.keterangan ?? '';
                }
            }
        }


        // --- Fungsi untuk Mengatur Status Card dan Disabled Field ---
        // --- Fungsi untuk Mengatur Status Card dan Disabled Field ---
        function updateStatusCard(date) {
            const data = absensiData.find(a => a.tanggal_absen === date);

            // 1. Reset semua field ke enabled/visible (Default)
            radios.forEach(r => r.disabled = false);
            jamMulai.disabled = false;
            jamAkhir.disabled = false;
            btnMulai.disabled = false;
            btnAkhir.disabled = false;
            keteranganInput.disabled = false;
            submitStatusBtn.disabled = false;
            updateJamBtns.forEach(btn => btn.style.display = 'none'); // Sembunyikan tombol update jam

            // 2. Kalau tidak ada data absensi (Form Baru)
            if (!data) {
                statusCard.innerHTML = `<p class="text-muted">Belum ada absensi untuk tanggal ini.</p>`;

                // Pada Form Baru, user hanya bisa pilih status
                jamMulai.disabled = true;
                jamAkhir.disabled = true;
                btnMulai.disabled = true;
                btnAkhir.disabled = true;
                keteranganInput.disabled = true;
                submitStatusBtn.disabled = true;
                return;
            }

            // 3. Sudah ada absensi (Data sudah tersimpan)
            radios.forEach(r => r.disabled = true); // Radio dikunci
            const statusData = data.status.toLowerCase();

            // Tampilkan Status Card Detail
            let jamInfo = statusData === 'hadir' ?
                `<p><strong>Jam:</strong> ${data.jam_mulai ?? '-'} - ${data.jam_akhir ?? '-'}</p>` :
                '';

            let ketInfo = (statusData === 'izin' || statusData === 'sakit') ?
                `<p><strong>Keterangan:</strong> ${data.keterangan ?? '-'}</p>` :
                '';

            statusCard.innerHTML = `
        <p><strong>Status:</strong> ${data.status}</p>
        ${jamInfo}
        ${ketInfo}
    `;

            // 4. Logika Khusus Status HADIR
            if (statusData === 'hadir') {
                HadirBox.style.display = 'block';

                const hasJamMulai = !!data.jam_mulai; // true jika jam_mulai ada
                const hasJamAkhir = !!data.jam_akhir; // true jika jam_akhir ada

                // Nonaktifkan Tombol Status Umum
                submitStatusBtn.disabled = true;
                keteranganInput.disabled = true;

                // --- Logika Disabling Jam ---

                if (hasJamMulai && hasJamAkhir) {
                    // KASUS 1: Jam Mulai & Jam Akhir ADA (Kunci Semua)
                    jamMulai.disabled = true;
                    btnMulai.disabled = true;
                    jamAkhir.disabled = true;
                    btnAkhir.disabled = true;
                    updateJamBtns.forEach(btn => btn.style.display = 'none');

                    // Tampilkan pesan bahwa sudah selesai
                    if (!statusCard.querySelector('.text-success')) {
                        statusCard.innerHTML += `<p class="text-success mt-2">Absensi jam masuk & keluar sudah lengkap.</p>`;
                    }

                } else if (hasJamMulai && !hasJamAkhir) {
                    // KASUS 2: Hanya Jam Mulai yang ADA (Kunci Jam Mulai, Buka Jam Akhir)

                    // Kunci Jam Mulai
                    jamMulai.disabled = true;
                    btnMulai.disabled = true;
                    document.querySelector('.btn-update-jam[data-field="jam_mulai"]').style.display = 'none';

                    // Buka Jam Akhir
                    jamAkhir.disabled = false;
                    btnAkhir.disabled = false;
                    document.querySelector('.btn-update-jam[data-field="jam_akhir"]').style.display = 'inline-block';

                    if (!statusCard.querySelector('.text-warning')) {
                        statusCard.innerHTML += `<p class="text-warning mt-2">Silakan isi Jam Selesai.</p>`;
                    }

                } else if (!hasJamMulai && !hasJamAkhir) {
                    // KASUS 3: Kedua Jam Belum Ada (Buka Jam Mulai, Kunci Jam Akhir)

                    // Buka Jam Mulai
                    jamMulai.disabled = false;
                    btnMulai.disabled = false;
                    document.querySelector('.btn-update-jam[data-field="jam_mulai"]').style.display = 'inline-block';

                    // Kunci Jam Akhir
                    jamAkhir.disabled = true;
                    btnAkhir.disabled = true;
                    document.querySelector('.btn-update-jam[data-field="jam_akhir"]').style.display = 'none';

                }

            } else {
                // 5. Jika status bukan Hadir (Izin/Sakit/Libur) → semua dikunci
                HadirBox.style.display = 'none';

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
                submitStatusBtn.disabled = true;
            }
        }


        // --- Event Listener Perubahan Radio Button (Form Baru) ---
        radios.forEach(radio => {
            radio.addEventListener('change', () => {
                // Hanya berlaku untuk form baru (belum absen)
                const selected = absensiData.find(a => a.tanggal_absen === selectedDateInput.value);
                if (selected) return;

                submitStatusBtn.disabled = false; // Tombol submit umum diaktifkan
                updateJamBtns.forEach(btn => btn.style.display = 'none'); // Pastikan tombol jam tersembunyi

                if (radio.id === 'hadir') {
                    HadirBox.style.display = 'none'; // Jam disembunyikan
                    keteranganBox.style.display = 'none';

                    // Semua form Jam dan Keterangan harus disabled (karena jam diisi belakangan)
                    jamMulai.disabled = true;
                    jamAkhir.disabled = true;
                    btnMulai.disabled = true;
                    btnAkhir.disabled = true;
                    keteranganInput.disabled = true;
                } else if (radio.id === 'izin' || radio.id === 'sakit') {
                    HadirBox.style.display = 'none';
                    keteranganBox.style.display = 'block';

                    // Keterangan diaktifkan, Jam disabled
                    jamMulai.disabled = true;
                    jamAkhir.disabled = true;
                    btnMulai.disabled = true;
                    btnAkhir.disabled = true;
                    keteranganInput.disabled = false; // Keterangan enabled
                } else if (radio.id === 'libur') {
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

        // --- Event Listener Tombol Update Jam Khusus ---
        updateJamBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                const fieldToUpdate = this.dataset.field; // jam_mulai atau jam_akhir
                const form = document.getElementById('absensiForm');

                // Pastikan status adalah 'hadir' sebelum submit update jam
                document.getElementById('hadir').checked = true;

                // **PENTING: Logika Pertahankan Nilai Lama**

                // Kosongkan nama 'name' pada field yang tidak di-update 
                // agar nilai yang dikirim HANYA yang di-update.
                // Nilai lama akan diambil dari existing_jam_mulai/akhir di controller.
                if (fieldToUpdate === 'jam_mulai') {
                    // Nonaktifkan jam_akhir di form agar tidak mengirim nilai kosong/lama
                    jamAkhir.name = '';
                    jamMulai.name = 'jam_mulai';
                } else if (fieldToUpdate === 'jam_akhir') {
                    // Nonaktifkan jam_mulai di form agar tidak mengirim nilai kosong/lama
                    jamMulai.name = '';
                    jamAkhir.name = 'jam_akhir';
                }

                // Status dan tanggal tetap aktif dan terkirim

                form.submit();

                // Kembalikan nama field setelah submit untuk memastikan form siap untuk submit berikutnya
                jamMulai.name = 'jam_mulai';
                jamAkhir.name = 'jam_akhir';
            });
        });


        // --- Event Listener Tombol Set Sekarang ---
        btnMulai.addEventListener('click', () => {
            const now = new Date();
            jamMulai.value = now.toTimeString().slice(0, 5);
            // Saat di-set, hapus nilai existing (ini optional, tapi bagus untuk memastikan nilai baru yang dikirim)
            existingJamMulai.value = '';
        });

        btnAkhir.addEventListener('click', () => {
            const now = new Date();
            jamAkhir.value = now.toTimeString().slice(0, 5);
            // Saat di-set, hapus nilai existing
            existingJamAkhir.value = '';
        });

        // ... (Listener prev/next month) ...
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

        // Initialize
        renderCalendar(currentMonth, currentYear);

        const todayStr = new Date().toISOString().split('T')[0];
        selectedDateInput.value = todayStr;
        tanggalDisplay.textContent = todayStr;
        updateForm();
        updateStatusCard(todayStr);
    });
</script>

@endsection