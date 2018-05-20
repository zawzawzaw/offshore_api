<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyShareholder extends Model
{
    //
    protected $table = 'company_shareholders';

    protected $fillable = array('type', 'name', 'address', 'address_2', 'address_3', 'address_4', 'telephone', 'passport', 'bill', 'share_amount');

    public function companies()
    {
    	return $this->belongsTo('App\Company', 'company_id');
    }
}
