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
                            <li class="breadcrumb-item "><a href="index.php">Pengguna</a></li>
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
                        <h4 class="card-title">Edit pengguna</h4>
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
                            <form class="form form-horizontal" action="{{ route('user.update', $user->id) }}"
                                method="post">
                                @csrf
                                <input type="text" name="id" value="{{ $user->id }}" hidden required>
                                <div class="form-body">
                                    <div class="row">
                                        <div class="mb-3 form-group">
                                            <label>Nama</label>
                                            <input type="text" class="form-control form-control-lg" name="name"
                                                value="{{ $user->name }}" placeholder="Nama" required>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control form-control-lg" name="email"
                                                value="{{ $user->email }}" required>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control form-control-lg" name="password">
                                        </div>
                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        </div>
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
