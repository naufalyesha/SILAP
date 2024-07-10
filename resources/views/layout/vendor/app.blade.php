<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('title')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('/css/jadwalharga.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styleVendor.css') }}">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar" class="js-sidebar">
            <!-- Content For Sidebar -->
            <div class="h-100">
                <div class="sidebar-logo">
                    <a href="{{ route('vendor') }}">{{ Auth::user()->nama }}</a>
                </div>
                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Vendor Elements
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('vendor') }}" class="sidebar-link collapsed">
                            <i class="fa-solid fa-list pe-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('vendor.lapangans') }}" class="sidebar-link collapsed"
                            data-bs-target="#pages"><i class="fa-regular fa-square-caret-up"></i>
                            Post Lapangan
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('schedules.index') }}" class="sidebar-link collapsed"
                            data-bs-target="#posts"><i class="fa-regular fa-calendar"></i>
                            Jadwal & Harga
                        </a>
                        <ul id="posts" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        </ul>
                    </li>
                    {{-- <li class="sidebar-item">
                        <a href="{{ route('finance_reports.index') }}" class="sidebar-link collapsed"
                            data-bs-target="#auth"><i class="fa-regular fa-flag"></i>
                            Laporan
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('payment_methods.index') }}" class="sidebar-link" data-bs-target="#auth"><i
                                class="fa-regular fa-credit-card"></i>
                            Metode Pembayaran
                        </a>
                    </li> --}}
                    <li class="sidebar-item">
                        <a href="{{ route('vendor_interactions.index') }}" class="sidebar-link"
                            data-bs-target="#auth"><i class="fa-regular fa-comments"></i>
                            Interaksi User
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" id="sidebar-toggle" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse navbar">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="{{ asset('image/profile.jpg') }}" class="avatar img-fluid rounded"
                                    alt="">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                {{-- modal profil  --}}
                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#profileModal">Profile</a>
                                {{-- modal reset password  --}}
                                {{-- <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#resetPasswordModal">Reset Password</a> --}}
                                <a href="/logout" class="dropdown-item">Logout</a>
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

        <!-- Profile Modal -->
        <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="profileModalLabel">Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <img src="{{ asset('image/profile.jpeg') }}" class="rounded-circle" alt="Profile Image"
                                width="150" height="150">
                        </div>

                        <div class="profile-info text-center mb-3">
                            <h4>Nama: {{ old('nama', Auth::user()->nama) }}</h4>
                            <p>Alamat: {{ old('alamat', Auth::user()->alamat) }}</p>
                            <p>Nomor Handphone: {{ old('phone', Auth::user()->phone) }}</p>
                            <p>Email: {{ old('email', Auth::user()->email) }}</p>
                        </div>
                        @if (session()->has('message'))
                            <div class="text-green-600 mb-4">{{ session('message') }}</div>
                        @endif
                        <form id="editProfileForm" {{-- action="{{ route('profile.update') }}" method="POST" --}}>
                            {{-- @csrf
                            @method('PUT') --}}
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
                                <label for="phone" class="form-label">Nomor Handphone</label>
                                <input type="text" class="form-control" id="editNomorHandphone" name="phone"
                                    value="{{ old('[phone]', Auth::user()->phone) }}">
                            </div>
                            {{-- <div class="mb-3">
                                <label for="editEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail" name="email"
                                    value="{{ $user->email }}">
                            </div> --}}
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
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
                        console.log(response)
                        if (response.status === 200) {
                            var editNamaInput = document.getElementById('editNama'); //done (duplicate for others)
                            var editNamaValue = editNamaInput.value;
                            var editAlamatInput = document.getElementById('editAlamat');
                            var editAlamatValue = editAlamatInput.value;
                            var editPhoneInput = document.getElementById('editNomorHandphone');
                            var editPhoneValue = editPhoneInput.value;
                            // Update the profile info display
                            document.querySelector('.profile-info h4').textContent = `Nama: ${editNamaValue}`;
                            document.querySelector('.profile-info p:nth-child(2)').textContent =
                                `Alamat: ${editAlamatValue}`;
                            document.querySelector('.profile-info p:nth-child(3)').textContent =
                                `Nomor Handphone: ${editPhoneValue}`;

                            // Close the modal
                            let modal = bootstrap.Modal.getInstance(document.getElementById('profileModal'));
                            modal.hide();
                        } else {
                            // Handle validation errors
                            console.error(data.errors);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        </script>


        <!-- Reset Password Modal -->
        {{-- <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="resetPasswordForm">
                            <div class="mb-3">
                                <label for="currentPassword" class="form-label">Password saat ini</label>
                                <input type="password" class="form-control" id="currentPassword">
                            </div>
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="newPassword">
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="confirmPassword">
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
