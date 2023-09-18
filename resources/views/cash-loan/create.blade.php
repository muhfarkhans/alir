@extends('template')

@section('css')
    <link href="{{ asset('mazer/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
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
                            <li class="breadcrumb-item "><a href="index.php">Pinjaman dana</a></li>
                            <li class="breadcrumb-item active">Tambah</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah pinjaman dana</h4>
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
                            <form id="main-form" class="form form-horizontal" action="{{ route('cash-loan.store') }}"
                                method="post">
                                @csrf
                                <div class="form-body">
                                    <div class="mb-3 form-group">
                                        <label>Pasar</label>
                                        <select id="choices-market" class="choices form-control form-control-lg"
                                            name="market_id" required>
                                        </select>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="">Nama Kelompok</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="">Kode DPM</label>
                                        <input type="text" class="form-control" name="code_dpm" required>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="">Alamat</label>
                                        <textarea name="address" id="" cols="30" rows="3" class="form-control" required></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3 form-group">
                                                <label>Tanggal Pencairan</label>
                                                <input type="date" class="form-control" name="disbursement_date"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3 form-group">
                                                <label>Tanggal Jatuh Tempo</label>
                                                <input type="date" class="form-control" name="due_date" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mb-3 form-group">
                                                <label>Jumlah pinjaman</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                                    <input type="numeric" class="form-control" name="total_loan"
                                                        placeholder="Masukkan jumlah pinjaman"
                                                        aria-describedby="basic-addon1" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-3 form-group">
                                                <label>Masa pinjaman</label>
                                                <select class="form-select" aria-label="Default select example"
                                                    name="loan_period" required>
                                                    <option selected disabled>-- Pilih masa pinjaman --</option>
                                                    <option value="12">12 bulan</option>
                                                    <option value="24">24 bulan</option>
                                                    <option value="36">36 bulan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-3 form-group">
                                                <label>Presentase kontribusi</label>
                                                <input type="number" class="form-control" name="contribution_percentage"
                                                    placeholder="Masukkan persentase kontribusi" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <label for="">Anggota</label>
                                            <button type="button" class="btn btn-primary block btn-modal"
                                                data-bs-toggle="modal" data-bs-target="#border-less">
                                                Tambah Anggota
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table datatables">
                                                <thead>
                                                    <tr>
                                                        <th>No. </th>
                                                        <th>Peminjam</th>
                                                        <th>Peminjam Posisi</th>
                                                        <th>Peminjam HP</th>
                                                        <th>Peminjam Alamat</th>
                                                        <th>Penjamin</th>
                                                        <th>Penjamin HP</th>
                                                        <th>Penjamin Alamat</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button type="button" id="submit-form"
                                            class="btn btn-primary me-1 mb-1">Submit</button>
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

    <div class="modal modal-lg fade text-left modal-borderless" id="border-less" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input data diri anggota</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Nama Peminjam</label>
                                <input type="text" class="form-control" id="m-peminjam-nama">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">NIK Peminjam</label>
                                <input type="text" class="form-control" id="m-peminjam-nik">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Jabatan Peminjam</label>
                                <select class="form-control" id="m-peminjam-jabatan">
                                    <option value="">--pilih jabatan--</option>
                                    <option value="ketua">Ketua</option>
                                    <option value="sekertaris">Sekertaris</option>
                                    <option value="bendahara">Bendahara</option>
                                    <option value="anggota">Anggota</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Peminjam HP</label>
                                <input type="text" class="form-control" id="m-peminjam-hp">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="" class="form-label">Alamat Peminjam</label>
                        <input type="text" class="form-control" id="m-peminjam-alamat">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Nama Penjamin</label>
                                <input type="text" class="form-control" id="m-penjamin-nama">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">NIK Penjamin</label>
                                <input type="text" class="form-control" id="m-penjamin-nik">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="" class="form-label">Penjamin HP</label>
                        <input type="text" class="form-control" id="m-penjamin-hp">
                    </div>
                    <div class="mb-3 form-group">
                        <label for="" class="form-label">Alamat Penjamin</label>
                        <input type="text" class="form-control" id="m-penjamin-alamat">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1" id="btn-add-member">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tambah</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('mazer/assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('mazer/assets/extensions/datatables.net-bs5/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('mazer/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            let members = [];
            const table = $('.datatables').DataTable({
                searching: false,
                paging: false,
                info: false
            });

            function addRowData(data) {
                let dataRow = [];
                dataRow.push(
                    `<input type="text" name="peminjam-nama[]" value="${data[0]}" hidden><input type="text" name="peminjam-nik[]" value="${data[1]}" hidden>${data[0]} (${data[1]})`
                )
                dataRow.push(`${data[2]} <input type="text" name="peminjam-jabatan[]" value="${data[2]}" hidden>`)
                dataRow.push(`<input type="text" name="peminjam-hp[]" value="${data[3]}" hidden>${data[3]}`)
                dataRow.push(`<input type="text" name="peminjam-alamat[]" value="${data[4]}" hidden>${data[4]}`)
                dataRow.push(`<input type="text" name="penjamin-nama[]" value="${data[5]}" hidden>
                    <input type="text" name="penjamin-nik[]" value="${data[6]}" hidden>${data[5]} (${data[6]})`)
                dataRow.push(`<input type="text" name="penjamin-hp[]" value="${data[7]}" hidden>${data[7]}`)
                dataRow.push(`<input type="text" name="penjamin-alamat[]" value="${data[8]}" hidden>${data[8]}`)
                members.push(dataRow)
                resetTableItems()
            }

            function resetTableItems() {
                table.clear().draw();
                console.log("members", members);
                members.forEach((item, index) => {
                    table.row.add([
                        index + 1,
                        item[0],
                        item[1],
                        item[2],
                        item[3],
                        item[4],
                        item[5],
                        item[6],
                        `<button type="button" class="btn btn-sm btn-danger" data-id="${index}">hapus</button>`
                    ]).draw(false)
                });
            }

            $('.table tbody').on('click', 'button.btn-danger', function(e) {
                let dataId = $(this).data("id")
                members.splice(dataId, 1)
                resetTableItems()
            })

            const btnAddMember = document.getElementById('btn-add-member');
            btnAddMember.addEventListener("click", function() {
                const mPeminjamNama = document.getElementById('m-peminjam-nama')
                const mPeminjamNik = document.getElementById('m-peminjam-nik')
                const mPeminjamJabatan = document.getElementById('m-peminjam-jabatan')
                const mPeminjamHp = document.getElementById('m-peminjam-hp')
                const mPeminjamAlamat = document.getElementById('m-peminjam-alamat')
                const mPenjaminNama = document.getElementById('m-penjamin-nama')
                const mPenjaminNik = document.getElementById('m-penjamin-nik')
                const mPenjaminHp = document.getElementById('m-penjamin-hp')
                const mPenjaminAlamat = document.getElementById('m-penjamin-alamat')

                if (mPeminjamNama.value == "") {
                    alert("Peminjam Nama belum dipilih")
                    return
                };
                if (mPeminjamNik.value == "") {
                    alert("Peminjam NIK belum dipilih")
                    return
                };
                if (mPeminjamJabatan.value == "") {
                    alert("Peminjam Jabatan belum dipilih")
                    return
                };
                if (mPeminjamHp.value == "") {
                    alert("Peminjam HP belum dipilih")
                    return
                };
                if (mPeminjamAlamat.value == "") {
                    alert("Peminjam Alamat belum dipilih")
                    return
                };
                if (mPenjaminNama.value == "") {
                    alert("Penjamin Nama belum dipilih")
                    return
                };
                if (mPenjaminNik.value == "") {
                    alert("Penjamin NIK belum dipilih")
                    return
                };
                if (mPenjaminHp.value == "") {
                    alert("Penjamin HP belum dipilih")
                    return
                };
                if (mPenjaminAlamat.value == "") {
                    alert("Penjamin Alamat belum dipilih")
                    return
                };

                let dataRow = [
                    mPeminjamNama.value,
                    mPeminjamNik.value,
                    mPeminjamJabatan.value,
                    mPeminjamHp.value,
                    mPeminjamAlamat.value,
                    mPenjaminNama.value,
                    mPenjaminNik.value,
                    mPenjaminHp.value,
                    mPenjaminAlamat.value,
                ];

                $.ajax({
                    url: "{{ route('cash-loan.checkmember') }}",
                    type: "POST",
                    data: {
                        'nik': mPeminjamNik.value,
                        'gurantor_nik': mPenjaminNik.value,
                    },
                    success: function(response) {
                        if (response == 1) {
                            addRowData(dataRow)
                            $("#border-less").modal("hide");
                        } else {
                            alert("data anggota bermasalah");
                        }
                    },
                    error: function(err) {
                        console.error(err);
                    }
                })
            })

            $(document).on('click', '#submit-form', function() {
                console.log("members", members);
                if (members.length > 0) {
                    let findKetua = false;
                    members.forEach((item) => {
                        if (item[1].split(" ")[0] == "ketua") findKetua = true;
                    })

                    if (findKetua) {
                        $('#main-form').submit();
                        return
                    }
                    alert("anggota ketua belum ditambahkan");
                } else {
                    alert("data anggota belum ditambahkan");
                }
            })
        });
    </script>

    <script src="{{ asset('mazer/assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script>
        fetch("{{ route('market.json') }}")
            .then(response => response.json())
            .then(data => {
                const mySelectOne = document.getElementById("choices-market");
                const choicesOne = new Choices(mySelectOne, {
                    choices: data.map((item) => {
                        return {
                            value: item.id,
                            label: item.name,
                        }
                    }).filter(item => item !== null),
                });
            })
            .catch(error => console.error(error));
    </script>
@endpush
