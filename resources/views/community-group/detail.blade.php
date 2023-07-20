@extends('template')

@section('css')
    <link href="{{ asset('mazer/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/choices.js/public/assets/styles/choices.css') }}" />
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/toastify-js/src/toastify.css') }}" />
@endsection

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
                                {{-- <a href="{{ route('community-group.member.create', ['community_id' => $group->id]) }}">
                                    <button class="btn btn-primary">
                                        Tambah anggota
                                    </button>
                                </a> --}}
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inlineForm">
                                    Tambah anggota
                                </button>
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

    <!--form Modal -->
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Form tambah anggota</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="newMemberForm">
                    <div class="modal-body">
                        <div class="mb-3 form-group">
                            <label>Penerima</label>
                            <select id="choices-one" class="choices form-control form-control-lg" name="citizen_id"
                                required>
                            </select>
                        </div>
                        <div class="mb-3 form-group">
                            <label>Penjamin</label>
                            <select id="choices-two" class="choices form-control form-control-lg" name="gurantor_citizen_id"
                                required>
                            </select>
                        </div>
                        <label>Jabatan</label>
                        <div class="form-group">
                            <input id="" name="role" type="text" class="form-control">
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
    <script src="{{ asset('mazer/assets/extensions/toastify-js/src/toastify.js') }}"></script>
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

    <script>
        $("#newMemberForm").on("submit", function(e) {
            e.preventDefault()

            const formData = new FormData(e.target);
            console.log(formData);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('community-group.member.store', $group->id) }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "citizen_id": formData.get("citizen_id"),
                    "gurantor_citizen_id": formData.get("gurantor_citizen_id"),
                    "role": formData.get("role"),
                },
                accepts: {
                    json: "application/json",
                },
                success: function(response) {
                    console.log(response);
                    if (response.error) {
                        Object.keys(response.message).forEach(e => {
                            Toastify({
                                text: `Error, ${response.message[e][0]}`,
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#dc3545",
                            }).showToast();
                        })
                    }

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
