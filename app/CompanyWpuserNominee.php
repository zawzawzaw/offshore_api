<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyWpuserNominee extends Model
{
    //
    protected $table = 'companywpuser_nominees';

    protected $fillable = array('name', 'address', 'telephone', 'person_type');

    public function companywpusers()
    {
    	return $this->belongsTo('App\Company', 'companywpuser_id');
    }
}
