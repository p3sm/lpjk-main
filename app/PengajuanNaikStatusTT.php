<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengajuanNaikStatusTT extends Model
{
  protected $table = 'pengajuan_naik_status_tt';
    
  public function createdBy()
  {
    return $this->belongsTo('App\User', 'created_by');
  }
}
