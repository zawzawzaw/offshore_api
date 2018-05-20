<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    protected $table = 'countries';

    public function services()
    {
        return $this->belongsToMany('App\Service', 'service_country');
    }
}
