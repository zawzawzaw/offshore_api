<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

Route::group(['prefix' => 'testapi', 'middleware' => 'oauth'], function()
{
	Route::get('protected-resource', ['middleware' => 'oauth', function() {
	    return "hello";
	}]);	
});

Route::get('oauth/authorize', ['as' => 'oauth.authorize.get', 'middleware' => ['check-authorization-params'], function() {
   $authParams = Authorizer::getAuthCodeRequestParams();

   $formParams = array_except($authParams,'client');

   $formParams['client_id'] = $authParams['client']->getId();

   $formParams['scope'] = implode(config('oauth2.scope_delimiter'), array_map(function ($scope) {
       return $scope->getId();
   }, $authParams['scopes']));

   return View::make('oauth.authorization-form', ['params' => $formParams, 'client' => $authParams['client']]);
}]);

Route::post('oauth/authorize', ['as' => 'oauth.authorize.post', 'middleware' => ['check-authorization-params'], function() {

    $params = Authorizer::getAuthCodeRequestParams();
    $params['user_id'] = 1;
    $redirectUri = '/';

    // If the user has allowed the client to access its data, redirect back to the client with an auth code.
    if (Request::has('approve')) {
        $redirectUri = Authorizer::issueAuthCode('user', $params['user_id'], $params);
    }

    // If the user has denied the client to access its data, redirect back to the client with an error message.
    if (Request::has('deny')) {
        $redirectUri = Authorizer::authCodeRequestDeniedRedirectUri();
    }

    return Redirect::to($redirectUri);
}]);

Route::get('gettoken', ['uses' => 'AuthenticateController@authenticate']);
Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

Route::get('api/companytype/{id}', ['uses' => 'ApiController@companytype']);
Route::get('api/usercompanies/{id}', ['uses' => 'ApiController@usercompanies']);
Route::get('api/usercompanydetails/{id}/{user_id}', ['uses' => 'ApiController@usercompanydetails']);
Route::delete('api/removeusercompanies/{company_wpuser_id}', ['uses' => 'ApiController@removeusercompanies']);
Route::put('api/updateuserunavailablecompainesdeletestatus/{company_wpuser_id}', ['uses' => 'ApiController@updateuserunavailablecompainesdeletestatus']);
Route::get('api/gettimezonelist/{country}/{city}', ['uses' => 'ApiController@gettimezonelist']);

Route::post('api/retrievesavedcompany', ['uses' => 'ApiController@retrievesavedcompany']);
Route::post('api/uploadfiles', ['uses' => 'ApiController@uploadfiles']);
Route::post('api/addtopersondb', ['uses' => 'ApiController@addtopersondb']);
Route::get('api/getperson', ['uses' => 'ApiController@getperson']);
Route::get('api/log_transaction_status', ['uses' => 'ApiController@log_transaction_status']);
Route::get('api/exportpersonlist', ['uses' => 'ApiController@exportPersonList']);
Route::get('api/exportcompanylist', ['uses' => 'ApiController@exportCompanyList']);
Route::get('api/exportpendingcompanylist', ['uses' => 'ApiController@exportPendingCompanyList']);
Route::post('api/paymentnoti', ['uses' => 'ApiController@paymentnoti']);
Route::post('api/preparerequestdata', ['uses' => 'ApiController@prepareRequestData']);
Route::post('officiumtutus/jurisdiction/getcompanyinclsaved', ['uses' => 'JurisdictionController@getcompanyinclsaved']);
Route::post('officiumtutus/hidependingorder', ['uses' => 'RegisteredcompanyController@hidePendingOrder']);

Route::group(['middleware' => 'checkip'], function() {   
  Route::group(['middleware' => 'auth.basic'], function() {		
  	Route::get('officiumtutus', ['uses' => 'AdminController@index']);
  });
});

Route::get('login', function() {
    return "`x";
});

Route::get('officiumtutus/logout', function() {
    Auth::logout();
    return Redirect::to('officiumtutus');
});

Route::group(['middleware' => 'web'], function() {		
	Route::resource('officiumtutus/jurisdiction', 'JurisdictionController');
});
Route::resource('officiumtutus/company', 'CompanyController');
Route::resource('officiumtutus/registeredcompany', 'RegisteredcompanyController');
Route::resource('officiumtutus/approvedcompany', 'ApprovedcompanyController');
Route::resource('officiumtutus/client', 'ClientController');
Route::resource('officiumtutus/person', 'PersonController');
Route::resource('officiumtutus/updateuser', 'UserController');
