<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    protected $table = 'companies';

    public function companytypes()
    {
        return $this->belongsTo('App\CompanyType', 'company_type_id');
    }

 	// public function services()
  //   {
  //       return $this->belongsToMany('App\Service', 'company_service');
  //   }

    public function companydirectors()
    {
    	return $this->hasMany('App\CompanyDirector');
    }

    public function companyshareholders()
    {
    	return $this->hasMany('App\CompanyShareholder');
    }

    public function companysecretaries()
    {
    	return $this->hasMany('App\CompanySecretary');
    }

    public function informationservice()
    {
        return $this->belongsToMany('App\InformationService', 'company_information_service');
    }

    public function servicescountries()
    {
        return $this->belongsToMany('App\ServiceCountry', 'company_service_country')->withPivot('credit_card_count');
    }

    public function wpusers()
    {
        //return $this->belongsTo('App\Wpuser', 'wpuser_id');
        return $this->belongsToMany('App\Wpuser', 'company_wpusers')->withPivot('id','renewal_date', 'nominee_director', 'nominee_shareholder', 'nominee_secretary', 'reg_no', 'tax_no', 'vat_reg_no', 'reg_office', 'status');
    }

    public function companywpuser_shareholders()
    {
        return $this->hasManyThrough(
          'App\CompanyWpuserShareholder', 'App\CompanyWpuser', 'company_id', 'companywpuser_id'
        );
    }
}
