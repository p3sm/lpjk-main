<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SikiPersonal extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'personal';
  protected $primaryKey = 'id_personal';
    
  public function proyek()
  {
    return $this->hasMany('App\SikiPersonalProyek', 'id_personal');
  }
    
  public function pendidikan()
  {
    return $this->hasMany('App\SikiPersonalPendidikan', 'ID_Personal');
  }
}
