<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentLanguage extends Model
{
  protected $table = 'document_language';
  public $timestamps = false;

  public function documents() {
    return $this->belongsTo('App\Document','id','document_language_id');
  }
}
