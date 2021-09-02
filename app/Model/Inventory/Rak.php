<?php

namespace App\Model\Inventory;

use App\Scopes\OwnershipScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Rak extends Model
{
    use SoftDeletes;

    protected $table = "tb_inventory_master_rak";

    protected $primaryKey = 'id_rak';

    protected $fillable = [
        'kode_rak',
        'id_bengkel',
        'nama_rak',
        'jenis_rak',
        'id_gudang'
    ];

    protected $hidden =[ 
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamps = true;

    public static function getId(){
        // return $this->orderBy('id_sparepart')->take(1)->get();
        $getId = DB::table('tb_inventory_master_rak')->orderBy('id_rak','DESC')->take(1)->get();
        if(count($getId) > 0) return $getId;
        return (object)[
            (object)[
                'id_rak'=> 0
            ]
            ];
    }

    public function gudang(){
        return $this->belongsTo(Gudang::class,'id_gudang','id_gudang');
    }


    protected static function booted()
    {
        static::addGlobalScope(new OwnershipScope);
    }
}
