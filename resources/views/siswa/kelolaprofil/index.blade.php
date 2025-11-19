@extends('layout.index')

@section('title', 'Profile Siswa')

@section('content')
    <div class="container-fluid px-3 px-md-5 py-4">
        <!-- Alert Success -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <!-- Header dengan Gambar -->
        <div class="header-bg position-relative">
            <div class="header-overlay"></div>
        </div>
        
        <!-- Kartu Profil Utama -->
        <div class="card profile-card">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <!-- Avatar -->
                    <div class="col-md-auto avatar-container">
                        @php 
                            $fotoUrl = ($datasiswa && $datasiswa->foto) 
                                ? asset('uploads/profil/' . $datasiswa->foto) 
                                : 'https://via.placeholder.com/120/cccccc/969696?text=No+Image'; 
                        @endphp
                        <img src="{{ $fotoUrl }}" alt="Profile Image" class="avatar">
                    </div>
                    
                    <!-- Informasi Pengguna -->
                    <div class="col-md profile-info">
                        <h3 class="mb-1 fw-bold">{{ Auth::user()->name }}</h3>
                        <p class="mb-0 text-muted">
                            <i class="fas fa-graduation-cap me-1"></i>
                            {{ Auth::user()->siswa->jurusan->jurusan ?? 'Belum ada jurusan' }}
                        </p>
                    </div>
                </div>
                
                <!-- Informasi Detail dalam Kartu -->
                <div class="row mt-4">
                    <!-- Kolom 1: Informasi Utama -->
                    <div class="col-12 col-lg-4 mb-4">
                        <div class="info-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold">Informasi Profil</h6>
                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    <i class="fas fa-user-edit edit-icon" data-bs-toggle="tooltip" 
                                       data-bs-placement="top" title="Edit Profil"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-start px-0">
                                        <div class="me-auto">
                                            <div class="fw-bold text-label">Nama Lengkap</div>
                                            {{ Auth::user()->name }}
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start px-0">
                                        <div class="me-auto">
                                            <div class="fw-bold text-label">Email</div>
                                            {{ Auth::user()->email }}
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start px-0">
                                        <div class="me-auto">
                                            <div class="fw-bold text-label">NISN</div>
                                            {{ Auth::user()->siswa->nis_siswa ?? 'Belum ada NIS' }}
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start px-0">
                                        <div class="me-auto">
                                            <div class="fw-bold text-label">Kelas</div>
                                            {{ Auth::user()->siswa->kelas->kelas ?? 'Belum ada kelas' }}
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start px-0">
                                        <div class="me-auto">
                                            <div class="fw-bold text-label">Jurusan</div>
                                            {{ Auth::user()->siswa->jurusan->jurusan ?? 'Belum ada jurusan' }}
                                        </div>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kolom 2: Informasi Tambahan -->
                    <div class="col-12 col-lg-4 mb-4">
                        <div class="info-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold">Informasi Pribadi</h6>
                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    <i class="fas fa-user-edit edit-icon" data-bs-toggle="tooltip" 
                                       data-bs-placement="top" title="Edit Profil"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-start px-0">
                                        <div class="me-auto">
                                            <div class="fw-bold text-label">Jenis Kelamin</div>
                                            {{ Auth::user()->siswa->gender ?? 'Belum diisi' }}
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start px-0">
                                        <div class="me-auto">
                                            <div class="fw-bold text-label">Tempat, Tanggal Lahir</div>
                                            {{ Auth::user()->siswa->tempat_lahir ?? 'Belum' }}, {{ Auth::user()->siswa->tanggal_lahir ?? 'diisi' }}
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start px-0">
                                        <div class="me-auto">
                                            <div class="fw-bold text-label">Golongan Darah</div>
                                            {{ Auth::user()->siswa->golongan_darah ?? 'Belum diisi' }}
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start px-0">
                                        <div class="me-auto">
                                            <div class="fw-bold text-label">Alamat</div>
                                            {{ Auth::user()->siswa->alamat ?? 'Belum diisi' }}
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start px-0">
                                        <div class="me-auto">
                                            <div class="fw-bold text-label">Nomor Telepon</div>
                                            {{ Auth::user()->siswa->no_telpon ?? 'Belum diisi' }}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kolom 3: Informasi Akademik (Opsional) -->
                    <div class="col-12 col-lg-4 mb-4">
                        <div class="info-card">
                            <div class="card-header">
                                <h6 class="mb-0 fw-bold">Informasi PKL</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-light rounded p-3 me-3">
                                        <i class="fas fa-school text-dark"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-bold">Nama Pembimbing</p>
                                        <p class="mb-0 text-muted">{{ Auth::user()->siswa->pembimbing->name ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-light rounded p-3 me-3">
                                        <i class="fas fa-calendar-alt text-dark"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-bold">Nama Dudi</p>
                                        <p class="mb-0 text-muted">{{ Auth::user()->siswa->dudi->nama_dudi ?? '-'}}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-light rounded p-3 me-3">
                                        <i class="fas fa-chart-line text-dark"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-bold">Nama Pimpinan</p>
                                        <p class="mb-0 text-muted">{{ Auth::user()->siswa->dudi->nama_pimpinan ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded p-3 me-3">
                                        <i class="fas fa-chart-line text-dark"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-bold">Nama Pembimbing Dudi</p>
                                        <p class="mb-0 text-muted">{{ Auth::user()->siswa->dudi->nama_pembimbing ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Divider dan Tombol Edit -->
                <div class="divider"></div>
                <div class="text-center mt-4">
                    <button type="button" class="btn btn-elegant" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <i class="fas fa-edit me-2"></i>Edit Profil
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Profil -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editProfileLabel">Edit Profil Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('siswa.profil.update', optional($user)->id ?? 0) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <!-- Input Foto Profil -->
                            <div class="col-12">
                                <label class="form-label text-label">Foto Profil</label>
                                <input type="file" name="foto" class="form-control">
                                @if($datasiswa && $datasiswa->foto)
                                    <div class="mt-2">
                                        <small class="text-muted">Foto saat ini:</small><br>
                                        <img src="{{ asset('uploads/profil/' . $datasiswa->foto) }}" 
                                             class="mt-1 rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                    </div>
                                @else
                                    <small class="text-muted">Belum ada foto profil.</small>
                                @endif
                                @error('foto')
                                    <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Baris 1: Nama dan Jenis Kelamin -->
                            <div class="col-md-6">
                                <label class="form-label text-label">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-label">Jenis Kelamin</label>
                                <select name="gender" class="form-control">
                                  <option value="">Pilih Gender</option>
                                    <option value="laki_laki" {{ optional(Auth::user()->siswa)->gender == 'laki_laki' ? 'selected' : ''  }}>Laki-laki</option>
                                    <option value="perempuan" {{ optional(Auth::user()->siswa)->gender == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            
                            <!-- Baris 2: Email dan Password -->
                            <div class="col-md-6">
                                <label class="form-label text-label">Email</label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-label">Password</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Kosongkan jika tidak ingin mengubah">
                            </div>
                            
                            <!-- Baris 3: Tempat Lahir dan Tanggal Lahir -->
                            <div class="col-md-6">
                                <label class="form-label text-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" value="{{ Auth::user()->siswa->tempat_lahir ?? '' }}"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ Auth::user()->siswa->tanggal_lahir ?? '' }}"
                                    class="form-control">
                            </div>
                            
                            <!-- Baris 4: Golongan Darah dan No Telepon -->
                            <div class="col-md-6">
                                <label class="form-label text-label">Golongan Darah</label>
                                <input type="text" name="golongan_darah"
                                    value="{{ Auth::user()->siswa->golongan_darah ?? '' }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-label">No Telepon</label>
                                <input type="text" name="no_telpon" value="{{ Auth::user()->siswa->no_telpon ?? '' }}"
                                    class="form-control">
                            </div>
                            
                            <!-- Baris 5: Alamat -->
                            <div class="col-12">
                                <label class="form-label text-label">Alamat</label>
                                <textarea name="alamat" class="form-control"
                                    rows="2">{{ Auth::user()->siswa->alamat ?? '' }}</textarea>
                            </div>
                            
                            <!-- Input yang didisable -->
                            <div class="col-md-6">
                                <label class="form-label text-label">Kelas</label>
                                <select name="id_kelas" class="form-control" disabled>
                                    @foreach ($kela as $k)
                                        <option value="{{ $k->id }}" {{ Auth::user()->siswa->id_kelas == $k->id ? 'selected' : '' }}>{{ $k->kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-label">Jurusan</label>
                                <select name="id_jurusan" class="form-control" disabled>
                                    @foreach ($jurusan as $j)
                                        <option value="{{ $j->id }}" {{ Auth::user()->siswa->id_jurusan == $j->id ? 'selected' : '' }}>{{ $j->jurusan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-label">Pembimbing</label>
                                <select name="id_pembimbing" class="form-control" disabled>
                                    
                                    @foreach ($pembimbing as $p)
                                        <option value="{{ $p->id }}" {{ Auth::user()->siswa->id_pembimbing == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-label">DUDI</label>
                                <select name="id_dudi" class="form-control" disabled>
                                    @foreach ($dudi as $d)
                                        <option value="{{ $d->id }}" {{ Auth::user()->siswa->id_dudi == $d->id ? 'selected' : '' }}>{{ $d->nama_dudi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="modal-footer mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-elegant">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Inisialisasi tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
    
    <style>
        :root {
            --primary-black: #121212;
            --secondary-black: #1e1e1e;
            --accent-black: #2a2a2a;
            --light-gray: #f8f9fa;
            --border-gray: #dee2e6;
            --text-muted: #6c757d;
        }

        body {
            background-color: var(--light-gray);
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .black-white-theme {
            background-color: white;
            color: #333;
        }

        .header-bg {
            background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            height: 300px;
            border-radius: 0.75rem;
            position: relative;
        }

        .header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 0.75rem;
        }

        .profile-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: none;
            margin-top: -100px;
            position: relative;
            z-index: 1;
        }

        .avatar-container {
            margin-top: -50px;
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .info-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-gray);
            height: 100%;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .info-card .card-header {
            background: white;
            border-bottom: 1px solid var(--border-gray);
            padding: 1rem 1.25rem;
        }

        .info-card .card-body {
            padding: 1.25rem;
        }

        .list-group-item {
            border: none;
            padding: 0.5rem 0;
            background: transparent;
        }

        .divider {
            height: 3px;
            background: linear-gradient(to right, transparent, #000, transparent);
            margin: 2rem 0;
        }

        .btn-elegant {
            background-color: var(--primary-black);
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 2rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-elegant:hover {
            background-color: #000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .modal-content {
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            border-bottom: 1px solid var(--border-gray);
            padding: 1.25rem;
        }

        .modal-footer {
            border-top: 1px solid var(--border-gray);
            padding: 1.25rem;
        }

        .form-control {
            border: 1.5px solid var(--border-gray);
            border-radius: 0.5rem;
            padding: 0.75rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            border-color: #000;
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.1);
        }

        .text-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .edit-icon {
            color: var(--text-muted);
            transition: color 0.3s;
        }

        .edit-icon:hover {
            color: #000;
        }

        .alert-success {
            border-radius: 0.5rem;
            border: none;
            background-color: #f0f9f0;
            color: #0f5132;
        }

        @media (max-width: 768px) {
            .avatar-container {
                text-align: center;
                margin-top: -80px;
            }
            
            .profile-info {
                text-align: center;
                margin-top: 1rem;
            }
        }
    </style>

@endsection