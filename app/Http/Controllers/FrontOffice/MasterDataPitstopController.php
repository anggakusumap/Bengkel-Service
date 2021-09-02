<?php

namespace App\Http\Controllers\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\FrontOffice\Pitstoprequest;
use Illuminate\Http\Request;
use App\Model\FrontOffice\MasterDataPitstop;
use Illuminate\Support\Facades\Auth;

class MasterDataPitstopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pitstop = MasterDataPitstop::get();

        $id = MasterDataPitstop::getId();
        foreach ($id as $value);
        $idlama = $value->id_pitstop;
        $idbaru = $idlama + 1;
        $blt = date('m');

        $kode_pitstop = 'PS-' . $idbaru . '/' . $blt;

        return view('pages.frontoffice.masterdata.pitstop.index', compact('pitstop', 'kode_pitstop'));
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
    public function store(Pitstoprequest $request)
    {
        $request['id_bengkel'] = Auth::user()->id_bengkel;
        $data = $request->all();

        MasterDataPitstop::create($data);
        return redirect()->route('pitstop.index')->with('messageberhasil', 'Data Pit Stop Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MasterDataPitstop  $masterDataPitstop
     * @return \Illuminate\Http\Response
     */
    public function show(MasterDataPitstop $masterDataPitstop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MasterDataPitstop  $masterDataPitstop
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterDataPitstop $masterDataPitstop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MasterDataPitstop  $masterDataPitstop
     * @return \Illuminate\Http\Response
     */
    public function update(Pitstoprequest $request, $id_pitstop)
    {
        $pitstop = MasterDataPitstop::findOrFail($id_pitstop);
        $pitstop->kode_pitstop = $request->kode_pitstop;
        $pitstop->nama_pitstop = $request->nama_pitstop;

        $pitstop->update();
        return redirect()->back()->with('messageberhasil', 'Data Pit Stop Berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MasterDataPitstop  $masterDataPitstop
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_pitstop)
    {
        $pitstop = MasterDataPitstop::findOrFail($id_pitstop);
        $pitstop->delete();

        return redirect()->back()->with('messagehapus', 'Data Pit Stop Berhasil dihapus');
    }
}
