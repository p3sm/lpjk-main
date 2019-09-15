<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SikiKualifikasi extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'kualifikasi_profesi';
  protected $primaryKey = 'ID_Kualifikasi_Profesi';
}
