<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SikiAsosiasi extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'personal_profesi_ta';
  protected $primaryKey = 'ID_Asosiasi_Profesi';
    
  public function apikey()
  {
    return $this->hasOne('App\AsosiasiKey', 'asosiasi_id');
  }
}
