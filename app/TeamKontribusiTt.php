<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamKontribusiTt extends Model
{
  protected $connection = 'mysql';
  protected $table = 'team_kontribusi_trampil';
  protected $primaryKey = 'id';
    
  public function team()
  {
    return $this->belongsTo('App\Team', 'team_id');
  }
}
