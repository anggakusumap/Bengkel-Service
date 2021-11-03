<?php

namespace App\Model\FrontOffice;

use App\Model\SingleSignOn\JenisBengkel;
use App\Scopes\OwnershipScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MasterDataKendaraan extends Model
{
    protected $table = "tb_fo_master_kendaraan";

    protected $primaryKey = 'id_kendaraan';

    protected $fillable = [
        'kode_kendaraan', 'nama_kendaraan', 'id_merk_kendaraan', 'id_jenis_kendaraan', 'id_jenis_bengkel'
    ];

    protected $hidden = [];

    public $timestamps = false;

    public function merk_kendaraan()
    {
        return $this->belongsTo(MasterDataMerkKendaraan::class, 'id_merk_kendaraan', 'id_merk_kendaraan');
    }

    public function jenis_kendaraan()
    {
        return $this->belongsTo(MasterDataJenisKendaraan::class, 'id_jenis_kendaraan', 'id_jenis_kendaraan');
    }

    public static function getId()
    {
        return $getId = DB::table('tb_fo_master_kendaraan')->orderBy('id_kendaraan', 'DESC')->take(1)->get();
    }

    public function JenisBengkel()
    {
        return $this->belongsTo(JenisBengkel::class, 'id_jenis_bengkel', 'id_jenis_bengkel');
    }

    public function DetailKendaraan()
    {
        return $this->belongsTo(Detailkendaraan::class, 'id_kendaraan', 'id_kendaraan');
    }
}
