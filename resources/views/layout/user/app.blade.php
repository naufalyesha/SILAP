<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportField</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/styleLandingPage.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/styleAdmin.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>

    <header>
        <div class="logo">
            <a href="{{ Auth::check() ? route('home') : url('/') }}">SportField</a>
        </div>

        <div class="navlist">
            <li><a href="{{ Auth::check() ? route('home') : url('/') }}#home">Beranda</a></li>
            <li><a href="{{ Auth::check() ? route('home') : url('/') }}#fields">Daftar Lapangan</a></li>
            <li><a href="{{ Auth::check() ? route('home') : url('/') }}#about">Tentang Kami</a></li>
            <li><a href="{{ Auth::check() ? route('home') : url('/') }}#faq">Faq</a></li>
        </div>

        <div class="nav-icons">
            <!-- Icon Cart -->
            <a href="/transactions" class="nav-link cart-icon">
                <i class="bi bi-cart-fill"></i>
            </a>

            <!-- Icon User -->
            <div class="dropdown show">
                <a class="nav-link user-icon dropdown-toggle" role="button" id="dropdownMenuLink"
                    data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                    @if (Auth::check() && Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="profile-photo"
                            alt="Profile Image">
                    @else
                        <i class="fas fa-user"></i>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                    @if (Auth::check())
                        @switch(Auth::user()->role)
                            @case('admin')
                                <li><a href="#" class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#profileModal">Profil</a></li>
                                <li><a href="/admin" class="dropdown-item custom-dropdown-item">Dasbor Admin</a></li>
                            @break

                            @case('vendor')
                                <li><a href="#" class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#profileModal">Profil</a></li>
                                <li><a href="/vendor" class="dropdown-item custom-dropdown-item">Dasbor Vendor</a></li>
                            @break

                            @case('customer')
                                <li><a href="#" class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#profileModal">Profil</a></li>
                                <li><a href="/logout" class="dropdown-item">Keluar</a></li>
                            @break

                            @default
                                <li><a href="/" class="dropdown-item custom-dropdown-item">Dasbor</a></li>
                        @endswitch
                    @else
                        <li><a href="/login" class="dropdown-item custom-dropdown-item">Masuk</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </header>

    @yield('content')

    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (Auth::check())
                        <div class="text-center mb-4">
                            @if (Auth::user()->profile_photo)
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
                    @else
                        <p>Anda harus login untuk melihat profil Anda.</p>
                    @endif
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


    <section class="footer">
        {{-- <div class="box-container"> --}}
        {{-- <div class="box">
                <h3>Lokasi</h3>
                <a href="#">India</a>
                <a href="#">Japan</a>
                <a href="#">Russia</a>
                <a href="#">USA</a>
                <a href="#">France</a>
            </div>

            <div class="box">
                <h3>Tautan</h3>
                <a href="#">Home</a>
                <a href="#">Dishes</a>
                <a href="#">Menu</a>
                <a href="#">Review</a>
                <a href="#">Order</a>
            </div>

            <div class="box">
                <h3>Kontak</h3>
                <a href="#">+123-456-789</a>
                <a href="#">+123-456-789</a>
                <a href="#">agustinusricad@gmail.com</a>
                <a href="#">Semarang, Indonesia - 50275</a>
            </div>

            <div class="box">
                <h3>Ikuti Kami</h3>
                <a href="#">Facebook</a>
                <a href="#">Twitter</a>
                <a href="#">Instagram</a>
                <a href="#">LinkedIn</a>
            </div>
        </div> --}}

        <div class="credit"> Dibuat Oleh | @ 2024 by <span>Naufal & Ricad</span></div>
    </section>
    <script src="{{ asset('js/scriptLandingPage.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
