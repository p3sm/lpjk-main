<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApprovalTransaction extends Model
{
  protected $connection = 'mysql';
  protected $table = 'approval_transaction';
  protected $primaryKey = 'id';
    
  public function team()
  {
    return $this->belongsTo('App\Team', 'team_id');
  }
    
  public function personal()
  {
    return $this->belongsTo('App\Personal', 'id_personal');
  }
    
  public function asosiasi()
  {
    return $this->belongsTo('App\Asosiasi', 'id_asosiasi_profesi');
  }
    
  public function provinsi()
  {
    return $this->belongsTo('App\Provinsi', 'id_propinsi_reg');
  }
    
  public function ustk()
  {
    return $this->belongsTo('App\Ustk', 'id_unit_sertifikasi');
  }
    
  public function klasifikasi()
  {
    return $this->belongsTo('App\SubKlasifikasi', 'id_sub_bidang');
  }
    
  public function kualifikasi()
  {
    return $this->belongsTo('App\Kualifikasi', 'id_kualifikasi');
  }
}
