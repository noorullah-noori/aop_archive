<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';
    public $timestamps = false;
    protected $casts=[
      'countries'=>'array',
    ];

    public function department() {
      return $this->hasOne('App\Department','id','department_id');
    }

    public function category() {
      return $this->hasOne('App\Category','id','category_id');
    }
    public function document_language() {
      return $this->hasOne('App\DocumentLanguage','id','document_language_id');
    }

    public function uploads() {
      return $this->hasMany('App\Upload','document_id','id');
    }

    public function enquiries(){
      return $this->belongsToMany('App\Enquiry');
    }
    public function user(){
      return $this->belongsTo('App\User','created_by','id');
    }
}
