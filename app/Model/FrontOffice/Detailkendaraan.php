<?php

namespace App\Model\FrontOffice;

use App\Scopes\OwnershipScope;
use Illuminate\Database\Eloquent\Model;

class Detailkendaraan extends Model
{
    protected $table = "tb_fo_detail_kendaraan";

    protected $primaryKey = 'id_detail_kendaraan';

    protected $fillable = [
        'id_bengkel',
        'id_kendaraan',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public $timestamps = true;

    // relations
    public function Kendaraan()
    {
        return $this->belongsTo(MasterDataKendaraan::class, 'id_kendaraan', 'id_kendaraan');
    }

    protected static function booted()
    {
        static::addGlobalScope(new OwnershipScope);
    }
}
