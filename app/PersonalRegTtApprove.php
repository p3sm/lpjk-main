<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalRegTtApprove extends Model
{
  protected $connection = 'mysql';
  protected $table = 'personal_reg_tt_approve';
  protected $primaryKey = 'id';
}
