@extends('template')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Tambah</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item "><a href="index.php">Anggota</a></li>
                            <li class="breadcrumb-item active">Tambah</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah pengguna</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form class="form form-horizontal" action="{{ route('citizen.store') }}" method="post">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3 form-group">
                                                <label>NIK</label>
                                                <input type="number" class="form-control form-control-lg" name="nik"
                                                    placeholder="Masukkan nomor induk kependudukan" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3 form-group">
                                                <label>Nama lengkap</label>
                                                <input type="text" class="form-control form-control-lg" name="fullname"
                                                    placeholder="Masukkan nama lengkap" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3 form-group">
                                                <label>Nomor telpon</label>
                                                <input type="number" class="form-control form-control-lg" name="phone"
                                                    placeholder="Masukkan nomor telpon" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3 form-group">
                                                <label>Sebagai</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="is_guarantor"
                                                        id="flexRadioDefault1" value="0">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        Penerima
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="is_guarantor"
                                                        id="flexRadioDefault2" value="1">
                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                        Penjamin
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label>Alamat</label>
                                            <input type="text" class="form-control form-control-lg" name="address"
                                                placeholder="Masukkan alamat" required>
                                        </div>
                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
