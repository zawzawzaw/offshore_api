<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $table = 'services';

    public function companytypes()
    {
        // return $this->belongsToMany('App\CompanyType', 'companytype_service')->withPivot('price');
        return $this->belongsTo('App\CompanyType');
    }

    public function companies()
    {
        return $this->belongsToMany('App\Company', 'company_service');
    }

    public function countries()
    {
        return $this->belongsToMany('App\Country', 'service_country')->withPivot('id', 'price', 'price_eu');
    }
}
