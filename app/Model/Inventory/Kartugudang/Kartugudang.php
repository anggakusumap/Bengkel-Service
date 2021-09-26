<?php

namespace App\Model\Inventory\Kartugudang;

use App\Model\FrontOffice\PenjualanSparepart;
use App\Model\Inventory\DetailSparepart;
use App\Model\Inventory\Rcv\Rcv;
use App\Model\Inventory\Retur\Retur;
use App\Model\Inventory\Sparepart;
use App\Model\Marketplace\Transaksi;
use App\Scopes\OwnershipScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kartugudang extends Model
{
    use SoftDeletes;

    protected $table = "tb_inventory_kartu_gudang";

    protected $primaryKey = 'id_kartu_gudang';

    protected $fillable = [
        'id_detail_sparepart',
        'id_bengkel',
        'kode_transaksi',
        'saldo_awal',
        'tanggal_transaksi',
        'jumlah_masuk',
        'jumlah_keluar',
        'saldo_akhir',
        'jenis_kartu',
        'harga_beli'
    ];

    protected $hidden =[ 
        'deleted_at'
    ];

    public $timestamps = true;


    public function Sparepart()
    {
        return $this->belongsTo(DetailSparepart::class,'id_detail_sparepart','id_detail_sparepart');
    }

    protected static function booted()
    {
        static::addGlobalScope(new OwnershipScope);
    }
}
