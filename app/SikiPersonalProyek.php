<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SikiPersonalProyek extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'personal_proyek';
  protected $primaryKey = 'id_personal_proyek';
    
  public function sync()
  {
    return $this->hasOne('App\PersonalProyekSync', 'personal_proyek_id');
  }
}
