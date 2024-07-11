<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('title')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/styleAdmin.css') }}">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar" class="js-sidebar">
            <!-- Content For Sidebar -->
            <div class="h-100">
                <div class="sidebar-logo">
                    <a href="{{ route('admin') }}">{{ Auth::user()->nama }}</a>
                </div>
                <ul class="sidebar-nav">
                    {{-- <li class="sidebar-header">
                        Admin Elements
                    </li> --}}
                    <li class="sidebar-item">
                        <a href="{{ route('admin') }}" class="sidebar-link">
                            <i class="fa-solid fa-list pe-2"></i>
                            Dasbor
                        </a>
                    </li>

                    <!-- manajemen vendor start  -->

                    <li class="sidebar-item">
                        <a href="{{ route('admin.vendor-management') }}" class="sidebar-link collapsed"
                            data-bs-target="#auth"><i class="fa-regular fa-user pe-2"></i>
                            Manajemen Vendor
                        </a>
                        {{-- <!-- <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="daftarVendor.html" class="sidebar-link">Daftar Vendor</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Register</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Forgot Password</a>
                            </li>
                        </ul> --> --}}
                    </li>

                    <!-- manajemen vendor end  -->

                    <!-- pengaduan start -->

                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-target="#pages"
                            data-bs-toggle="collapse" aria-expanded="false"><i class="fa-solid fa-file-lines pe-2"></i>
                            Pengaduan
                        </a>
                        <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="{{ route('admin.response-user') }}" class="sidebar-link">Pelanggan</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('admin.response-vendor') }}" class="sidebar-link">Vendor</a>
                            </li>
                        </ul>
                    </li>

                    <!-- pengaduan end -->

                </ul>
            </div>
        </aside>
        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" id="sidebar-toggle" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                @if (Auth::check())
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="avatar img-fluid rounded"
                                        alt="Profile Image">
                                @else
                                    <img src="{{ asset('image/profile.jpg') }}" class="avatar img-fluid rounded"
                                        alt="Profile Image">
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                @if (Auth::check())
                                    <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#profileModal">Profil</a>
                                    <a href="/logout" class="dropdown-item">Keluar</a>
                                @else
                                    <a href="/login" class="dropdown-item">Masuk</a>
                                @endif
                            </div>
                        </li>

                    </ul>
                </div>
            </nav>

            @yield('content')

            <a href="#" class="theme-toggle">
                <i class="fa-regular fa-moon"></i>
                <i class="fa-regular fa-sun"></i>
            </a>
        </div>

        <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="profileModalLabel">Profil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            @if (Auth::check() && Auth::user()->profile_photo)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="rounded-circle"
                                    alt="Profile Image" width="150" height="150">
                            @else
                                <img src="{{ asset('image/profile.jpg') }}" class="rounded-circle" alt="Profile Image"
                                    width="150" height="150">
                            @endif
                        </div>

                        <div class="profile-info text-center mb-3">
                            <h4>{{ old('nama', Auth::user()->nama) }}</h4>
                            <p>{{ old('alamat', Auth::user()->alamat) }}</p>
                            <p>{{ old('phone', Auth::user()->phone) }}</p>
                            <p>{{ old('email', Auth::user()->email) }}</p>
                        </div>
                        @if (session()->has('message'))
                            <div class="text-green-600 mb-4">{{ session('message') }}</div>
                        @endif
                        <form id="editProfileForm" action="{{ route('profile.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="editNama" name="nama"
                                    value="{{ old('nama', Auth::user()->nama) }}">
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="editAlamat" name="alamat"
                                    value="{{ old('alamat', Auth::user()->alamat) }}">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="editNomorHandphone" name="phone"
                                    value="{{ old('phone', Auth::user()->phone) }}">
                            </div>
                            <div class="mb-3">
                                <label for="profile_photo" class="form-label">Foto Profil</label>
                                <input type="file" class="form-control" id="profile_photo" name="profile_photo">
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('editProfileForm').addEventListener('submit', function(event) {
                event.preventDefault();

                let formData = new FormData(this);

                fetch('{{ route('profile.update') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-HTTP-Method-Override': 'PUT'
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.message) {
                            var editNamaInput = document.getElementById('editNama');
                            var editNamaValue = editNamaInput.value;
                            var editAlamatInput = document.getElementById('editAlamat');
                            var editAlamatValue = editAlamatInput.value;
                            var editPhoneInput = document.getElementById('editNomorHandphone');
                            var editPhoneValue = editPhoneInput.value;
                            var profileImage = document.querySelector('.modal-body .text-center img');

                            document.querySelector('.profile-info h4').textContent = `${editNamaValue}`;
                            document.querySelector('.profile-info p:nth-child(2)').textContent =
                                `${editAlamatValue}`;
                            document.querySelector('.profile-info p:nth-child(3)').textContent =
                                `${editPhoneValue}`;
                            profileImage.src = `{{ asset('storage/${data.user.profile_photo}') }}`;

                            let modal = bootstrap.Modal.getInstance(document.getElementById('profileModal'));
                            modal.hide();
                        } else {
                            console.error(data.errors);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        </script>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
