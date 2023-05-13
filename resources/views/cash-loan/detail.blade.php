@extends('template')
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
                    <h5>{{ $loan->community_group->name }}</h5>
                </div>
                <div class="card-body">
                    <p>{{ $loan->community_group->address }}</p>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <h5>Informasi pembayaran</h5>
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
                                    $totalLoan = 'Rp'.number_format($loan->total_loan, 0, ',', '.');
                                    echo $totalLoan;    
                                @endphp
                            </p>
                        </div>
                        <div class="col-md-3">
                            <h6>Jumlah Kontribusi</h6>
                            <p>
                                @php
                                    $contribution = 'Rp'.number_format($loan->contribution, 0, ',', '.').' ('.$loan->contribution_percentage.'%'.')';
                                    echo $contribution;
                                    //echo $loan->contribution_percentage;    
                                @endphp
                            </p>
                        </div>
                        <div class="col-md-3">
                            <h6>Total yang harus dibayarkan</h6>
                            <p>
                                @php
                                    $totalPay = $loan->total_loan + $loan->contribution;
                                    $pay = 'Rp'.number_format($totalPay, 0, ',', '.');
                                    echo $pay;    
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
                                    $loanPeriod = 'Rp'.number_format($loan->loan_period, 0, ',', '.');
                                    echo $loanPeriod . ' bulan';    
                                @endphp
                            </p>
                        </div>
                        <div class="col-md-3">
                            <h6>Tagihan pokok perbulan</h6>
                            <p>
                                @php
                                    $monthlyPayment = 'Rp'.number_format($loan->monthly_payment, 0, ',', '.');
                                    echo $monthlyPayment;    
                                @endphp
                            </p>
                        </div>
                        <div class="col-md-3">
                            <h6>Tagihan kontribusi perbulan</h6>
                            <p>
                                @php
                                    $monthlyContribution = $loan->contribution / ($loan->loan_period - 4);
                                    $contribution = 'Rp'.number_format($monthlyContribution, 0, ',', '.');
                                    echo $contribution;    
                                @endphp
                            </p>
                        </div>
                        <div class="col-md-3">
                            <h6>Jumlah yang sudah dibayarkan sampai bulan ini</h6>
                            <p>
                                @php
                                    $alreadyPaid = $loan->monthly_installment->sum('principal_payment') + $loan->monthly_installment->sum('contribution_payment');
                                    $paid = 'Rp'.number_format($alreadyPaid, 0, ',', '.');
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
                        <h5>{{ $loan->community_group->name }} <span id="mInstallmentDate"></span></h5>
                        <p>Tagihan pokok : <span>{{ $loan->monthly_payment }}</span></p>
                        @if($loan->loan_period == 12)
                            <p>Tagihan kontribusi : <span>{{ $loan->contribution/8 }}</span></p>
                        @elseif($loan->loan_period == 24)
                            <p>Tagihan kontribusi : <span>{{ $loan->contribution/20 }}</span></p>
                        @elseif($loan->loan_period == 36)
                            <p>Tagihan kontribusi : <span>{{ $loan->contribution/32 }}</span></p>
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
                        data: 'cash_loan.monthly_payment',
                        name: 'cash_loan.monthly_payment', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' )
                    },
                    {
                        data: 'monthlycontribution',
                        name: 'monthlycontribution', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' )
                    },
                    {
                        data: 'principal_payment',
                        name: 'principal_payment', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' )
                    },
                    {
                        data: 'contribution_payment',
                        name: 'contribution_payment', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' )
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
                    $('.datatables').DataTable().ajax.reload();
                },
                error: function(err) {
                    console.error(err);
                }
            })
        });
    </script>
@endpush
