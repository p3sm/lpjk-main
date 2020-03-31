<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengajuanNaikStatus extends Model
{
  protected $table = 'pengajuan_naik_status';
    
  public function createdBy()
  {
    return $this->belongsTo('App\User', 'created_by');
  }
}
