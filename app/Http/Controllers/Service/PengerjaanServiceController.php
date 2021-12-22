<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Model\FrontOffice\CustomerBengkel;
use App\Model\FrontOffice\MasterDataJenisPerbaikan;
use App\Model\FrontOffice\MasterDataKendaraan;
use App\Model\Inventory\DetailSparepart;
use App\Model\Inventory\Kartugudang\Kartugudang;
use App\Model\Inventory\Sparepart;
use App\Model\Kepegawaian\Jabatan;
use App\Model\Kepegawaian\Pegawai;
use App\Model\Service\PenerimaanService;
use App\Model\Service\PengerjaanService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengerjaanServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->pegawai->cabang == null){
            $pengerjaan = PenerimaanService::with(['customer_bengkel', 'kendaraan', 'pegawai', 'mekanik', 'pitstop'])->where('id_bengkel', Auth::user()->id_bengkel)->where('id_cabang','=', null)->orderBy('id_service_advisor', 'DESC')->get();
        }else{
            $pengerjaan = PenerimaanService::with(['customer_bengkel', 'kendaraan', 'pegawai', 'mekanik', 'pitstop'])->where('id_bengkel', Auth::user()->bengkel->id_bengkel)->where('id_cabang', Auth::user()->pegawai->cabang->id_cabang)->orderBy('id_service_advisor', 'DESC')->get();
        }

        // return $pengerjaan;
        return view('pages.service.pengerjaan_service.main', compact('pengerjaan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PengerjaanService  $pengerjaanService
     * @return \Illuminate\Http\Response
     */
    public function show($id_service_advisor)
    {
        $pelayanan = PenerimaanService::with('kendaraan', 'customer_bengkel', 'mekanik','pitstop', 'detail_sparepart.Merksparepart','detail_sparepart.Jenissparepart',
        'detail_sparepart', 'detail_perbaikan', 'bengkel')->find($id_service_advisor);

        return view('pages.service.pengerjaan_service.show',compact('pelayanan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PengerjaanService  $pengerjaanService
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id_service_advisor)
    {
        $service_advisor = PenerimaanService::with('kendaraan', 'customer_bengkel', 'mekanik','pitstop', 'detail_sparepart.Merksparepart','detail_sparepart.Jenissparepart',
        'detail_sparepart', 'detail_perbaikan', 'bengkel')->find($id_service_advisor);

        $kendaraan = MasterDataKendaraan::with('JenisBengkel')
        ->where('id_jenis_bengkel','=',Auth::user()->Bengkel->id_jenis_bengkel)
        ->get();

        $customer_bengkel = CustomerBengkel::all();
        $sparepart = DetailSparepart::with('Sparepart','Kartugudangpenjualan')->where('qty_stok', '>', 0)->get();
        $pegawai = Pegawai::all();
        $jasa_perbaikan = MasterDataJenisPerbaikan::with('JenisBengkel')
        ->where('id_jenis_bengkel','=',Auth::user()->Bengkel->id_jenis_bengkel)
        ->get();
        
        $date = Carbon::today()->toDateString();

        $mekanik = Jabatan::with('pegawai.absensi_mekanik')->where('nama_jabatan', 'Mekanik')->get();
        $mekanik_asli = $mekanik[0]->pegawai;

        return view('pages.service.pengerjaan_service.edit', compact('service_advisor', 'kendaraan', 'customer_bengkel', 'pegawai', 'sparepart', 'jasa_perbaikan', 'mekanik_asli', 'date'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PengerjaanService  $pengerjaanService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_service_advisor)
    {
        $service = PenerimaanService::find($id_service_advisor);
        $service->kode_sa = $request->kode_sa;
        $service->id_customer_bengkel = $request->id_customer_bengkel;
        $service->id_kendaraan = $request->id_kendaraan;
        $service->odo_meter =  $request->odo_meter;
        $service->date =  $request->date;
        $service->plat_kendaraan =  $request->plat_kendaraan;
        $service->keluhan_kendaraan =  $request->keluhan_kendaraan;
        $service->id_mekanik =  $request->id_mekanik;
        $service->status =  'menunggu';
        $service->waktu_estimasi =  $request->waktu_estimasi;

        $temp1 = 0;
        foreach ($request->sparepart as $key => $item1) {
            $temp1 = $temp1 + $item1['total_harga'];
            $sparepart = DetailSparepart::where('id_sparepart', $item1['id_sparepart'])->first();
            $sparepart->qty_stok = $sparepart->qty_stok - $item1['jumlah'];

            if ($sparepart->qty_stok >= $sparepart->stok_min) {
                $sparepart->status_jumlah = 'Cukup';
            } else if ($sparepart->qty_stok == 0) {
                $sparepart->status_jumlah = 'Habis';
            } else {
                $sparepart->status_jumlah = 'Kurang';
            }
            $sparepart->save();

            $kartu_gudang = new Kartugudang;
            $kartu_gudang->id_bengkel = $request['id_bengkel'] = Auth::user()->id_bengkel;

            $kartugudangterakhir =  $sparepart->Kartugudangsaldoakhir;
            if ($kartugudangterakhir != null)
                $kartu_gudang->saldo_akhir = $kartugudangterakhir->saldo_akhir - $item1['jumlah'];

            if ($kartugudangterakhir == null)
                $kartu_gudang->saldo_akhir = $item1['jumlah'];

            $kartu_gudang->jumlah_keluar = $kartu_gudang->jumlah_keluar + $item1['jumlah'];
            $kartu_gudang->harga_beli = $kartu_gudang->harga + $item1['harga'];
            $kartu_gudang->id_detail_sparepart = $sparepart->id_detail_sparepart;
            $kartu_gudang->kode_transaksi = $service->kode_sa;
            $kartu_gudang->tanggal_transaksi = $service->date;
            $kartu_gudang->jenis_kartu = 'Penjualan';
            $kartu_gudang->save();
        }

        $temp2 = 0;
        foreach ($request->jasa_perbaikan as $key => $item2) {
            $temp2 = $temp2 + $item2['total_harga'];
        }

        $service->total_bayar = $temp1 + $temp2;


        $service->save();
        $service->detail_sparepart()->sync($request->sparepart);
        $service->detail_perbaikan()->sync($request->jasa_perbaikan);

        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PengerjaanService  $pengerjaanService
     * @return \Illuminate\Http\Response
     */
    public function destroy(PengerjaanService $pengerjaanService)
    {
        //
    }

    public function Updateservice($id_service_advisor){
        $service = PenerimaanService::find($id_service_advisor);
        $service->status =  'selesai_service';
        

        $service->update();

        return redirect()->back();
    }
}
