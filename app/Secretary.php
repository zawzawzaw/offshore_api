<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Secretary extends Model
{
    //
    protected $table = 'secretaries';

    public function companytypes()
    {
        return $this->belongsTo('App\CompanyType');
    }
}
