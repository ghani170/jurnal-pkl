@extends('layout.index')

@section('title', 'Absensi Siswa')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            {{-- Kiri: Kalender --}}
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

            {{-- Kanan: Detail Absensi & Form --}}
            <div class="col-lg-4 col-12 px-3 mb-3">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        Detail Absensi
                    </div>
                    <div class="card-body">
                        {{-- Form Absensi --}}
                        <form action="{{ route('siswa.absensi.store') }}" method="POST" id="absensiForm">
                            @csrf
                            <input type="hidden" name="tanggal_absen" id="selectedDate">
                            <p>Tanggal: <span id="tanggalDisplay" class="fw-bold text-primary">-</span></p>

                            {{-- Radio Status --}}
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

                            {{-- BLOK HADIR --}}
                            <div id="HadirBox" class="mt-3" style="display: none;">
                                <input type="hidden" name="existing_jam_mulai" id="existing_jam_mulai">
                                <input type="hidden" name="existing_jam_akhir" id="existing_jam_akhir">

                                {{-- Jam Mulai --}}
                                <label class="form-label">Jam Mulai</label>
                                <div class="input-group mb-2">
                                    <input type="time" name="jam_mulai" id="jam_mulai" class="form-control border px-2">
                                    <button type="button" class="btn btn-sm btn-dark" id="btnJamMulai">Set Sekarang</button>
                                    <button type="submit" class="btn btn-sm btn-success btn-update-jam"
                                        data-field="jam_mulai" style="display: none;">Simpan Jam Masuk</button>
                                </div>

                                {{-- Jam Selesai --}}
                                <label class="form-label">Jam Selesai</label>
                                <div class="input-group">
                                    <input type="time" name="jam_akhir" id="jam_akhir" class="form-control border px-2">
                                    <button type="button" class="btn btn-sm btn-dark" id="btnJamAkhir">Set Sekarang</button>
                                    <button type="submit" class="btn btn-sm btn-success btn-update-jam"
                                        data-field="jam_akhir" style="display: none;">Simpan Jam Keluar</button>
                                </div>
                            </div>

                            {{-- Keterangan --}}
                            <div id="keteranganBox" class="mt-3" style="display: none;">
                                <label for="keterangan" class="form-label">Keterangan:</label>
                                <textarea name="keterangan" id="keterangan" class="form-control border px-2" rows="3"
                                    placeholder="Tulis alasan..."></textarea>
                            </div>

                            {{-- Tombol Simpan Umum --}}
                            <button type="submit" class="btn btn-dark mt-3 w-100" id="submitStatus">Simpan Status
                                Absensi</button>
                        </form>
                    </div>
                </div>

                {{-- Status Card --}}
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
            transition: background-color 0.15s ease;
        }

        .calendar-day:hover {
            background-color: #f1f1f1;
        }

        .calendar-day.other-month {
            background-color: #f8f9fa;
            color: #adb5bd;
        }

        /* Gaya untuk hari ini */
        .calendar-day.today {
            background-color: #333 !important;
            color: #fff !important;
            cursor: pointer;
        }

        /* Gaya untuk hari yang dinonaktifkan (bukan hari ini) */
        .calendar-day.disabled-day {
            pointer-events: none;
            /* Mencegah klik */
            opacity: 0.6;
            cursor: default;
            background-color: #fcfcfc;
        }

        .calendar-day.disabled-day:hover {
            background-color: #fcfcfc;
            /* Hapus efek hover pada hari yang nonaktif */
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
        document.addEventListener('DOMContentLoaded', function () {

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
            const existingJamMulai = document.getElementById('existing_jam_mulai');
            const existingJamAkhir = document.getElementById('existing_jam_akhir');
            const btnMulai = document.getElementById('btnJamMulai');
            const btnAkhir = document.getElementById('btnJamAkhir');
            const keteranganInput = document.getElementById('keterangan');

            const submitStatusBtn = document.getElementById('submitStatus');
            const updateJamBtns = document.querySelectorAll('.btn-update-jam');

            let currentMonth = new Date().getMonth() + 1;
            let currentYear = new Date().getFullYear();

            // Tentukan hari ini dalam format YYYY-MM-DD
            const today = new Date();
            const todayStr = today.toISOString().split('T')[0];

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

                const prevLastDay = new Date(year, month - 1, 0);
                const prevMonthDays = prevLastDay.getDate();

                // Hari bulan sebelumnya (Dinonaktifkan)
                for (let i = startDay - 1; i >= 0; i--) {
                    const d = prevMonthDays - i;
                    const prevMonthNum = month === 1 ? 12 : month - 1;
                    const prevYearNum = month === 1 ? year - 1 : year;
                    const day = document.createElement('div');
                    day.className = 'calendar-day other-month disabled-day'; // Tambah disabled-day
                    day.innerHTML = `<div class="day-number">${d}</div>`;
                    // Menghapus event listener untuk hari lain, namun mempertahankan navigasi bulan
                    day.addEventListener('click', () => {
                        currentMonth = prevMonthNum;
                        currentYear = prevYearNum;
                        renderCalendar(currentMonth, currentYear);
                    });
                    calendarDays.appendChild(day);
                }

                // Hari bulan sekarang
                for (let i = 1; i <= monthLength; i++) {
                    const dateStr = `${year}-${String(month).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                    const isToday = (todayStr === dateStr);

                    const day = document.createElement('div');
                    day.className = 'calendar-day';
                    day.dataset.date = dateStr;
                    day.innerHTML = `<div class="day-number">${i}</div>`;

                    const absen = absensiData.find(a => a.tanggal_absen === dateStr);
                    if (absen) {
                        day.innerHTML += `<span class="badge" style="background-color:${absen.warna}">${absen.status}</span>`;
                    }

                    if (isToday) {
                        day.classList.add('today');
                    } else {
                        day.classList.add('disabled-day'); // Tambah disabled-day untuk hari lain
                    }

                    // Hanya hari ini yang bisa diklik untuk mengupdate form (walaupun form sudah default hari ini)
                    if (isToday) {
                        day.addEventListener('click', function () {
                            selectedDateInput.value = dateStr;
                            tanggalDisplay.textContent = dateStr;
                            updateForm();
                            updateStatusCard(dateStr);
                        });
                    } else {
                        // Non-today dates can still be clicked to view *past* status, but cannot affect the form submission.
                        // We'll let updateStatusCard handle the disabling of the form for non-today dates.
                        day.addEventListener('click', function () {
                            selectedDateInput.value = dateStr;
                            tanggalDisplay.textContent = dateStr;
                            updateForm(); // Update form view (will be disabled by updateStatusCard)
                            updateStatusCard(dateStr); // Update status card view
                        });
                    }

                    calendarDays.appendChild(day);
                }

                // Hari bulan berikutnya (Dinonaktifkan)
                const totalCells = startDay + monthLength;
                const nextDays = 7 - (totalCells % 7);
                if (nextDays < 7) {
                    for (let i = 1; i <= nextDays; i++) {
                        const nextMonthNum = month === 12 ? 1 : month + 1;
                        const nextYearNum = month === 12 ? year + 1 : year;
                        const day = document.createElement('div');
                        day.className = 'calendar-day other-month disabled-day'; // Tambah disabled-day
                        day.innerHTML = `<div class="day-number">${i}</div>`;
                        // Menghapus event listener untuk hari lain, namun mempertahankan navigasi bulan
                        day.addEventListener('click', () => {
                            currentMonth = nextMonthNum;
                            currentYear = nextYearNum;
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

                // Reset Input Hidden
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

                        // Set nilai pada field Hidden
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
            function updateStatusCard(date) {
                const data = absensiData.find(a => a.tanggal_absen === date);
                const isToday = (date === todayStr);

                // 1. Reset semua field ke enabled/visible (Default)
                radios.forEach(r => r.disabled = false);
                jamMulai.disabled = false;
                jamAkhir.disabled = false;
                btnMulai.disabled = false;
                btnAkhir.disabled = false;
                keteranganInput.disabled = false;
                submitStatusBtn.disabled = false;
                updateJamBtns.forEach(btn => btn.style.display = 'none'); // Sembunyikan tombol update jam

                // --- TAMPILKAN STATUS CARD DETAIL (Tetap Tampil Walau Bukan Hari Ini) ---
                if (data) {
                    const statusData = data.status.toLowerCase();
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
                } else {
                    statusCard.innerHTML = `<p class="text-muted">Belum ada absensi untuk tanggal ini.</p>`;
                }
                // ------------------------------------------------------------------------

                // 2. LOGIKA DISABLING FORM UNTUK NON-TODAY DATE
                if (!isToday) {
                    statusCard.innerHTML += `<p class="text-danger mt-2 fw-bold">⚠️ Absensi hanya dapat diisi/diubah untuk tanggal hari ini.</p>`;
                    radios.forEach(r => r.disabled = true);
                    jamMulai.disabled = true;
                    jamAkhir.disabled = true;
                    btnMulai.disabled = true;
                    btnAkhir.disabled = true;
                    keteranganInput.disabled = true;
                    submitStatusBtn.disabled = true;
                    updateJamBtns.forEach(btn => btn.style.display = 'none');

                    HadirBox.style.display = 'none';
                    keteranganBox.style.display = 'none';

                    return; // Hentikan pemrosesan lebih lanjut
                }
                // ------------------------------------------------------------------------


                // 3. Logika Jika Hari Ini (Form Interaktif)
                if (!data) {
                    // Form Baru (Hari Ini)
                    // Pada Form Baru, user hanya bisa pilih status
                    jamMulai.disabled = true;
                    jamAkhir.disabled = true;
                    btnMulai.disabled = true;
                    btnAkhir.disabled = true;
                    keteranganInput.disabled = true;
                    submitStatusBtn.disabled = true; // Submit dinonaktifkan sampai status dipilih
                    return;
                }

                // 4. Sudah ada absensi (Data sudah tersimpan)
                radios.forEach(r => r.disabled = true); // Radio dikunci
                const statusData = data.status.toLowerCase();

                // 5. Logika Khusus Status HADIR (Update Jam)
                if (statusData === 'hadir') {
                    HadirBox.style.display = 'block';

                    const hasJamMulai = !!data.jam_mulai;
                    const hasJamAkhir = !!data.jam_akhir;

                    // Nonaktifkan Tombol Status Umum (Karena sudah ada status)
                    submitStatusBtn.disabled = true;
                    keteranganInput.disabled = true;

                    // --- Logika Disabling Jam ---

                    if (hasJamMulai && hasJamAkhir) {
                        // KASUS 1: Jam Mulai & Jam Akhir ADA (Kunci Semua)
                        jamMulai.disabled = true;
                        btnMulai.disabled = true;
                        jamAkhir.disabled = true;
                        btnAkhir.disabled = true;
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
                    // 6. Jika status bukan Hadir (Izin/Sakit/Libur) → semua dikunci
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


            // --- Event Listener Perubahan Radio Button (Hanya form baru/belum absen) ---
            radios.forEach(radio => {
                radio.addEventListener('change', () => {
                    // Hanya berlaku jika tanggal yang dipilih adalah hari ini
                    if (selectedDateInput.value !== todayStr) return;

                    // Hanya berlaku untuk form baru (belum absen)
                    const selected = absensiData.find(a => a.tanggal_absen === selectedDateInput.value);
                    if (selected) return;

                    submitStatusBtn.disabled = false;
                    updateJamBtns.forEach(btn => btn.style.display = 'none');

                    if (radio.id === 'hadir') {
                        HadirBox.style.display = 'none';
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
                        keteranganInput.disabled = false;
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
                btn.addEventListener('click', function (e) {
                    e.preventDefault();

                    const fieldToUpdate = this.dataset.field;
                    const form = document.getElementById('absensiForm');

                    // Pastikan status adalah 'hadir' sebelum submit update jam
                    document.getElementById('hadir').checked = true;

                    // Logika Pertahankan Nilai Lama (sisa kode sudah benar, memastikan hanya satu field jam yang dikirim)
                    if (fieldToUpdate === 'jam_mulai') {
                        jamAkhir.name = '';
                        jamMulai.name = 'jam_mulai';
                    } else if (fieldToUpdate === 'jam_akhir') {
                        jamMulai.name = '';
                        jamAkhir.name = 'jam_akhir';
                    }

                    form.submit();

                    // Kembalikan nama field setelah submit
                    jamMulai.name = 'jam_mulai';
                    jamAkhir.name = 'jam_akhir';
                });
            });


            // --- Event Listener Tombol Set Sekarang ---
            btnMulai.addEventListener('click', () => {
                const now = new Date();
                jamMulai.value = now.toTimeString().slice(0, 5);
                existingJamMulai.value = '';
            });

            btnAkhir.addEventListener('click', () => {
                const now = new Date();
                jamAkhir.value = now.toTimeString().slice(0, 5);
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

            // Initialize: Set ke hari ini saat pertama kali dimuat
            renderCalendar(currentMonth, currentYear);

            selectedDateInput.value = todayStr;
            tanggalDisplay.textContent = todayStr;
            updateForm();
            updateStatusCard(todayStr);
        });
    </script>

@endsection