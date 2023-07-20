@extends('template')

@section('css')
    <link href="{{ asset('mazer/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Anggota</h3>
                    <p class="text-subtitle text-muted">Daftar anggota</p>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="btn-group d-flex justify-content-between">
                        <div class="d-flex justify-content-start mt-2">
                            Tabel anggota
                        </div>

                        <div class="d-flex justify-content-end mb-3">
                            <div class="mb-n3">
                                <a href="{{ route('citizen.create') }}">
                                    <button class="btn btn-primary">
                                        Tambah data
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table datatables">
                            <thead>
                                <tr>
                                    <th>No. </th>
                                    <th>NIK</th>
                                    <th>Nama lengkap</th>
                                    <th>Alamat</th>
                                    <th>Nomor telepon</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script src="{{ asset('mazer/assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="{{ asset('mazer/assets/js/pages/datatables.js') }}"></script>

    <script type="text/javascript">
        $(function() {

            var table = $('.datatables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('citizen.datatables') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'fullname',
                        name: 'fullname'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'html_is_guarantor',
                        name: 'html_is_guarantor'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });
        });
    </script>
@endpush
