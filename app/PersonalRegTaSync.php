<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalRegTaSync extends Model
{
  protected $connection = 'mysql';
  protected $table = 'personal_reg_ta_sync';
  protected $primaryKey = 'id';
    
  public function permohonan()
  {
    return $this->belongsTo('App\SikiRegta', 'registrasi_tk_ahli_id');
  }
}
