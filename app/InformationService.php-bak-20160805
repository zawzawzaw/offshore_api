<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformationService extends Model
{
    //
    protected $table = 'information_services';

    public function companytypes()
    {
        // return $this->belongsToMany('App\CompanyType', 'companytype_service')->withPivot('price');
        return $this->belongsTo('App\CompanyType');
    }

    public function companies()
    {
        return $this->belongsToMany('App\Company', 'company_information_service');
    }

    public function companywpusers()
    {
        return $this->belongsToMany('App\Company', 'companywpuser_information_service');
    }


}
