<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyType extends Model
{
    //
    protected $table = 'company_types';

    public function companies()
    {
        return $this->hasMany('App\Company');
    }

    public function directors()
    {
        return $this->hasMany('App\Director');
    }

    public function shareholders()
    {
        return $this->hasMany('App\Shareholder');
    }

    public function secretaries()
    {
        return $this->hasMany('App\Secretary');
    }

    public function services()
    {        
        // return $this->belongsToMany('App\Service', 'companytype_service');
        return $this->hasMany('App\Service');
    }

    public function informationservices()
    {                
        return $this->hasMany('App\InformationService');
    }


}
