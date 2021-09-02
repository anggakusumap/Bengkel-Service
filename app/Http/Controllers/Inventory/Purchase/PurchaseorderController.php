<?php

namespace App\Http\Controllers\Inventory\Purchase;

use App\Http\Controllers\Controller;
use App\Model\Accounting\Akun;
use App\Model\Inventory\Hargasparepart;
use App\Model\Inventory\Purchase\PO;
use App\Model\Inventory\Purchase\POdetail;
use App\Model\Inventory\Sparepart;
use App\Model\Inventory\Supplier;
use App\Model\Kepegawaian\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseorderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $po = PO::with([
            'Supplier','Pegawai'
        ])->get();

        $pokirim = PO::where('status','=','Pending')->get();
        $pocount = PO::where('status','=','Pending')->where('approve_po','=','Approved')->where('approve_ap','=','Approved')->count();

        $id = PO::getId();
        foreach($id as $value);
        $idlama = $value->id_po;
        $idbaru = $idlama + 1;
        $blt = date('y-m');

        $kode_po = 'PO-'.$blt.'/'.$idbaru;

        $supplier = Supplier::all();
        $today = Carbon::now()->isoFormat('dddd');
        $tanggal = Carbon::now()->format('j F Y');

        return view('pages.inventory.purchase.po.po', compact('po','today','tanggal','kode_po','supplier','pokirim','pocount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $supplier = Supplier::where('nama_supplier',$request->nama_supplier)->first();
        $id_supplier = $supplier->id_supplier;

        $po = PO::create([
            'kode_po'=>$request->kode_po,
            'id_supplier'=>$id_supplier,
            'tanggal_po'=>$request->tanggal_po,
            'approve_po'=>'Pending',
            'approve_ap'=>'Pending',
            'id_bengkel' => $request['id_bengkel'] = Auth::user()->id_bengkel
           
        ]);
        
        return $po;

       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_po)
    {
        $po = PO::with('Detailsparepart')->findOrFail($id_po);
        // dd($po);

        return view('pages.inventory.purchase.po.detail')->with([
            'po' => $po
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
        // $po = PO::with([
        //     'Pegawai','Supplier.SparepartRevisi.Merksparepart.Jenissparepart','Detailsparepart','Supplier.SparepartRevisi.Kartugudang','Supplier.SparepartRevisi.Kartugudangterakhir'
        // ])->find($id);

        $po = PO::with([
           'Pegawai','Detailsparepart','Supplier.Sparepart.Merksparepart.Jenissparepart','Supplier.Sparepart.Kartugudang','Supplier.Sparepart.Kartugudangterakhir'
        ])->find($id);

        // return $po;

        $sparepart = Sparepart::all();
       
        for($i = 0;  $i < count($po->Detailsparepart); $i++ ){
            for($j = 0;  $j < count($po->Supplier->Sparepart); $j++ ){
               if ($po->Detailsparepart[$i]->id_sparepart == $po->Supplier->Sparepart[$j]->id_sparepart ){
                $po->Supplier->Sparepart[$j]->qty = $po->Detailsparepart[$i]->pivot->qty;
                $po->Supplier->Sparepart[$j]->harga_satuan = $po->Detailsparepart[$i]->pivot->harga_satuan;
               };
            }
        }
        return view('pages.inventory.purchase.po.create', compact('po','sparepart'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_po)
    {
        
        $po = PO::findOrFail($id_po);

        if($po->approve_po == 'Not Approved' && $po->approve_ap == 'Pending' || $po->approve_po == 'Not Approved' && $po->approve_ap == 'Not Approved' || $po->approve_po == 'Not Approved' && $po->approve_ap == 'Approved' || $po->approve_po == 'Approved' && $po->approve_ap == 'Not Approved'){
            $po->id_pegawai = $request['id_pegawai'] = Auth::user()->pegawai->id_pegawai;
            $po->kode_po = $request->kode_po;
            $po->tanggal_po = $request->tanggal_po;
            $temp = 0;
            foreach($request->sparepart as $key=>$item){
                $temp = $temp + $item['total_harga'];
            }
    
            $po->grand_total = $temp;
            $po->approve_po = 'Pending';
            $po->approve_ap = 'Pending';
          
            
            $po->update();
            $po->Detailsparepart()->sync($request->sparepart);
            return $request;
        }else{
            $po->id_pegawai = $request['id_pegawai'] = Auth::user()->pegawai->id_pegawai;
            $po->kode_po = $request->kode_po;
            $po->tanggal_po = $request->tanggal_po;
            $temp = 0;
            foreach($request->sparepart as $key=>$item){
                $temp = $temp + $item['total_harga'];
            }
    
            $po->grand_total = $temp;
          
            
            $po->update();
            $po->Detailsparepart()->sync($request->sparepart);
            return $request;
        }


       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_po)
    {
        $PO = PO::findOrFail($id_po);
        
        POdetail::where('id_po', $id_po)->delete();
        $PO->delete();

        return redirect()->back()->with('messagehapus','Data Pembelian Berhasil dihapus');
    }

    public function setStatus(Request $request, $id_po)
    {
        $request->validate([
            'status' => 'required|in:Dikirim,Diterima'
        ]);

        $item = PO::findOrFail($id_po);
        $item->status = $request->status;
 
        $item->save();
        return redirect()->route('purchase-order.index')->with('messagekirim','Data Pembelian Berhasil dikirim ke Supplier');
    }

    public function CetakPO($id_po)
    {
        $po = PO::with('Detailsparepart')->findOrFail($id_po);
        // return $pelayanan;
        $now = Carbon::now();
        return view('print.Inventory.cetakpo', compact('po','now'));
    }

}
