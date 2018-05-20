<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shareholder extends Model
{
    //
    protected $table = 'shareholders';

    public function companytypes()
    {
        return $this->belongsTo('App\CompanyType');
    }
}
