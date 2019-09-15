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
    
  public function provinsi()
  {
    return $this->belongsTo('App\SikiPropinsi', 'id_propinsi_reg');
  }
    
  public function kualifikasi()
  {
    return $this->belongsTo('App\SikiKualifikasi', 'id_kualifikasi');
  }
}
