<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wpuser extends Model
{
    //
    public $timestamps = false;
    protected $primaryKey = 'ID';
    protected $table = 'wp_users';

    public function companies()
    {
    	// return $this->hasMany('App\Company');
        return $this->belongsToMany('App\Company', 'company_wpusers');
    }

    public function companywpuser_shareholders()
    {
        return $this->hasManyThrough(
          'App\CompanyWpuserShareholder', 'App\CompanyWpuser', 'wpuser_id', 'companywpuser_id'
        );
    }

    public function wpbpxprofiledata()
    {
        return $this->hasMany('App\WpBpXprofileData', 'user_id');
    }

    public function wpbpxprofilefields()
    {
        return $this->hasMany('App\WpBpXprofileFields', 'user_id');
    }
    
}
