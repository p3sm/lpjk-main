<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalProyekSync extends Model
{
  protected $connection = 'mysql';
  protected $table = 'personal_proyek_sync';
  protected $primaryKey = 'id';
}
