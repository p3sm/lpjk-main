<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalPendidikanSync extends Model
{
  protected $connection = 'mysql';
  protected $table = 'personal_pendidikan_sync';
  protected $primaryKey = 'id';
}
