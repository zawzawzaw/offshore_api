<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyWpuserDirector extends Model
{
    //
    protected $table = 'companywpuser_directors';

    protected $fillable = array('type', 'name', 'address', 'address_2', 'address_3', 'address_4', 'address_5', 'telephone', 'passport', 'bill');

    public function companywpusers()
    {
    	return $this->belongsTo('App\CompanyWpuser', 'companywpuser_id');
    }
}
