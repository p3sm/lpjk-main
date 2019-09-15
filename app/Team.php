<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
  protected $connection = 'mysql';
  protected $table = 'team';
  protected $primaryKey = 'id';
}
