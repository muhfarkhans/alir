@extends('template')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Profil</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form</h6>
        </div>
        <div class="card-body">
            @if (session('message'))
                <div class="col-lg-12">
                    <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                <div class="mt-3">
                    <label for="validationCustom01" class="form-label">Nama</label>
                    <input name="name" type="text" class="form-control" value="{{ $user->name }}" required>
                </div>

                <div class="mt-3">
                    <label for="validationCustom01" class="form-label">Email</label>
                    <input name="email" type="text" class="form-control" value="{{ $user->email }}" required>
                </div>

                <div class="mt-3">
                    <label for="validationCustom01" class="form-label">Password</label>
                    <input name="password" type="text" class="form-control">
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
@endsection
