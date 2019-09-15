<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SikiRegtt extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'personal_reg_tt';
  protected $primaryKey = 'ID_Registrasi_TK_Trampil';
    
  public function personal()
  {
    return $this->belongsTo('App\SikiPersonal', 'ID_Personal');
  }
    
  public function sync()
  {
    return $this->hasOne('App\PersonalRegTtSync', 'registrasi_tk_trampil_id');
  }
    
  public function approve()
  {
    return $this->hasOne('App\PersonalRegTtApprove', 'registrasi_tk_trampil_id');
  }
    
  public function kualifikasi()
  {
    return $this->belongsTo('App\SikiKualifikasi', 'ID_Kualifikasi');
  }
    
  public function asosiasi()
  {
    return $this->belongsTo('App\SikiAsosiasi', 'ID_Asosiasi_Profesi');
  }
}
