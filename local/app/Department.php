<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    public $timestamps = false;

    public function documents() {
      return $this->belongsTo('App\Document','id','department_id');
  	}
  	
  	public function enquiries(){
  		return $this->hasMany(Enquiry::class);
  	}
}
