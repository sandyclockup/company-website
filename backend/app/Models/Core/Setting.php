<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{

    use SoftDeletes;

    protected $table = "core_settings";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'key_name',
        'key_value'
    ];

    public static function getConfig($key_name){
        $data = self::where("key_name", $key_name)->first();
        if(!is_null($data)){
            return $data->key_value;
        }else{
            return null;
        }
    }

}
