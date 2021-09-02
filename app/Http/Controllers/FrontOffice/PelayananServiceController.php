<?php

namespace App\Http\Controllers\FrontOffice;

use App\Model\FrontOffice\PelayananService;
use App\Http\Controllers\Controller;
use App\Model\FrontOffice\DetailPenerimaanServiceJasa;
use App\Model\FrontOffice\DetailPenerimaanServiceSparepart;
use App\Model\FrontOffice\MasterDataPitstop;
use App\Model\Service\PenerimaanService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelayananServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pelayanan = PenerimaanService::with(['customer_bengkel', 'kendaraan', 'pegawai', 'mekanik', 'pitstop'])->orderBy('id_service_advisor', 'DESC')->get();
        $pitstop = MasterDataPitstop::where('id_bengkel', Auth::user()->id_bengkel)->get();
        // return $pelayanan;
        $now = Carbon::now();
        return view('pages.frontoffice.pelayanan_service.main', compact('pelayanan', 'now', 'pitstop'));
    }

    public function cetakWorkOrder($id_service_advisor)
    {
        $cetak_wo = PenerimaanService::with('kendaraan', 'customer_bengkel', 'detail_sparepart', 'detail_perbaikan', 'bengkel')->findOrFail($id_service_advisor);
        // return $pelayanan;
        $now = Carbon::now();
        return view('print.FrontOffice.cetak-work-order', compact('cetak_wo', 'now'));
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
    public function store(Request $request, $id)
    {
        // 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PelayananService  $pelayananService
     * @return \Illuminate\Http\Response
     */
    public function show($id_service_advisor)
    {
        $pelayanan = PenerimaanService::with('kendaraan', 'customer_bengkel', 'mekanik','pitstop', 'detail_sparepart.Merksparepart','detail_sparepart.Jenissparepart',
        'detail_sparepart', 'detail_perbaikan', 'bengkel')->find($id_service_advisor);
        
        return view('pages.frontoffice.pelayanan_service.show',compact('pelayanan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PelayananService  $pelayananService
     * @return \Illuminate\Http\Response
     */
    public function edit(PelayananService $pelayananService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PelayananService  $pelayananService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PenerimaanService $id_service_advisor)
    {
        // $pitstop = PenerimaanService::where('id_service_advisor', $id_service_advisor)->get();
        $pitstop = PenerimaanService::findOrFail($id_service_advisor);
        return $id_service_advisor;
    }

    public function status(Request $request, $id_service_advisor)
    {
        $pitstop = PenerimaanService::findOrFail($id_service_advisor);
        $pitstop->status = 'dikerjakan';
        $pitstop->id_pitstop = $request->pitstop;

        $pitstop->update();
        return redirect()->back()->with('messageberhasil', 'Kendaraan berhasil dikerjakan');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PelayananService  $pelayananService
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_service_advisor)
    {
        $pelayanan = PenerimaanService::findOrFail($id_service_advisor);
        DetailPenerimaanServiceJasa::where('id_service_advisor', $id_service_advisor)->delete();
        DetailPenerimaanServiceSparepart::where('id_service_advisor', $id_service_advisor)->delete();

        $pelayanan->delete();
        // return $pelayanan;

        return redirect()->back()->with('messagehapus', 'Data Pelayanan Service Berhasil dihapus');
    }
}
