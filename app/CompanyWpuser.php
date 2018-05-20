<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyWpuser extends Model
{
    //
    protected $table = 'company_wpusers';

    public function companywpuser_shareholders()
    {
    	return $this->hasMany('App\CompanyWpuserShareholder', 'companywpuser_id');
    }

    public function companywpuser_directors()
    {
        return $this->hasMany('App\CompanyWpuserDirector', 'companywpuser_id');
    }

    public function companywpuser_secretaries()
    {
        return $this->hasMany('App\CompanyWpuserSecretary', 'companywpuser_id');
    }

    public function servicescountries()
    {
        return $this->belongsToMany('App\ServiceCountry', 'companywpuser_service_country', 'companywpuser_id', 'service_country_id')->withPivot('credit_card_count');
    }

    public function informationservices()
    {
        return $this->belongsToMany('App\InformationService', 'companywpuser_information_service', 'companywpuser_id', 'information_service_id');
    }
}
