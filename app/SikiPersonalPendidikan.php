<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SikiPersonalPendidikan extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'personal_pendidikan';
  protected $primaryKey = 'ID_Personal_Pendidikan';
    
  public function sync()
  {
    return $this->hasOne('App\PersonalPendidikanSync', 'personal_pendidikan_id');
  }
}
