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

    // this should name companywpusers() but don't want to change it anymore 
    public function wpusers()
    {
        //return $this->belongsTo('App\Wpuser', 'wpuser_id');
        return $this->belongsToMany('App\Wpuser', 'company_wpusers')->withPivot('id','renewal_date', 'nominee_director', 'nominee_shareholder', 'nominee_secretary', 'nominee_director_person_code', 'nominee_secretary_person_code', 'owner_person_code', 'reg_no', 'tax_no', 'vat_reg_no', 'reg_office', 'status');
    }

    public function companywpuser_shareholders()
    {
        return $this->hasManyThrough(
          'App\CompanyWpuserShareholder', 'App\CompanyWpuser', 'company_id', 'companywpuser_id'
        );
    }

    public function companywpuser_directors()
    {
        return $this->hasManyThrough(
          'App\CompanyWpuserDirector', 'App\CompanyWpuser', 'company_id', 'companywpuser_id'
        );
    }

    public function companywpuser_secretaries()
    {
        return $this->hasManyThrough(
          'App\CompanyWpuserSecretary', 'App\CompanyWpuser', 'company_id', 'companywpuser_id'
        );
    }

    public function companywpuser_servicecountries()
    {
        return $this->hasManyThrough(
          'App\CompanyWpuserServiceCountry', 'App\CompanyWpuser', 'company_id', 'companywpuser_id'
        );   
    }

    public function companywpuser_informationservices()
    {
        return $this->hasManyThrough(
          'App\CompanyWpuserInformationService', 'App\CompanyWpuser', 'company_id', 'companywpuser_id'
        );   
    }
}
