<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyWpuserShareholder extends Model
{
    //
    protected $table = 'companywpuser_shareholders';

    protected $fillable = array('type', 'name', 'address', 'address_2', 'address_3', 'address_4', 'address_5', 'telephone', 'passport', 'bill', 'share_amount');

    public function companywpusers()
    {
    	return $this->belongsTo('App\CompanyWpuser', 'companywpuser_id');
    }
}
