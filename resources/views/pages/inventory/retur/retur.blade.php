@extends('layouts.Admin.admininventory')

@section('content')
{{-- HEADER --}}
<main>
    <div class="container mt-5">
        <!-- Custom page header alternative example-->
        <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
            <div class="mr-4 mb-3 mb-sm-0">
                <h1 class="mb-0">Retur Pembelian Sparepart</h1>
                <div class="small">
                    <span class="font-weight-500 text-primary">{{ $today }}</span>
                    · Tanggal {{ $tanggal }} · <span id="clock"> 12:16 PM</span>
                </div>
            </div>
            <div class="small">
                <i class="fa fa-cogs" aria-hidden="true"></i>
                Bengkel
                <span class="font-weight-500 text-primary">{{ Auth::user()->bengkel->nama_bengkel}}</span>
                <hr>
                </hr>
            </div>
        </div>
    </div>
</main>


<div class="container-fluid">
    <div class="card mb-4">
        <div class="card card-header-actions">
            <div class="card-header ">List Retur
                <a href="" class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#Modaltambah">
                    Tambah Retur
                </a>
            </div>
        </div>
        <div class="card-body ">
            <div class="datatable">
                @if(session('messageberhasil'))
                <div class="alert alert-success" role="alert"> <i class="fas fa-check"></i>
                    {{ session('messageberhasil') }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endif
                @if(session('messagehapus'))
                <div class="alert alert-danger" role="alert"> <i class="fas fa-check"></i>
                    {{ session('messagehapus') }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endif

                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-hover dataTable" id="dataTable" width="100%"
                                cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending" style="width: 20px;">
                                            No</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Position: activate to sort column ascending"
                                            style="width: 80px;">Kode Retur</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Office: activate to sort column ascending"
                                            style="width: 110px;">Pegawai</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Office: activate to sort column ascending"
                                            style="width: 140px;">Supplier</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Start date: activate to sort column ascending"
                                            style="width: 50px;">Tanggal</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                            style="width: 30px;">Status</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                            style="width: 10px;">Cetak</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Actions: activate to sort column ascending"
                                            style="width: 90px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($retur as $item)
                                    <tr role="row" class="odd">
                                        <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}</th>
                                        <td>{{ $item->kode_retur }}</td>
                                        <td>{{ $item->Pegawai->nama_pegawai ?? '' }}</td>
                                        <td>{{ $item->Supplier->nama_supplier ?? '' }}</td>
                                        <td>{{ $item->tanggal_retur }}</td>
                                        <td class="text-center">
                                            @if($item->status == 'Aktif')
                                            <span class="badge badge-success">
                                                @elseif($item->status == 'Tidak Aktif')
                                                <span class="badge badge-danger">
                                                    @else
                                                    <span>
                                                        @endif
                                                        {{ $item->status }}
                                                    </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('cetak-retur', $item->id_retur) }}" target="_blank" class="btn btn-primary btn-datatable" data-toggle="tooltip"
                                                data-placement="top" title="" data-original-title="Cetak Retur">
                                                <i class="fas fa-print"></i></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('retur.show', $item->id_retur) }}"
                                                class="btn btn-secondary btn-datatable" data-toggle="tooltip"
                                                data-placement="top" title="" data-original-title="Detail Retur">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('retur.edit', $item->id_retur) }}" class="btn btn-primary btn-datatable" data-toggle="tooltip"
                                                data-placement="top" title="" data-original-title="Edit Retur">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="" class="btn btn-danger btn-datatable" type="button"
                                                data-toggle="modal" data-target="#Modalhapus-{{ $item->id_retur }}">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            Data Retur Kosong
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>


{{-- MODAL TAMBAH --}}
<div class="modal fade" id="Modaltambah" tabindex="-1" role="dialog" data-backdrop="static"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Data Retur</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form action="{{ route('retur.store') }}" method="POST" id="form1" class="d-inline">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-danger" id="alertdatakosong" role="alert" style="display:none"> <i
                        class="fas fa-times"></i>
                    Error! Terdapat Data yang Masih Kosong!
                    <button class="close" type="button" onclick="$(this).parent().hide()" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    </div>
                    <label class="small mb-1">Isikan Form Dibawah Ini</label>
                    <hr>
                    </hr>
                    <div class="row">
                        <div class="form-group col-md-7">
                            <label class="small mb-1" for="id_Rcv">Supplier</label>
                            <div class="input-group input-group-joined">
                                <input class="form-control" type="text" placeholder="Pilih Supplier" aria-label="Search"
                                    id="detailsupplier">
                                <div class="input-group-append">
                                    <a href="" class="input-group-text" type="button" data-toggle="modal"
                                        data-target="#Modalsupplier">
                                        <i class="fas fa-folder-open"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="small" id="alertsupplier" style="display:none">
                                <span class="font-weight-500 text-danger">Error! Anda Belum Menambahkan Supplier!</span>
                                <button class="close" type="button" onclick="$(this).parent().hide()" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        </div>
                        <div class="form-group col-md-5">
                            <label class="small mb-1" for="telephone">Nomor Telp.</label>
                            <input class="form-control" id="detailtelephone" type="text" name="telephone" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="small mb-1" for="tanggal_retur">Tanggal Retur</label>
                        <input class="form-control" id="tanggal_retur" type="date" name="tanggal_retur"
                            placeholder="Input Tanggal Receive" value="{{ old('tanggal_retur') }}"
                            class="form-control @error('tanggal_retur') is-invalid @enderror" />
                        @error('tanggal_retur')<div class="text-danger small mb-1">{{ $message }}
                        </div> @enderror
                        <div class="small" id="alerttanggal" style="display:none">
                            <span class="font-weight-500 text-danger">Error! Tanggal Belum Terisi!</span>
                            <button class="close" type="button" onclick="$(this).parent().hide()" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" onclick="submit1()" type="button">Selanjutnya!</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL PO --}}
<div class="modal fade" id="Modalsupplier" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header bg-light ">
                <h5 class="modal-title">Pilih Supplier</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="datatable">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover dataTable" id="dataTableSupplier" width="100%"
                                    cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending" style="width: 20px;">
                                                No</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 80px;">Kode Supplier</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 140px;">Supplier</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 50px;">Telephone Supplier</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 100px;">Alamat</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Actions: activate to sort column ascending"
                                                style="width: 90px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($supplier as $item)
                                        <tr id="item-{{ $item->id_supplier }}" role="row" class="odd">
                                            <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}</th>
                                            <td class="kode_supplier">{{ $item->kode_supplier }}</td>
                                            <td class="nama_supplier">{{ $item->nama_supplier }}</td>
                                            <td class="telephone">{{ $item->telephone }}</td>
                                            <td class="alamat_supplier">{{ $item->alamat_supplier }}</td>
                                            <td>
                                                <button class="btn btn-success btn-sm"
                                                    onclick="tambahsupplier(event, {{ $item->id_supplier }})" type="button"
                                                    data-dismiss="modal">Tambah
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                       
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@forelse ($retur as $item)
<div class="modal fade" id="Modalhapus-{{ $item->id_retur }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger-soft">
                <h5 class="modal-title" id="exampleModalCenterTitle">Konfirmasi Hapus Data</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form action="{{ route('retur.destroy', $item->id_retur) }}" method="POST" class="d-inline">
                @csrf
                @method('delete')
                <div class="modal-body text-center">Apakah Anda Yakin Menghapus Data Retur <b>{{ $item->kode_retur }}</b> pada tanggal
                    {{ $item->tanggal_retur }}?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-danger" type="submit">Ya! Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@empty

@endforelse



<script>
    function tambahsupplier(event, id_supplier) {
        var data = $('#item-' + id_supplier)
        var _token = $('#form1').find('input[name="_token"]').val()
        var nama_supplier = $(data.find('.nama_supplier')[0]).text()
        var telephone = $(data.find('.telephone')[0]).text()
        alert('Berhasil Menambahkan Data Supplier')
        // $("#toast").toast("show");

        $('#detailsupplier').val(nama_supplier)
        $('#detailtelephone').val(telephone)
    }

    function submit1() {
        var _token = $('#form1').find('input[name="_token"]').val()
        var nama_supplier = $('#detailsupplier').val()
        var tanggal_retur = $('#tanggal_retur').val()
        
        var data = {
            _token: _token,
            nama_supplier: nama_supplier,
            tanggal_retur: tanggal_retur,
        }

        if (nama_supplier == 0 | nama_supplier == '') {
            $('#alertsupplier').show()
        } else if (tanggal_retur == 0 | tanggal_retur == '')
            $('#alerttanggal').show()
        else {
            $.ajax({
                method: 'post',
                url: '/inventory/retur',
                data: data,
                success: function (response) {
                    window.location.href = '/inventory/retur/' + response.id_retur + '/edit'
                },
                error: function (error) {
                    console.log(error)
                }

            });
        }
    }

    $(document).ready(function () {
        var table = $('#dataTableSupplier').DataTable({
            "pageLength": 5,
            "lengthMenu": [
                [5, 10, 20, -1],
                [5, 10, 20, ]
            ]
        })
    });

    setInterval(displayclock, 500);

    function displayclock() {
        var time = new Date()
        var hrs = time.getHours()
        var min = time.getMinutes()
        var sec = time.getSeconds()
        var en = 'AM';

        if (hrs > 12) {
            en = 'PM'
        }

        if (hrs > 12) {
            hrs = hrs - 12;
        }

        if (hrs == 0) {
            hrs = 12;
        }

        if (hrs < 10) {
            hrs = '0' + hrs;
        }

        if (min < 10) {
            min = '0' + min;
        }

        if (sec < 10) {
            sec = '0' + sec;
        }

        document.getElementById('clock').innerHTML = hrs + ':' + min + ':' + sec + ' ' + en;
    }

</script>
@endsection
