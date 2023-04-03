@extends('template')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Pinaman dana</h3>
                    <p class="text-subtitle text-muted">daftar pinjaman dana</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Pinjaman dana</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="btn-group d-flex justify-content-between">
                        <div class="d-flex justify-content-start mt-2">
                            Tabel pinjaman dana
                        </div>

                        <div class="d-flex justify-content-end mb-3">
                            <div class="mb-n3">
                                <a href="{{ route('cash-loan.create') }}">
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
                                    <th>Nama kelompok</th>
                                    <th>Lama pinjaman</th>
                                    <th>Total pinjaman</th>
                                    <th>Kontribusi</th>
                                    <th>Angsuran bulanan</th>
                                    <th>Sisa pinjaman</th>
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
                ajax: "{{ route('cash-loan.datatables') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'community_group.name',
                        name: 'community_group.name'
                    },
                    {
                        data: 'loan-period',
                        name: 'loan-period'
                    },
                    {
                        data: 'total_loan',
                        name: 'total_loan', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' )
                    },
                    {
                        data: 'contribution',
                        name: 'contribution', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' )
                    },
                    {
                        data: 'monthly_payment',
                        name: 'monthly_payment', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' )
                    },
                    {
                        data: 'remaining_fund',
                        name: 'remaining_fund', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' )
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
