<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Company;
use App\CompanyType;
use App\CompanyWpuser;
use App\CompanyWpuserShareholder;
use App\CompanyWpuserDirector;
use App\CompanyWpuserSecretary;
use App\CompanyWpuserServiceCountry;
use App\CompanyWpuserInformationService;
use App\Wpuser;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    //
    public function companytype($id) {
    	
		$company_types = CompanyType::find($id);

		if($company_types) {
			$company_types->companies;
			return $company_types;
		}else
			return response()->json(['message' => 'no resource was found'], 404);
    		
    }

    public function removeusercompanies($id, Request $request) {

        $wpuser_id = $request->user_id;
        $company_id = $request->company_id;

        $company_wpuser_shareholder = CompanyWpuserShareholder::where("companywpuser_id", $id);
        if($company_wpuser_shareholder) $company_wpuser_shareholder->delete();

        $company_wpuser_director = CompanyWpuserDirector::where("companywpuser_id", $id);
        if($company_wpuser_director) $company_wpuser_director->delete();

        $company_wpuser_secretary = CompanyWpuserSecretary::where("companywpuser_id", $id);
        if($company_wpuser_secretary) $company_wpuser_secretary->delete();

        $company_wpuser_service_country = CompanyWpuserServiceCountry::where("companywpuser_id", $id);
        if($company_wpuser_service_country) $company_wpuser_service_country->delete();

        $company_wpuser_information_service = CompanyWpuserInformationService::where("companywpuser_id", $id);
        if($company_wpuser_information_service) $company_wpuser_information_service->delete();

        $company_wpuser = CompanyWpuser::find($id);        
        if($company_wpuser) $affectedRows = $company_wpuser->delete();

        if($affectedRows) {
            return response()->json(['message' => 'Successfully deleted'], 200);    
        }else {
            return response()->json(['message' => 'Request failed', 'error' => $error], 412);    
        }

    }

    public function usercompanies($id, Request $request) {

        // $wpuser_compaines = Company::with("companytypes")->where('wpuser_id', $id)->get();         

        $wpuser_companies = Wpuser::find($id)->companies()->with(["wpusers" => function($query) use($id) {
            $query->select("user_nicename")->where('wpuser_id', $id);
        }, "companytypes"])->get();

        foreach ($wpuser_companies as $key => $wpuser_company) {
            $company_id = $wpuser_company->id;
            $owner = false;

            if($wpuser_company->status==1) {
              // if company is bought, check whether its this user's company
              $wpuser_companies_status = CompanyWpuser::where('company_id', $company_id)->where('wpuser_id', $id)->where('status', 1)->get();
              if(count($wpuser_companies_status)>0) $owner = true;
            }            

            $wpuser_company->owner = $owner;
            $wpuser_company->incorporation_date = date('d M Y', strtotime($wpuser_company->incorporation_date));
            $wpuser_company->wpusers[0]->pivot->renewal_date = date('d M Y', strtotime($wpuser_company->wpusers[0]->pivot->renewal_date));
        }

    	if(empty($wpuser_companies)) {		
    		return response()->json(['message' => 'user not found'], 202)->setCallback($request->input('callback'));
    	}
        
        return response()->json(['message' => 'Success', 'companies' => $wpuser_companies], 200)->setCallback($request->input('callback'));

    }

    public function usercompanydetails($id, $user_id, Request $request) {

        // $wpuser_company_details = Company::with(['companytypes','companyshareholders', 'companydirectors', 'companysecretaries', 'servicescountries', 'informationservice', 'wpusers' => function($query) use($user_id) {
        //     $query->select("user_nicename")->where('wpuser_id', $user_id);
        //   }])->get()->find($id);

        $companies = Company::with(['companytypes'])->where('id', $id)->get();
        $wpusers = Wpuser::where('ID', $user_id)->first(['user_nicename']);

        $wpuser_company_details = CompanyWpuser::with(['companywpuser_shareholders', 'companywpuser_directors', 'companywpuser_secretaries', 'servicescountries', 'informationservices'])->where('wpuser_id', $user_id)->where('company_id', $id)->where('status', 1)->first();

        if($wpuser_company_details) {
          $wpuser_company_details['companies'] = $companies;
          $wpuser_company_details['wpusers'] = $wpusers;

          $wpuser_company_details->renewal_date = date('d M Y', strtotime($wpuser_company_details->renewal_date));
          $wpuser_company_details->companies[0]->incorporation_date = date('d M Y', strtotime($wpuser_company_details->companies[0]->incorporation_date));

          return response()->json(['message' => 'Success', 'companydetails' => $wpuser_company_details], 200)->setCallback($request->input('callback'));
        }                

        return response()->json(['message' => 'company not found'], 202)->setCallback($request->input('callback'));                

    }

    public function uploadfiles(Request $request) {

        // $type = $request->type;

        if ($request->hasFile('files')) {
            $file = $request->file('files');   
            $destinationPath = public_path() . "/uploads/";

            $orgFilename     = $file->getClientOriginalName();
            $filename        = str_random(6) . '_' . $file->getClientOriginalName();
            $uploadSuccess   = $file->move($destinationPath, $filename);
        }

        if(!empty($uploadSuccess)) {
            error_log("Destination: $destinationPath");
            error_log("Filename: $filename");
            error_log("Extension: ".$file->getClientOriginalExtension());
            error_log("Original name: ".$file->getClientOriginalName());
            error_log("Real path: ".$file->getRealPath());
            return response()->json([
                "file" => [
                    "name" => $filename,
                    "org_name" => $orgFilename,
                    "destinationPath" => $destinationPath              
                ]
            ]);

            // return $filename . '||' . $orgFilename . '||' . $destinationPath;
        }
        else {
            error_log("Error moving file: ".$file->getClientOriginalName());
            return 'Erorr on ';
        }          

    }

    public function retrievesavedcompany(Request $request) {
        
        $user_id = $request->user_id;
        $company_id = $request->company_id;

        // $wpuser_companies = Company::with(['companytypes','companyshareholders', 'companydirectors', 'companysecretaries', 'servicescountries', 'informationservice', 'wpusers' => function($query) use($user_id) {
        //   $query->select('user_nicename')->where('wpuser_id', $user_id);
        // }])->where('id', $company_id)->where('status', 0)->get();

        // return $wpuser_companies;

        $companies = Company::with(['companytypes'])->where('id', $company_id)->get();
        $wpusers = Wpuser::where('ID', $user_id)->first(['user_nicename']);

        $wpuser_companies = CompanyWpuser::with(['companywpuser_shareholders', 'companywpuser_directors', 'companywpuser_secretaries', 'servicescountries', 'informationservices'])->where('wpuser_id', $user_id)->where('company_id', $company_id)->first();

        $wpuser_companies['companies'] = $companies;
        $wpuser_companies['wpusers'] = $wpusers;

        // return $wpuser_companies;

        // $wpuser_companies = Company::with(['wpusers' => function($query) use($user_id) {
        //   $query->join('companywpuser_shareholders', 'company_wpusers.id', '=', 'companywpuser_shareholders.companywpuser_id')                
        //         ->join('companywpuser_service_country', 'company_wpusers.id', '=', 'companywpuser_service_country.companywpuser_id')
        //         ->select('companywpuser_shareholders.*', 'companywpuser_service_country.*')                
        //         ->where('wpuser_id', $user_id);
        // }])->where('id', $company_id)->get();

        // $wpuser_companies = Company::find($company_id)->with(['wpusers' => function($query) use($user_id){
        //   $query->select('user_nicename')->where('wpuser_id', $user_id);
        // }])->get();

        if(empty($wpuser_companies)) {      
            return response()->json(['message' => 'company not found'], 202)->setCallback($request->input('callback'));
        }
        
        return response()->json(['message' => 'Success', 'saved_data' => $wpuser_companies], 200);

    }

    public function gettimezonelist($country, $city) {

        $country_codes = array (
          'AF' => 'Afghanistan',
          'AX' => 'Åland Islands',
          'AL' => 'Albania',
          'DZ' => 'Algeria',
          'AS' => 'American Samoa',
          'AD' => 'Andorra',
          'AO' => 'Angola',
          'AI' => 'Anguilla',
          'AQ' => 'Antarctica',
          'AG' => 'Antigua and Barbuda',
          'AR' => 'Argentina',
          'AU' => 'Australia',
          'AT' => 'Austria',
          'AZ' => 'Azerbaijan',
          'BS' => 'Bahamas',
          'BH' => 'Bahrain',
          'BD' => 'Bangladesh',
          'BB' => 'Barbados',
          'BY' => 'Belarus',
          'BE' => 'Belgium',
          'BZ' => 'Belize',
          'BJ' => 'Benin',
          'BM' => 'Bermuda',
          'BT' => 'Bhutan',
          'BO' => 'Bolivia',
          'BA' => 'Bosnia and Herzegovina',
          'BW' => 'Botswana',
          'BV' => 'Bouvet Island',
          'BR' => 'Brazil',
          'IO' => 'British Indian Ocean Territory',
          'BN' => 'Brunei Darussalam',
          'BG' => 'Bulgaria',
          'BF' => 'Burkina Faso',
          'BI' => 'Burundi',
          'KH' => 'Cambodia',
          'CM' => 'Cameroon',
          'CA' => 'Canada',
          'CV' => 'Cape Verde',
          'KY' => 'Cayman Islands',
          'CF' => 'Central African Republic',
          'TD' => 'Chad',
          'CL' => 'Chile',
          'CN' => 'China',
          'CX' => 'Christmas Island',
          'CC' => 'Cocos (Keeling) Islands',
          'CO' => 'Colombia',
          'KM' => 'Comoros',
          'CG' => 'Congo',
          'CD' => 'Zaire',
          'CK' => 'Cook Islands',
          'CR' => 'Costa Rica',
          'CI' => 'Côte D\'Ivoire',
          'HR' => 'Croatia',
          'CU' => 'Cuba',
          'CY' => 'Cyprus',
          'CZ' => 'Czech Republic',
          'DK' => 'Denmark',
          'DJ' => 'Djibouti',
          'DM' => 'Dominica',
          'DO' => 'Dominican Republic',
          'EC' => 'Ecuador',
          'EG' => 'Egypt',
          'SV' => 'El Salvador',
          'GQ' => 'Equatorial Guinea',
          'ER' => 'Eritrea',
          'EE' => 'Estonia',
          'ET' => 'Ethiopia',
          'FK' => 'Falkland Islands (Malvinas)',
          'FO' => 'Faroe Islands',
          'FJ' => 'Fiji',
          'FI' => 'Finland',
          'FR' => 'France',
          'GF' => 'French Guiana',
          'PF' => 'French Polynesia',
          'TF' => 'French Southern Territories',
          'GA' => 'Gabon',
          'GM' => 'Gambia',
          'GE' => 'Georgia',
          'DE' => 'Germany',
          'GH' => 'Ghana',
          'GI' => 'Gibraltar',
          'GR' => 'Greece',
          'GL' => 'Greenland',
          'GD' => 'Grenada',
          'GP' => 'Guadeloupe',
          'GU' => 'Guam',
          'GT' => 'Guatemala',
          'GG' => 'Guernsey',
          'GN' => 'Guinea',
          'GW' => 'Guinea-Bissau',
          'GY' => 'Guyana',
          'HT' => 'Haiti',
          'HM' => 'Heard Island and Mcdonald Islands',
          'VA' => 'Vatican City State',
          'HN' => 'Honduras',
          'HK' => 'Hong Kong',
          'HU' => 'Hungary',
          'IS' => 'Iceland',
          'IN' => 'India',
          'ID' => 'Indonesia',
          'IR' => 'Iran, Islamic Republic of',
          'IQ' => 'Iraq',
          'IE' => 'Ireland',
          'IM' => 'Isle of Man',
          'IL' => 'Israel',
          'IT' => 'Italy',
          'JM' => 'Jamaica',
          'JP' => 'Japan',
          'JE' => 'Jersey',
          'JO' => 'Jordan',
          'KZ' => 'Kazakhstan',
          'KE' => 'KENYA',
          'KI' => 'Kiribati',
          'KP' => 'Korea, Democratic People\'s Republic of',
          'KR' => 'Korea, Republic of',
          'KW' => 'Kuwait',
          'KG' => 'Kyrgyzstan',
          'LA' => 'Lao People\'s Democratic Republic',
          'LV' => 'Latvia',
          'LB' => 'Lebanon',
          'LS' => 'Lesotho',
          'LR' => 'Liberia',
          'LY' => 'Libyan Arab Jamahiriya',
          'LI' => 'Liechtenstein',
          'LT' => 'Lithuania',
          'LU' => 'Luxembourg',
          'MO' => 'Macao',
          'MK' => 'Macedonia, the Former Yugoslav Republic of',
          'MG' => 'Madagascar',
          'MW' => 'Malawi',
          'MY' => 'Malaysia',
          'MV' => 'Maldives',
          'ML' => 'Mali',
          'MT' => 'Malta',
          'MH' => 'Marshall Islands',
          'MQ' => 'Martinique',
          'MR' => 'Mauritania',
          'MU' => 'Mauritius',
          'YT' => 'Mayotte',
          'MX' => 'Mexico',
          'FM' => 'Micronesia, Federated States of',
          'MD' => 'Moldova, Republic of',
          'MC' => 'Monaco',
          'MN' => 'Mongolia',
          'ME' => 'Montenegro',
          'MS' => 'Montserrat',
          'MA' => 'Morocco',
          'MZ' => 'Mozambique',
          'MM' => 'Myanmar',
          'NA' => 'Namibia',
          'NR' => 'Nauru',
          'NP' => 'Nepal',
          'NL' => 'Netherlands',
          'AN' => 'Netherlands Antilles',
          'NC' => 'New Caledonia',
          'NZ' => 'New Zealand',
          'NI' => 'Nicaragua',
          'NE' => 'Niger',
          'NG' => 'Nigeria',
          'NU' => 'Niue',
          'NF' => 'Norfolk Island',
          'MP' => 'Northern Mariana Islands',
          'NO' => 'Norway',
          'OM' => 'Oman',
          'PK' => 'Pakistan',
          'PW' => 'Palau',
          'PS' => 'Palestinian Territory, Occupied',
          'PA' => 'Panama',
          'PG' => 'Papua New Guinea',
          'PY' => 'Paraguay',
          'PE' => 'Peru',
          'PH' => 'Philippines',
          'PN' => 'Pitcairn',
          'PL' => 'Poland',
          'PT' => 'Portugal',
          'PR' => 'Puerto Rico',
          'QA' => 'Qatar',
          'RE' => 'Réunion',
          'RO' => 'Romania',
          'RU' => 'Russian Federation',
          'RW' => 'Rwanda',
          'SH' => 'Saint Helena',
          'KN' => 'Saint Kitts and Nevis',
          'LC' => 'Saint Lucia',
          'PM' => 'Saint Pierre and Miquelon',
          'VC' => 'Saint Vincent and the Grenadines',
          'WS' => 'Samoa',
          'SM' => 'San Marino',
          'ST' => 'Sao Tome and Principe',
          'SA' => 'Saudi Arabia',
          'SN' => 'Senegal',
          'RS' => 'Serbia',
          'SC' => 'Seychelles',
          'SL' => 'Sierra Leone',
          'SG' => 'Singapore',
          'SK' => 'Slovakia',
          'SI' => 'Slovenia',
          'SB' => 'Solomon Islands',
          'SO' => 'Somalia',
          'ZA' => 'South Africa',
          'GS' => 'South Georgia and the South Sandwich Islands',
          'ES' => 'Spain',
          'LK' => 'Sri Lanka',
          'SD' => 'Sudan',
          'SR' => 'Suriname',
          'SJ' => 'Svalbard and Jan Mayen',
          'SZ' => 'Swaziland',
          'SE' => 'Sweden',
          'CH' => 'Switzerland',
          'SY' => 'Syrian Arab Republic',
          'TW' => 'Taiwan, Province of China',
          'TJ' => 'Tajikistan',
          'TZ' => 'Tanzania, United Republic of',
          'TH' => 'Thailand',
          'TL' => 'Timor-Leste',
          'TG' => 'Togo',
          'TK' => 'Tokelau',
          'TO' => 'Tonga',
          'TT' => 'Trinidad and Tobago',
          'TN' => 'Tunisia',
          'TR' => 'Turkey',
          'TM' => 'Turkmenistan',
          'TC' => 'Turks and Caicos Islands',
          'TV' => 'Tuvalu',
          'UG' => 'Uganda',
          'UA' => 'Ukraine',
          'AE' => 'United Arab Emirates',
          'GB' => 'United Kingdom',
          'US' => 'United States',
          'UM' => 'United States Minor Outlying Islands',
          'UY' => 'Uruguay',
          'UZ' => 'Uzbekistan',
          'VU' => 'Vanuatu',
          'VE' => 'Venezuela',
          'VN' => 'Viet Nam',
          'VG' => 'Virgin Islands, British',
          'VI' => 'Virgin Islands, U.S.',
          'WF' => 'Wallis and Futuna',
          'EH' => 'Western Sahara',
          'YE' => 'Yemen',
          'ZM' => 'Zambia',
          'ZW' => 'Zimbabwe',
        );

        $country_code = array_search(strtolower($country), array_map('strtolower', $country_codes));

        $timezone = timezone_identifiers_list(4096, $country_code);
        $timezonestr = $timezone[0];
        date_default_timezone_set($timezonestr);

        if($city && (!empty($city) && $city!=="none")) $name = $city;
        else $name = $country;

        $date= "Present time in ".$name.": ". date('D, d M Y H:i') . " hrs";

        return $date;
    }

}
