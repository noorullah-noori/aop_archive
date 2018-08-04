<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $table = 'enquiries';
    public $timestamps = false;


    public function documents() {
      return $this->belongsToMany('App\Document');
    }

    public function department(){
    	return $this->belongsTo('App\Department');
    }
}
