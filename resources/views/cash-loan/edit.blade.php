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
                            <li class="breadcrumb-item "><a href="index.php">Pinjaman dana</a></li>
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
                        <h4 class="card-title">Edit pinjaman dana</h4>
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
                            <form class="form form-horizontal" action="{{ route('cash-loan.update', $loan->id) }}"
                                method="post">
                                @csrf
                                <input type="text" name="id" value="{{ $loan->id }}" hidden required>
                                <div class="form-body">
                                    <div class="mb-3 form-group">
                                        <label>Nama kelompok</label>
                                        <select class="form-select" aria-label="Default select example" name="community_group_id">
                                            <option selected disabled>-- Pilih nama kelompok --</option>
                                            @foreach ($group as $group)
                                                @if($loan->community_group_id == $group->id)
                                                    <option value='{{ $group->id }}' selected>{{ $group->name }}</option>
                                                @else
                                                    <option value='{{ $group->id }}'>{{ $group->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3 form-group">
                                                <label>Jumlah pinjaman</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                                    <input type="numeric" class="form-control" name="total_loan" value="{{ $loan->total_loan }}"
                                                    placeholder="Masukkan jumlah pinjaman" aria-describedby="basic-addon1" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3 form-group">
                                                <label>Masa pinjaman</label>
                                                <select class="form-select" aria-label="Default select example" name="loan_period">
                                                    @if ($loan->loan_period == 12)
                                                        <option selected disabled>-- Pilih masa pinjaman --</option>
                                                        <option value="12" selected>12 bulan</option>
                                                        <option value="24">24 bulan</option>
                                                        <option value="36">36 bulan</option>
                                                    @elseif ($loan->loan_period == 24)
                                                        <option selected disabled>-- Pilih masa pinjaman --</option>
                                                        <option value="12">12 bulan</option>
                                                        <option value="24" selected>24 bulan</option>
                                                        <option value="36">36 bulan</option>
                                                    @elseif ($loan->loan_period == 36)
                                                        <option selected disabled>-- Pilih masa pinjaman --</option>
                                                        <option value="12">12 bulan</option>
                                                        <option value="24">24 bulan</option>
                                                        <option value="36" selected>36 bulan</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
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
