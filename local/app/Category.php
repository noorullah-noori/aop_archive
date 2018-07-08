<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $table='categories';
	public $timestamps = false;

  public function documents() {
      return $this->belongsTo('App\Document','id','category_id');
  }

}
