@extends('layouts.Admin.adminfrontoffice')

@section('content')
{{-- HEADER --}}
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-cog"></i></div>
                            Edit Data Kendaraan
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a href="{{ route('kendaraan.index') }}"
                            class="btn btn-sm btn-light text-primary mr-2">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <div class="container">
        <div class="card">
            <div class="card-header border-bottom">
                <div class="nav nav-pills nav-justified flex-column flex-xl-row nav-wizard" id="cardTab" role="tablist">
                    <!-- Wizard navigation item 1-->
                    <a class="nav-item nav-link active" id="wizard1-tab" href="#wizard1" data-toggle="tab" role="tab"
                        aria-controls="wizard1" aria-selected="true">
                        <div class="wizard-step-icon"><i class="fas fa-plus"></i></div>
                        <div class="wizard-step-text">
                            <div class="wizard-step-text-name">Formulir Kendaraan</div>
                            <div class="wizard-step-text-details">Lengkapi formulir berikut</div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- CARD 1 --}}
            <div class="card-body">
                <div class="tab-content" id="cardTabContent">
                    <!-- Wizard tab pane item 1-->
                    <div class="tab-pane py-5 py-xl-5 fade show active" id="wizard1" role="tabpanel"
                        aria-labelledby="wizard1-tab">
                        <div class="row justify-content-center">
                            <div class="col-xxl-6 col-xl-8">
                                <h3 class="text-primary">{{ $item->nama_kendaraan }}</h3>
                                <h5 class="card-title">Ubah Data Kendaraan</h5>
                                <form action="{{ route('kendaraan.update',$item->id_kendaraan) }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="small mb-1 mr-1" for="kode_kendaraan">Kode
                                                Kendaraan</label><span class="mr-4 mb-3" style="color: red">*</span>
                                            <input class="form-control" id="kode_kendaraan" type="text"
                                                name="kode_kendaraan" value="{{ $item->kode_kendaraan }}" readonly />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="small mb-1 mr-1" for="nama_kendaraan">Nama
                                                kendaraan</label><span class="mr-4 mb-3" style="color: red">*</span>
                                            <input class="form-control" id="nama_kendaraan" type="text"
                                                name="nama_kendaraan" value="{{ $item->nama_kendaraan }}" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="small mb-1 mr-1" for="id_jenis_kendaraan">Jenis
                                                Kendaraan</label><span class="mr-4 mb-3" style="color: red">*</span>
                                            <select class="form-control" name="id_jenis_kendaraan"
                                                id="id_jenis_kendaraan">
                                                <option value="{{ $item->jenis_kendaraan->id_jenis_kendaraan }}">
                                                    {{ $item->jenis_kendaraan->jenis_kendaraan }}</option>
                                                @foreach ($jenis_kendaraan as $jenis_kendaraan)
                                                <option value="{{ $jenis_kendaraan->id_jenis_kendaraan }}">
                                                    {{ $jenis_kendaraan->jenis_kendaraan }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="small mb-1 mr-1" for="id_merk_kendaraan">Merk Kendaraan</label><span
                                                class="mr-4 mb-3" style="color: red">*</span>
                                            <select class="form-control" name="id_merk_kendaraan" id="id_merk_kendaraan">
                                                <option value="{{ $item->merk_kendaraan->id_merk_kendaraan }}">
                                                    {{ $item->merk_kendaraan->merk_kendaraan }}</option>
                                                @foreach ($merk_kendaraan as $merk_kendaraan)
                                                <option value="{{ $merk_kendaraan->id_merk_kendaraan }}">
                                                    {{ $merk_kendaraan->merk_kendaraan }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="my-4" />
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-light" type="button">Back</button>
                                        <button class="btn btn-primary" type="Submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection
