<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyWpuserSecretary extends Model
{
    //
    protected $table = 'companywpuser_secretaries';

    protected $fillable = array('type', 'name', 'address', 'address_2', 'address_3', 'address_4', 'address_5', 'telephone', 'passport', 'bill');

    public function companywpusers()
    {
    	return $this->belongsTo('App\Company', 'companywpuser_id');
    }
}
