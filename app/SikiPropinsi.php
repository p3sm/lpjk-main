<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SikiPropinsi extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'propinsi';
  protected $primaryKey = 'ID_Propinsi';
}
