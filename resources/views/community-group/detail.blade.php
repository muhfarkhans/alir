@extends('template')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Kelompok masyarakat</h3>
                    <p class="text-subtitle text-muted">Informasi detail kelompok masyarakat</p>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card mb-3">
                <div class="card-header">
                    <h5>{{ $group->name }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <p>{{ $group->address }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="btn-group d-flex justify-content-between">
                        <div class="d-flex justify-content-start mt-2">
                            Tabel Anggota
                        </div>

                        <div class="d-flex justify-content-end mb-3">
                            <div class="mb-n3">
                                <a href="{{ route('community-group.member.create', ['community_id' => $group->id]) }}">
                                    <button class="btn btn-primary">
                                        Tambah anggota
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
                                    <th>Jabatan</th>
                                    <th>Nama</th>
                                    <th>Penerima Telepon</th>
                                    <th>Penjamin</th>
                                    <th>Penjamin Telepon</th>
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
                ajax: "{{ route('community-group.member.datatables', ['community_id' => $group->id]) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'citizen.fullname',
                        name: 'citizen.fullname'
                    },
                    {
                        data: 'citizen.phone',
                        name: 'citizen.phone'
                    },
                    {
                        data: 'gurantor_citizen.fullname',
                        name: 'gurantor_citizen.fullname'
                    },
                    {
                        data: 'gurantor_citizen.phone',
                        name: 'gurantor_citizen.phone'
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
