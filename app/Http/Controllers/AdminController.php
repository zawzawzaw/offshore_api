<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //

    public function index(Request $request) {

      // if ($request->ip() != '219.74.46.127' && $request->ip() != '5.9.51.102')
      //   abort(404);

    	return view('admin');
    }
}
