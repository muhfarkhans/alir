@extends('template')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item "><a href="index.php">Anggota</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit anggota</h4>
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
                            <form class="form form-horizontal" action="{{ route('comunity-group.update', $group->id) }}"
                                method="post">
                                @csrf
                                <input type="text" name="id" value="{{ $group->id }}" hidden required>
                                <div class="form-body">
                                    <div class="mb-3 form-group">
                                        <label>Nama kelompok masyarakat</label>
                                        <input type="text" class="form-control form-control-lg" name="name"
                                        placeholder="Masukkan nama kelompok masyarakat" value="{{ $group->name }}" required>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control form-control-lg" name="address"
                                        placeholder="Masukkan alamat" value="{{ $group->address }}" required>
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
