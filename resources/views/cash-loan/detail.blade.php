@extends('template')

@section('css')
    <link href="{{ asset('mazer/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Pinjaman dana</h3>
                    <p class="text-subtitle text-muted">Detail informasi pinjaman dana</p>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card mb-3">
                <div class="card-header">
                    <h5>{{ $loan->name }}</h5>
                </div>
                <div class="card-body">
                    <p>{{ $loan->address }}</p>
                    @if ($loan->status == 1)
                        <div
                            style="display: block; width: 100%; text-align: center; padding: 10px 0px; border-radius: 10px; background-color: teal">
                            <h5 style="margin: 0; color: #fff">SELESAI</h5>
                        </div>
                    @else
                        <div
                            style="display: block; width: 100%; text-align: center; padding: 10px 0px; border-radius: 10px; background-color: firebrick">
                            <h5 style="margin: 0; color: #fff">BERJALAN</h5>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <div class="btn-group d-flex justify-content-between">
                        <div class="d-flex justify-content-start mt-2">
                            <h5>Informasi pembayaran</h5>
                        </div>

                        <div class="d-flex justify-content-end mb-3">
                            {{-- <div class="mb-n3">
                                <a href="{{ route('cash-loan.paid-off', $loan->id) }}">
                                    <button class="btn btn-danger">
                                        Pinjaman Lunas
                                    </button>
                                </a>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h6>Tanggal pencairan dana</h6>
                            <p>{{ $loan->disbursement_date }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6>Jumlah pinjaman</h6>
                            <p>
                                @php
                                    $totalLoan = 'Rp' . number_format($loan->total_loan, 0, ',', '.');
                                    echo $totalLoan;
                                @endphp
                            </p>
                        </div>
                        <div class="col-md-3">
                            @php
                                $contribution = 'Rp' . number_format($loan->contribution, 0, ',', '.');
                                $contribution_tolerance = 'Rp' . number_format($loan->contribution_tolerance, 0, ',', '.');
                                $contribution_percentage = ' (' . $loan->contribution_percentage . '%' . ')';
                                $now = Carbon\Carbon::now();
                                $tolerance_month = Carbon\Carbon::parse($loan->disbursement_date)->addMonth(10);
                                $tolerance = false;
                                if ($now->lte($tolerance_month)) {
                                    $tolerance = true;
                                }
                            @endphp
                            <h6>Jumlah Kontribusi
                                <a href="#" class="text-warning" data-bs-toggle="tooltip"
                                    title="Apabila melakukan pelunasan dalam 10 bulan maka tidak perlu membayar kontribusi bulan selanjutnya. jumlah kontribusi sebenarnya adalah {{ $contribution . ' ' . $contribution_percentage }}">***</a>
                            </h6>
                            <p>
                                @php
                                    echo $tolerance ? $contribution_tolerance : $contribution;
                                @endphp
                            </p>
                        </div>
                        <div class="col-md-3">
                            @php
                                $totalPay = $loan->total_loan + $loan->contribution;
                                $totalPayTolerance = $loan->total_loan + $loan->contribution_tolerance;
                                $pay = 'Rp' . number_format($totalPay, 0, ',', '.');
                                $pay_tolerance = 'Rp' . number_format($totalPayTolerance, 0, ',', '.');
                            @endphp
                            <h6>Total harus dibayarkan
                                <a href="#" class="text-warning" data-bs-toggle="tooltip"
                                    title="Apabila melakukan pelunasan dalam 10 bulan maka tidak perlu membayar kontribusi bulan selanjutnya. total harus dibayarkan sebenarnya adalah {{ $pay }}">***</a>
                            </h6>
                            <p>
                                @php
                                    echo $tolerance ? $pay_tolerance : $pay;
                                @endphp
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <h6>Jumlah bulan pembayaran</h6>
                            <p>
                                @php
                                    $loanPeriod = $loan->loan_period;
                                    echo $loanPeriod . ' bulan';
                                @endphp
                            </p>
                        </div>
                        <div class="col-md-3">
                            <h6>Tagihan pokok perbulan</h6>
                            <p>
                                @php
                                    $monthlyPayment = 'Rp' . number_format($loan->total_loan / ($loan->loan_period - 4), 0, ',', '.');
                                    echo $monthlyPayment;
                                @endphp
                            </p>
                        </div>
                        <div class="col-md-3">
                            <h6>Tagihan kontribusi perbulan</h6>
                            <p>
                                @php
                                    $monthlyContribution = $loan->contribution / ($loan->loan_period - 4);
                                    $contribution = 'Rp' . number_format($monthlyContribution, 0, ',', '.');
                                    echo $contribution;
                                @endphp
                            </p>
                        </div>
                        <div class="col-md-3">
                            <h6>Jumlah yang sudah dibayarkan sampai bulan ini</h6>
                            <p>
                                @php
                                    $alreadyPaid = $loan->monthly_installment->sum('principal_payment') + $loan->monthly_installment->sum('contribution_payment');
                                    $paid = 'Rp' . number_format($alreadyPaid, 0, ',', '.');
                                    echo $paid;
                                @endphp
                            </p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="btn-group d-flex justify-content-between">
                        <div class="d-flex justify-content-start mt-2">
                            Tabel Angsuran perbulan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table datatables">
                            <thead>
                                <tr>
                                    <th>No. </th>
                                    <th>Bulan</th>
                                    <th>Tagihan Pokok</th>
                                    <th>Tagihan Kontribusi</th>
                                    <th>Pembayaran Pokok</th>
                                    <th>Pembayaran Kontribusi</th>
                                    <th>Terakhir diubah</th>
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

    <!--form Modal -->
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Form Pembayaran</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="monthlyForm">
                    <div class="modal-body">
                        @csrf
                        <h5>{{ $loan->name }} <span id="mInstallmentDate"></span></h5>
                        <p>Tagihan pokok : <span>{{ $loan->monthly_payment }}</span></p>
                        @if ($loan->loan_period == 12)
                            <p>Tagihan kontribusi : <span>{{ $loan->contribution / 8 }}</span></p>
                        @elseif($loan->loan_period == 24)
                            <p>Tagihan kontribusi : <span>{{ $loan->contribution / 20 }}</span></p>
                        @elseif($loan->loan_period == 36)
                            <p>Tagihan kontribusi : <span>{{ $loan->contribution / 32 }}</span></p>
                        @endif

                        <label>Pembayaran Pokok</label>
                        <input id="mId" name="id" type="text" hidden>
                        <div class="form-group">
                            <input id="mPrincipalPayment" name="principal_payment" type="number" class="form-control">
                        </div>
                        <label>Pembayaran Kontribusi</label>
                        <div class="form-group">
                            <input id="mContributionPayment" name="contribution_payment" type="number"
                                class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tutup</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
                ajax: "{{ route('cash-loan.datatables.monthly', '') }}" + "/" + {{ $loan->id }},
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'installment_date',
                        name: 'installment_date'
                    },
                    {
                        data: 'monthly_payment',
                        name: 'monthly_payment',
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
                    },
                    {
                        data: 'monthlycontribution',
                        name: 'monthlycontribution',
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
                    },
                    {
                        data: 'principal_payment',
                        name: 'principal_payment',
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
                    },
                    {
                        data: 'contribution_payment',
                        name: 'contribution_payment',
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: false
                    },
                ]
            });
        });

        function setFormData(id) {
            $.ajax({
                url: "{{ route('cash-loan.monthly') }}" + `?id=${id}`,
                type: "GET",
                success: function(response) {
                    $('#inlineForm').modal('toggle');
                    $('#mInstallmentDate').text(response.installment_date)
                    $('#mId').val(response.id)
                    $('#mPrincipalPayment').val(response.principal_payment)
                    $('#mContributionPayment').val(response.contribution_payment)
                    console.log(response);
                },
                error: function(err) {
                    console.error(err);
                }
            })
        }

        $("#monthlyForm").on("submit", function(e) {
            e.preventDefault()
            const formData = new FormData(e.target);
            $.ajax({
                url: "{{ route('cash-loan.monthly.update', '') }}" + "/" + formData.get('id'),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#inlineForm').modal('hide');
                    window.location.reload();
                },
                error: function(err) {
                    console.error(err);
                }
            })
        });
    </script>
@endpush
