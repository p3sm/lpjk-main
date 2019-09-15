<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalRegTaApprove extends Model
{
  protected $connection = 'mysql';
  protected $table = 'personal_reg_ta_approve';
  protected $primaryKey = 'id';
}
