<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubKlasifikasi extends Model
{
  protected $table = 'master_bidang_sub';

  protected $primaryKey = 'id_sub_bidang';

  protected $casts = ['id_sub_bidang' => 'string'];
}
