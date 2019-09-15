<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamKontribusiTa extends Model
{
  protected $connection = 'mysql';
  protected $table = 'team_kontribusi_ahli';
  protected $primaryKey = 'id';
    
  public function team()
  {
    return $this->belongsTo('App\Team', 'team_id');
  }
}
