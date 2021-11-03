<?php

namespace App\Model\FrontOffice;

use App\Scopes\OwnershipScope;
use Illuminate\Database\Eloquent\Model;

class Detailperbaikan extends Model
{
    protected $table = "tb_fo_detail_jenis_perbaikan";

    protected $primaryKey = 'id_detail_perbaikan';

    protected $fillable = [
        'id_bengkel',
        'id_jenis_perbaikan',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public $timestamps = true;

    // relations
    public function Perbaikan()
    {
        return $this->belongsTo(MasterDataJenisPerbaikan::class, 'id_jenis_perbaikan', 'id_jenis_perbaikan');
    }

    protected static function booted()
    {
        static::addGlobalScope(new OwnershipScope);
    }
}
