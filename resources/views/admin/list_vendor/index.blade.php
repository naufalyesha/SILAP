@extends('layout/admin/app')

@section('title')
    <title>Manajemen Vendor</title>
@endsection

@section('content')
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <div class="mb-3">
                <h4>Daftar Vendor</h4>
            </div>
            <div class="row">
                <!-- Table Element -->
                <div class="card border-0">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Vendor</th>
                                    <th scope="col">Email Vendor</th>
                                    <th scope="col">Alamat Vendor</th>
                                    <th scope="col">Nomor Telepon Vendor</th>
                                    <th scope="col">Tanggal Daftar</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vendors as $vendor)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $vendor->nama }}</td>
                                        <td>{{ $vendor->email }}</td>
                                        <td>{{ $vendor->alamat }}</td>
                                        <td>{{ $vendor->phone }}</td>
                                        <td>{{ $vendor->created_at->format('d M Y') }}</td>
                                        <td>
                                            @if($vendor->banned)
                                                <form method="POST" action="{{ route('admin.vendor-management.unban') }}" style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="vendorId" value="{{ $vendor->id }}">
                                                    <button type="submit" class="btn btn-success btn-sm">Batalkan Larangan</button>
                                                </form>
                                            @else
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#banModal" onclick="setVendorId({{ $vendor->id }})">Melarang</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Modal -->
    <div class="modal fade" id="banModal" tabindex="-1" aria-labelledby="banModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="banModalLabel">Larang Vendor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="banForm" method="POST" action="{{ route('admin.vendor-management.ban') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="reason" class="form-label">Alasan Melarang</label>
                            <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                        </div>
                        <input type="hidden" id="vendorId" name="vendorId">
                        <button type="submit" class="btn btn-danger">Melarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function setVendorId(id) {
        document.getElementById('vendorId').value = id;
    }
</script>
