@extends('template')

@section('css')
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/choices.js/public/assets/styles/choices.css') }}" />
@endsection

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
                            <li class="breadcrumb-item active">Tambah anggota</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah anggota kelompok masyarakat</h4>
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
                            <form class="form form-horizontal"
                                action="{{ route('community-group.member.store', ['community_id' => $community_id]) }}"
                                method="post">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3 form-group">
                                                <label>Penerima</label>
                                                <select id="choices-one" class="choices form-control form-control-lg"
                                                    name="citizen_id" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3 form-group">
                                                <label>Penjamin</label>
                                                <select id="choices-two" class="choices form-control form-control-lg"
                                                    name="gurantor_citizen_id" required>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label>Jabatan</label>
                                        <input type="text" class="form-control form-control-lg" name="role"
                                            placeholder="Masukkan jabatan" required>
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

@push('js')
    <script src="{{ asset('mazer/assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script>
        fetch('{{ route('citizen.datachoices') }}')
            .then(response => response.json())
            .then(data => {
                const mySelectOne = document.getElementById("choices-one");
                const choicesOne = new Choices(mySelectOne, {
                    choices: data.map((item) => {
                        if (item.is_guarantor == 0) {
                            return {
                                value: item.id,
                                label: item.fullname,
                            }
                        } else {
                            return null
                        }
                    }).filter(item => item !== null),
                });
                const mySelecttwo = document.getElementById("choices-two");
                const choicesTwo = new Choices(mySelecttwo, {
                    choices: data.map((item) => {
                        if (item.is_guarantor == 1) {
                            return {
                                value: item.id,
                                label: item.fullname,
                            }
                        } else {
                            return null
                        }
                    }).filter(item => item !== null),
                });
            })
            .catch(error => console.error(error));
    </script>
@endpush
