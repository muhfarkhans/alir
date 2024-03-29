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
                            <li class="breadcrumb-item "><a href="index.php">Kelompok masyarakat</a></li>
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
                        <h4 class="card-title">Tambah kelompok masyarakat</h4>
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
                            <form class="form form-horizontal" action="{{ route('community-group.store') }}" method="post">
                                @csrf
                                <div class="form-body">
                                    <div class="mb-3 form-group">
                                        <label>Nama kelompok masyarakat</label>
                                        <input type="text" class="form-control form-control-lg" name="name"
                                            placeholder="Masukkan nama kelompok masyarakat" required>
                                    </div>

                                    <div class="mb-3 form-group">
                                        <label>Nama pasar</label>
                                        <select class="form-select" aria-label="Default select example" name="market_id">
                                            <option selected disabled>-- Pilih nama pasar --</option>
                                            @foreach ($market as $market)
                                                @if (old('market_id') == $market->id)
                                                    <option value='{{ $market->id }}' selected>{{ $market->name }}</option>
                                                @else
                                                    <option value='{{ $market->id }}'>{{ $market->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
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
