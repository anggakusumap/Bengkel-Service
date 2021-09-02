<?php

namespace App\Http\Controllers\Inventory\Opname;

use App\Http\Controllers\Controller;
use App\Model\Inventory\Stockopname\Opname;
use Illuminate\Http\Request;

class ApprovalopnameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $opname = Opname::with([
            'Pegawai',
        ])->get();

        return view('pages.inventory.stockopname.approval.approval', compact('opname'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_opname)
    {
        $opname = Opname::with('Detailsparepart')->findOrFail($id_opname);

        return view('pages.inventory.stockopname.approval.detailapproval')->with([
            'opname' => $opname
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function setStatus(Request $request, $id_opname)
    {
        $request->validate([
            'status' => 'required|in:Approved,Not Approved,Pending'
        ]);

        $item = Opname::findOrFail($id_opname);
        $item->approve = $request->status;
        $item->keterangan_approval = $request->keterangan_approval;

        $item->save();
        return redirect()->route('approval-opname.index');
    }
}
