@extends('layouts.Admin.admininventory')

@section('content')
{{-- HEADER --}}
<main>
    <div class="container mt-5">
        <!-- Custom page header alternative example-->
        <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
            <div class="mr-4 mb-3 mb-sm-0">
                <h1 class="mb-0">Penerimaan Pembelian Sparepart</h1>
                <div class="small">
                    <span class="font-weight-500 text-primary">{{ $today }}</span>
                    · Tanggal {{ $tanggal }} · <span id="clock">12:16 PM</span>
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
        <div class="card card-header-actions h-100">
            <div class="card-header">
                Daftar Pembelian Yang Belum Datang
            </div>
            <div class="card-body">
                <div class="timeline timeline-xs">
                    <!-- Timeline Item 1-->
                    @forelse ($po as $item)
                    <div class="timeline-item">
                        <div class="timeline-item-marker">
                            <div class="timeline-item-marker-text">New</div>
                            <div class="timeline-item-marker-indicator bg-green"></div>
                        </div>
                        <div class="timeline-item-content">
                            Pembelian Baru! {{ $item->tanggal_po }}
                            <a class="font-weight-bold text-dark" href="{{ route('Rcv-detail-po',$item->id_po) }}"
                                data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="Cek Detail Pembelian">Order {{ $item->kode_po }}</a>
                            Pada Supplier {{ $item->Supplier->nama_supplier }}
                        </div>
                    </div>
                    @empty
                    <div class="timeline-item">
                        <div class="timeline-item-marker">
                            <div class="timeline-item-marker-text">Empty</div>
                            <div class="timeline-item-marker-indicator bg-red"></div>
                        </div>
                        <div class="timeline-item-content">
                            Sementara Tidak ada Data Pembelian
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card mb-4">
        <div class="card card-header-actions">
            <div class="card-header">List Penerimaan
                <a href="" class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#Modaltambah">
                    Tambah Penerimaan
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
                                            style="width: 80px;">Kode Rcv</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Office: activate to sort column ascending"
                                            style="width: 100px;">Pegawai</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Office: activate to sort column ascending"
                                            style="width: 100px;">Supplier</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Start date: activate to sort column ascending"
                                            style="width: 50px;">Nomor Do</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                            style="width: 40px;">Tanggal</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Actions: activate to sort column ascending"
                                            style="width: 90px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($rcv as $item)
                                    <tr role="row" class="odd">
                                        <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}</th>
                                        <td>{{ $item->kode_rcv }}</td>
                                        <td>{{ $item->Pegawai->nama_pegawai ?? '' }}</td>
                                        <td>{{ $item->Supplier->nama_supplier }}</td>
                                        <td>{{ $item->no_do }}</td>
                                        <td>{{ $item->tanggal_rcv }}</td>
                                        <td>
                                            <a href="{{ route('Rcv.show', $item->id_rcv) }}"
                                                class="btn btn-secondary btn-datatable" data-toggle="tooltip"
                                                data-placement="top" title="" data-original-title="Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('Rcv.edit', $item->id_rcv) }}"
                                                class="btn btn-primary btn-datatable" data-toggle="tooltip"
                                                data-placement="top" title="" data-original-title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="" class="btn btn-danger btn-datatable" type="button"
                                                data-toggle="modal" data-target="#Modalhapus-{{ $item->id_rcv }}">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <a href="{{ route('cetak-rcv', $item->id_rcv) }}" target="_blank"
                                                class="btn btn-info btn-datatable" data-toggle="tooltip"
                                                data-placement="top" title="" data-original-title="Cetak Data Rcv">
                                                <i class="fas fa-print"></i></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            Data Penerimaan Kosong
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
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Data Penerimaan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form action="{{ route('Rcv.store') }}" method="POST" id="form1" class="d-inline">
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
                        <div class="form-group col-md-6">
                            <label class="small mb-1 mr-1" for="kode_po">Kode PO</label><span class="mr-4 mb-3"
                                style="color: red">*</span>
                            <div class="input-group input-group-joined">
                                <input class="form-control" type="text" placeholder="Masukan Kode PO"
                                    aria-label="Search" id="detailkodepo">
                                <div class="input-group-append">
                                    <a href="" class="input-group-text" type="button" data-toggle="modal"
                                        data-target="#Modalpo">
                                        <i class="fas fa-folder-open"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="small" id="alertkodepo" style="display:none">
                                <span class="font-weight-500 text-danger">Error! Anda Belum Menambahkan Kode PO!</span>
                                <button class="close" type="button" onclick="$(this).parent().hide()"
                                    aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="id_supplier">Supplier</label>
                            <input class="form-control" id="detailsupplier" type="text" name="id_supplier"
                                placeholder="" value="{{ old('id_supplier') }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="small mb-1 mr-1" for="no_do">Nomor DO</label><span class="mr-4 mb-3"
                                style="color: red">*</span>
                            <input class="form-control" id="no_do" type="text" name="no_do"
                                placeholder="Input Nomor Delivery" value="{{ old('no_do') }}"
                                class="form-control @error('no_do') is-invalid @enderror" />
                            @error('no_do')<div class="text-danger small mb-1">{{ $message }}
                            </div> @enderror
                            <div class="small" id="alertdo" style="display:none">
                                <span class="font-weight-500 text-danger">Error! Anda Belum Mengisi Nomor Delivery
                                    Order!</span>
                                <button class="close" type="button" onclick="$(this).parent().hide()"
                                    aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="small mb-1 mr-1" for="tanggal_rcv">Tanggal Receive</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <input class="form-control" id="tanggal_rcv" type="date" name="tanggal_rcv"
                                placeholder="Input Tanggal Receive" value="{{ old('tanggal_rcv') }}"
                                class="form-control @error('tanggal_rcv') is-invalid @enderror" />
                            @error('tanggal_rcv')<div class="text-danger small mb-1">{{ $message }}
                            </div> @enderror
                            <div class="small" id="alerttanggal" style="display:none">
                                <span class="font-weight-500 text-danger">Error! Tanggal Belum Terisi!</span>
                                <button class="close" type="button" onclick="$(this).parent().hide()"
                                    aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
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
<div class="modal fade" id="Modalpo" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light ">
                <h5 class="modal-title">Pilih Kode Pembelian Sparepart</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="datatable">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover dataTable" id="dataTablePO" width="100%" cellspacing="0"
                                role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                        aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                        style="width: 30px;">No.</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                            aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                            style="width: 70px;">Kode PO</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                            aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                            style="width: 70px;">Tanggal PO</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending" style="width: 80px;">Supplier</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending" style="width: 50px;">Telephone</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                            aria-label="Office: activate to sort column ascending" style="width: 50px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($po as $item)
                                    <tr id="item-{{ $item->id_po }}">
                                        <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}</th>
                                        <td><div class="kode_po">{{ $item->kode_po }}</div></td>
                                        <td>{{ $item->tanggal_po }}</td>
                                        <td><div class="nama_supplier">{{ $item->Supplier->nama_supplier }}</div></td>
                                        <td>{{ $item->Supplier->telephone }}</td>
                                        <td class="text-center"><button class="btn btn-success btn-xs" 
                                            onclick="tambahpo(event, {{ $item->id_po }})" type="button" 
                                            data-dismiss="modal">Tambah</button>
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




{{-- MODAL HAPUS --}}
@forelse ($rcv as $item)
<div class="modal fade" id="Modalhapus-{{ $item->id_rcv }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger-soft">
                <h5 class="modal-title" id="exampleModalCenterTitle">Konfirmasi Hapus Data</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form action="{{ route('Rcv.destroy', $item->id_rcv) }}" method="POST" class="d-inline">
                @csrf
                @method('delete')
                <div class="modal-body text-center">Apakah Anda Yakin Menghapus Data Penerimaan <b>{{ $item->kode_rcv }}</b>  pada tanggal
                    {{ $item->tanggal_rcv }}?</div>
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
    // FUNGSI TAMBAH PO
    function tambahpo(event, id_po) {
        var data = $('#item-' + id_po)
        var _token = $('#form1').find('input[name="_token"]').val()
        var kode_po = $(data.find('.kode_po')[0]).text()
        var nama_supplier = $(data.find('.nama_supplier')[0]).text()
        alert('Berhasil Menambahkan Data PO')

        $('#detailkodepo').val(kode_po)
        $('#detailsupplier').val(nama_supplier)
        console.log(kode_po);
    }

    // FUNGSI TAMBAH AJAX
    function submit1() {
        var _token = $('#form1').find('input[name="_token"]').val()
        var no_do = $('#no_do').val()
        var tanggal_rcv = $('#tanggal_rcv').val()
        var kode_po = $('#detailkodepo').val()
        var nama_supplier = $('#detailsupplier').val()
        var data = {
            _token: _token,
            kode_po: kode_po,
            nama_supplier: nama_supplier,
            no_do: no_do,
            tanggal_rcv: tanggal_rcv
        }

        if (kode_po == 0 | kode_po == '') {
            $('#alertkodepo').show()
        } else if (no_do == 0 | no_do == '')
            $('#alertdo').show()
        else if (tanggal_rcv == 0 | tanggal_rcv == '')
            $('#alerttanggal').show()

        else {

            $.ajax({
                method: 'post',
                url: "/inventory/receiving",
                data: data,
                success: function (response) {
                    window.location.href = '/inventory/receiving/' + response.id_rcv + '/edit'
                },
                error: function (error) {
                    console.log(error)
                }

            });
        }

    }
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

    $(document).ready(function () {
        $('#dataTablePO').DataTable()
    });

</script>





@endsection
