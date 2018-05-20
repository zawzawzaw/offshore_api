<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyWpuserInformationService extends Model
{
    //
    protected $table = 'companywpuser_information_service';

    public function information_services() 
    {
        return $this->belongsTo('App\InformationService', 'information_service_id');   
    }
}
