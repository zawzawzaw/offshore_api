<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Curl;

class AuthenticateController extends Controller
{
    //

	public function authenticate() {

		//extract data from the post
		//set POST variables
		$url = 'localhost:8888/offshore/b/oauth/access_token';
		$fields = array(
			'grant_type' => "client_credentials",
			'client_id' => 1,
			'client_secret' => 12345
		);

		//url-ify the data for the POST
		$fields_string = "";
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');

		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);

	}
}
