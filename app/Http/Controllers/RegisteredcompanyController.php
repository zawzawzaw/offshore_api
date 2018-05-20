<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Company;
use App\CompanyWpuser;
use App\Service;
use App\Country;
use App\CompanyWpuserDirector;
use App\CompanyWpuserShareholder;
use App\CompanyWpuserSecretary;
use App\CompanyWpuserNominee;
use App\CompanyWpuserServiceCountry;
use App\CompanyWpuserInformationService;
use App\Wpuser;
use App\Person;

class RegisteredcompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        

        if($request->search) {            

            $keyword = $request->search;


            # if two dates entered (two dates must enter by seperator -)
            if (strpos($keyword, '-') !== false) {
                $dates = explode("-", $keyword);

                if(isset($dates[0]) && !empty($dates[0])) {
                    $from_date = trim($dates[0]);                
                }
                if(isset($dates[1]) && !empty($dates[1])) {
                    $to_date = trim($dates[1]);
                }

                # check if input date is valid
                $check_from_date = date_parse($from_date);
                $check_to_date = date_parse($to_date);

                if ($check_from_date["error_count"] == 0 && checkdate($check_from_date["month"], $check_from_date["day"], $check_from_date["year"])) $from_date_valid = true;
                else $from_date_valid = false;

                if ($check_to_date["error_count"] == 0 && checkdate($check_to_date["month"], $check_to_date["day"], $check_to_date["year"])) $to_date_valid = true;
                else $to_date_valid = false;


                # if valid format this to compare
                if($from_date_valid) {
                    $from_date = date('Y-m-d', strtotime($dates[0]));                
                }
                if($to_date_valid) {
                    $to_date = date('Y-m-d', strtotime($dates[1]));
                }

                # do search by comparing dates

                $companies = Company::with(['wpusers' => function($q) {
                        $q->wherePivot('status', 1)->orWherePivot('status', 3);
                }, 'companytypes'])->where('incorporation_date', '>', $from_date)->where('incorporation_date', '<', $to_date)->get();

            }else {

                #check if keyword is valid date
                $check_from_date = date_parse($keyword);

                if ($check_from_date["error_count"] == 0 && checkdate($check_from_date["month"], $check_from_date["day"], $check_from_date["year"])) $from_date_valid = true;
                else $from_date_valid = false;

                # if its date
                if($from_date_valid) {
                    $from_date = date('Y-m-d', strtotime($keyword));
                    $to_date = date('Y-m-d');

                    // if($search_date < date('Y-m-d', strtotime("2000"))) {
                    //     echo $search_date;
                    // }

                    # do search by comparing dates

                    $companies = Company::with(['wpusers' => function($q) {
                        $q->wherePivot('status', 1)->orWherePivot('status', 3);
                    }, 'companytypes'])->where('incorporation_date', '>', $from_date)->where('incorporation_date', '<', $to_date)->get(); /// ??? 

                }else {
                    $companies = Company::with(['wpusers' => function($q) {
                        $q->wherePivot('status', 1)->orWherePivot('status', 3);
                    }, 'companytypes'])->where('name', 'LIKE', '%'.$keyword.'%')->orWhereHas('companytypes', function($q) use($keyword) {
                        $q->where('jurisdiction', 'LIKE', '%'.$keyword.'%');
                    })->orWhereHas('wpusers', function($q) use($keyword) {
                        $q->where('display_name', 'LIKE', '%'.$keyword.'%');
                    })->get();
                }

            }      
            
        }else {    
            $companies = Company::with(['wpusers' => function($q) {
                $q->wherePivot('status', 1)->orWherePivot('status', 2)->orWherePivot('status', 3);
            }, 'companytypes'])->get();        
        }        

        $registeredcompanies = [];

        foreach ($companies as $key => $company) {
            if(count($company->wpusers) > 0) { // && $company->wpusers[0]->pivot->hide_in_pending_order!=1
                $registeredcompanies[] = $company;
            }
        }    

        // return $companies;
        // return $registeredcompanies;

    	// $companies = Company::with(['wpusers', 'companytypes'])->where('code', 'Rejected')->orWhere('code', 'New Inc')->get();

    	return view('registeredcompany.index', ['registeredcompanies'=>$registeredcompanies]);
    }

    public function show(Request $request, $id) {

        $company = Company::with(['wpusers'])->where("id", $id)->first(); //->where('status', 1)->orWhere('code', 'Rejected')

        // $companywpuser_id = $company->wpusers[0]->pivot->id;

        if(count($company->wpusers) > 0) {
            foreach ($company->wpusers as $key => $wpuser) {
                if($wpuser->pivot->status==1) {
                    $companywpuser_id = $wpuser->pivot->id;
                } else if($wpuser->pivot->status==2) {
                    $companywpuser_id = $wpuser->pivot->id;
                } else if($wpuser->pivot->status==3) {
                    $companywpuser_id = $wpuser->pivot->id;
                }
            }            
        }

        $company = Company::with(['wpusers', 'companytypes', 'companywpuser_shareholders' => function($query) use($companywpuser_id){
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_directors' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_secretaries' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_servicecountries' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_informationservices' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }])->where("id", $id)->first(); //->where('status', 1)->orWhere('code', 'Rejected')

        //////
        // nominees
        //////

        $companywpuser_nominee_shareholder = CompanyWpuserNominee::where('companywpuser_id', $companywpuser_id)->where('person_type', 'shareholder')->first();
        $companywpuser_nominee_director = CompanyWpuserNominee::where('companywpuser_id', $companywpuser_id)->where('person_type', 'director')->first();
        $companywpuser_nominee_secretary = CompanyWpuserNominee::where('companywpuser_id', $companywpuser_id)->where('person_type', 'secretary')->first();

        ///////

        $companywpuser_informationservices = CompanyWpuser::with(['informationservices'])->where('company_id', $company->id)->where('id', $companywpuser_id)->first();

        $informationservices = $companywpuser_informationservices->informationservices;

        $companywpuser_servicescountries = CompanyWpuser::with(['servicescountries'])->where('company_id', $company->id)->where('id', $companywpuser_id)->first();

        $servicescountries = $companywpuser_servicescountries->servicescountries;      
        
        foreach ($servicescountries as $key => $value) {
            $service = Service::where('id',$value->service_id)->first();
            $country = Country::where('id', $value->country_id)->first();

            $value->service_name = $service->name;
            $value->country_name = $country->name;            
        }       

        $companywpuser = CompanyWpuser::where('company_id', $company->id)->where('id', $companywpuser_id)->first();

        // return $servicescountries;

        return view('registeredcompany.show', ['company'=>$company, 'informationservices'=>$informationservices, 'servicescountries'=>$servicescountries, 'companywpuser_nominee_shareholder'=>$companywpuser_nominee_shareholder, 'companywpuser_nominee_director'=>$companywpuser_nominee_director, 'companywpuser_nominee_secretary'=> $companywpuser_nominee_secretary, 'companywpuser' => $companywpuser]);
    }

    public function edit(Request $request, $id) {

        // => function($query) {
            // $query->wherePivot('status', 1); }

        $company = Company::with(['wpusers'])->where("id", $id)->first(); //->where('status', 1)->orWhere('code', 'Rejected')        

        if(count($company->wpusers) > 0) {
            foreach ($company->wpusers as $key => $wpuser) {
                if($wpuser->pivot->status==1) {
                    $companywpuser_id = $wpuser->pivot->id;
                }
            }            
        }

        // echo $companywpuser_id . '<br>'; exit();                

        // return $company;

        $company = Company::with(['wpusers', 'companytypes', 
            'companywpuser_shareholders' => function($query) use($companywpuser_id){
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_directors' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_secretaries' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_servicecountries' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_informationservices' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }])->where("id", $id)->first(); //->where('status', 1)->orWhere('code', 'Rejected')

        // return $company;

        //////
        // nominees
        //////

        $companywpuser_nominee_shareholder = CompanyWpuserNominee::where('companywpuser_id', $companywpuser_id)->where('person_type', 'shareholder')->first();
        $companywpuser_nominee_director = CompanyWpuserNominee::where('companywpuser_id', $companywpuser_id)->where('person_type', 'director')->first();
        $companywpuser_nominee_secretary = CompanyWpuserNominee::where('companywpuser_id', $companywpuser_id)->where('person_type', 'secretary')->first();

        ///////

        $companywpuser_informationservices = CompanyWpuser::with(['informationservices'])->where('company_id', $company->id)->where('id', $companywpuser_id)->first();

        $informationservices = $companywpuser_informationservices->informationservices;

        $companywpuser_servicescountries = CompanyWpuser::with(['servicescountries'])->where('company_id', $company->id)->where('id', $companywpuser_id)->first();

        $servicescountries = $companywpuser_servicescountries->servicescountries;      
        
        foreach ($servicescountries as $key => $value) {
            $service = Service::where('id',$value->service_id)->first();
            $country = Country::where('id', $value->country_id)->first();

            $value->service_name = $service->name;
            $value->country_name = $country->name;            
        }

        $companywpuser = CompanyWpuser::where('company_id', $company->id)->where('id', $companywpuser_id)->first();

        $person = Person::select('person_code', 'first_name', 'surname', 'third_party_company_name')->get();

        $countryList = Country::lists('name', 'name')->all();

        return view('registeredcompany.edit', ['company'=>$company, 'informationservices'=>$informationservices, 'servicescountries'=>$servicescountries, 'companywpuser_nominee_shareholder'=>$companywpuser_nominee_shareholder, 'companywpuser_nominee_director'=>$companywpuser_nominee_director, 'companywpuser_nominee_secretary'=> $companywpuser_nominee_secretary, 'companywpuser' => $companywpuser, 'person' => $person, 'countryList' => $countryList ]);
    }

    private function replaceDateFormat($value) {
        return str_replace('/', '-', $value);
    }

    public function update(Request $request, $id) {     

        if($request->action_type=="Order completed" || $request->submit=="Order completed") {
            $status = 2;
        }
        elseif($request->action_type=="Reject order" || $request->submit=="Reject order") {
            $status = 3;
        }
        else {
            $status = 1;
        }        
        
        $company = Company::with(['wpusers'])->where('id', $id)->first();

        foreach($company->wpusers as $key => $wpuser) {
            if($wpuser->pivot->status==1) {
                $companywpuser_id = $wpuser->pivot->id;
            }
        }

        $companywpuser = CompanyWpuser::find($companywpuser_id);

        ////
        //// updating company related fields
        ////

        $companywpuser->owner_person_code = $request->user_person_code;
        $companywpuser->reg_no = $request->reg_no;
        $companywpuser->tax_no = $request->tax_no;
        $companywpuser->vat_reg_no = $request->vat_reg_no;        
        $companywpuser->reg_office = $request->reg_office;
        $companywpuser->status = $status;

        ////
        //// updating date fields
        //// 
        
        $companywpuser->date_of_next_accounts = date('Y-m-d', strtotime($this->replaceDateFormat($request->date_of_next_accounts)));
        $companywpuser->date_of_last_accounts = date('Y-m-d', strtotime($this->replaceDateFormat($request->date_of_last_accounts)));
        $companywpuser->next_domiciliation_renewal = date('Y-m-d', strtotime($this->replaceDateFormat($request->next_domiciliation_renewal)));
        $companywpuser->accounts_completion_deadline = date('Y-m-d', strtotime($this->replaceDateFormat($request->accounts_completion_deadline)));
        $companywpuser->date_of_last_vat_return = date('Y-m-d', strtotime($this->replaceDateFormat($request->date_of_last_vat_return)));
        $companywpuser->date_of_next_vat_return = date('Y-m-d', strtotime($this->replaceDateFormat($request->date_of_next_vat_return)));
        $companywpuser->vat_return_deadline = date('Y-m-d', strtotime($this->replaceDateFormat($request->vat_return_deadline)));
        $companywpuser->next_agm_due_by = date('Y-m-d', strtotime($this->replaceDateFormat($request->next_agm_due_by)));

        ////
        //// updating pdf upload fields
        ////

        $companywpuser->incorporation_certificate = $request->incorporation_certificate;
        $companywpuser->incumbency_certificate = $request->incumbency_certificate;
        $companywpuser->company_extract = $request->company_extract;
        $companywpuser->last_financial_statements = $request->last_financial_statements;
        $companywpuser->other_documents_1 = $request->other_documents_1;
        $companywpuser->other_documents_2 = $request->other_documents_2;
        $companywpuser->other_documents_3 = $request->other_documents_3;
        $companywpuser->other_documents_4 = $request->other_documents_4;
        $companywpuser->other_documents_5 = $request->other_documents_5;
        $companywpuser->other_documents_6 = $request->other_documents_6;
        $companywpuser->other_documents_1_title = $request->other_documents_1_title;
        $companywpuser->other_documents_2_title = $request->other_documents_2_title;
        $companywpuser->other_documents_3_title = $request->other_documents_3_title;
        $companywpuser->other_documents_4_title = $request->other_documents_4_title;
        $companywpuser->other_documents_5_title = $request->other_documents_5_title;
        $companywpuser->other_documents_6_title = $request->other_documents_6_title;
        $companywpuser->notes = $request->notes;

        if(!empty($request->actual_payment_response))
            $companywpuser->actual_payment_response = $request->actual_payment_response;

        ////
        //// updating nominee director/secretary fields
        ////

        // $companywpuser->nominee_director_person_code = $request->nominee_director_person_code;
        // $companywpuser->nominee_secretary_person_code = $request->nominee_secretary_person_code;

        $companywpuser->save(); 

        // update company    

        $company = Company::find($id);
        $company->name = $request->input('company_name');
        if($request->action_type=="Order completed" || $request->submit=="Order completed") {
            $company->code = $request->input('company_code');
        }elseif($request->action_type=="Reject order" || $request->submit=="Reject order") {
            if(empty($company->code) || $company->code == "Pending") $company->code = "Rejected";
        }else {
            if((empty($company->code) || $company->code == "Rejected") || $request->company_code!=="Pending")
            {
                if($request->company_code!=="Pending") $company->code = $request->company_code;
                else $company->code = "Pending";                  
            }
        }

        $company->incorporation_date = date('Y-m-d', strtotime($this->replaceDateFormat($request->incorporation_date)));

        if($request->action_type=="Order completed" || $request->submit=="Order completed") {
            $company->status = 1; // approved
        }
        if($request->action_type=="Reject order" || $request->submit=="Reject order") {
            $company->status = 0; // rejected
        }
        $company->save();   

        ////
        //// updating persons fields
        ////

        $companywpuser_directors = CompanyWpuserDirector::where('companywpuser_id', $companywpuser_id)->get();
        $companywpuser_shareholders = CompanyWpuserShareholder::where('companywpuser_id', $companywpuser_id)->get();
        $companywpuser_secretaries = CompanyWpuserSecretary::where('companywpuser_id', $companywpuser_id)->get();                

        foreach ($companywpuser_shareholders as $key => $companywpuser_shareholder) {
            $no = $key + 1;
            $companywpuser_shareholder->type = $request->input('shareholder_'.$no.'_type'); 
            $companywpuser_shareholder->name = $request->input('shareholder_'.$no.'_name');
            $companywpuser_shareholder->address = $request->input('shareholder_'.$no.'_address');
            $companywpuser_shareholder->address_2 = $request->input('shareholder_'.$no.'_address_2');
            $companywpuser_shareholder->address_3 = $request->input('shareholder_'.$no.'_address_3');
            $companywpuser_shareholder->address_4 = $request->input('shareholder_'.$no.'_address_4');
            $companywpuser_shareholder->address_5 = $request->input('shareholder_'.$no.'_address_5');
            $companywpuser_shareholder->telephone = $request->input('shareholder_'.$no.'_telephone');
            $companywpuser_shareholder->passport = $request->input('shareholder_'.$no.'_passport');
            $companywpuser_shareholder->bill = $request->input('shareholder_'.$no.'_bill');
            $companywpuser_shareholder->shareholder = $request->input('shareholder_'.$no.'_shareholder');
            $companywpuser_shareholder->share_amount = $request->input('shareholder_'.$no.'_share_amount');
            $companywpuser_shareholder->person_code = $request->input('shareholder_'.$no.'_person_code');

            $person = Person::select("id")->where("person_code", $request->input('shareholder_'.$no.'_person_code'))->first();            

            if(!empty($person)) $companywpuser_shareholder->person_id = $person->id;

            $companywpuser_shareholder->save();
        }

        // when nominee person code entered save as normal director
        // previously saved only person code        
        if(!empty($request->nominee_director_person_code)) {
            $companywpuser_director = new CompanyWpuserDirector;
            $companywpuser_director->companywpuser_id = $companywpuser_id;
            $companywpuser_director->person_code = $request->nominee_director_person_code;

            $person = Person::where("person_code", $request->nominee_director_person_code)->first();

            if(!empty($person)) $companywpuser_director->person_id = $person->id;
            if(!empty($person)) $companywpuser_director->type = $person->person_type;
            if(!empty($person)) $companywpuser_director->name = $person->first_name . ' ' . $person->surname;
            if(!empty($person)) $companywpuser_director->address = $person->home_address;
            if(!empty($person)) $companywpuser_director->address_2 = $person->home_address_3;
            if(!empty($person)) $companywpuser_director->address_3 = $person->home_address_5;
            if(!empty($person)) $companywpuser_director->address_4 = $person->home_address_6;
            if(!empty($person)) $companywpuser_director->address_5 = $person->home_address_2;
            if(!empty($person)) $companywpuser_director->telephone = $person->mobile_telephone;
            $companywpuser_director->save();
        }

        foreach ($companywpuser_directors as $key => $companywpuser_director) {
            $no = $key + 1;                    

            $person = Person::where("person_code", $request->input('director_'.$no.'_person_code'))->first();            

            if(!empty($person)) {
                $companywpuser_director->person_id = $person->id;
                $companywpuser_director->type = $person->person_type;
                $companywpuser_director->name = $person->first_name . ' ' . $person->surname;
                $companywpuser_director->address = $person->home_address;
                $companywpuser_director->address_2 = $person->home_address_3;
                $companywpuser_director->address_3 = $person->home_address_5;
                $companywpuser_director->address_4 = $person->home_address_6;
                $companywpuser_director->address_5 = $person->home_address_2;
                $companywpuser_director->telephone = $person->mobile_telephone;
            }else {
                $companywpuser_director->type = $request->input('director_'.$no.'_type'); 
                $companywpuser_director->name = $request->input('director_'.$no.'_name');
                $companywpuser_director->address = $request->input('director_'.$no.'_address');
                $companywpuser_director->address_2 = $request->input('director_'.$no.'_address_2');
                $companywpuser_director->address_3 = $request->input('director_'.$no.'_address_3');
                $companywpuser_director->address_4 = $request->input('director_'.$no.'_address_4');
                $companywpuser_director->address_5 = $request->input('director_'.$no.'_address_5');
                $companywpuser_director->telephone = $request->input('director_'.$no.'_telephone');
            }

            $companywpuser_director->passport = $request->input('director_'.$no.'_passport');
            $companywpuser_director->bill = $request->input('director_'.$no.'_bill');      
            $companywpuser_director->person_code = $request->input('director_'.$no.'_person_code');

            $companywpuser_director->save();
        }

        foreach ($companywpuser_secretaries as $key => $companywpuser_secretary) {
            $no = $key + 1;            

            $person = Person::where("person_code", $request->input('secretary_'.$no.'_person_code'))->first();   

            // return $request->input('secretary_'.$no.'_person_code');         

            // return $person;

            if(!empty($person)) {
                $companywpuser_secretary->person_id = $person->id;
                $companywpuser_secretary->type = $person->person_type;
                $companywpuser_secretary->name = $person->first_name . ' ' . $person->surname;
                $companywpuser_secretary->address = $person->home_address;
                $companywpuser_secretary->address_2 = $person->home_address_3;
                $companywpuser_secretary->address_3 = $person->home_address_5;
                $companywpuser_secretary->address_4 = $person->home_address_6;
                $companywpuser_secretary->address_5 = $person->home_address_2;
                $companywpuser_secretary->telephone = $person->mobile_telephone;
            }else {
                $companywpuser_secretary->person_id = NULL;
                $companywpuser_secretary->type = $request->input('secretary_'.$no.'_type'); 
                $companywpuser_secretary->name = $request->input('secretary_'.$no.'_name');
                $companywpuser_secretary->address = $request->input('secretary_'.$no.'_address');
                $companywpuser_secretary->address_2 = $request->input('secretary_'.$no.'_address_2');
                $companywpuser_secretary->address_3 = $request->input('secretary_'.$no.'_address_3');
                $companywpuser_secretary->address_4 = $request->input('secretary_'.$no.'_address_4');
                $companywpuser_secretary->address_5 = $request->input('secretary_'.$no.'_address_5');
                $companywpuser_secretary->telephone = $request->input('secretary_'.$no.'_telephone');
            }

            $companywpuser_secretary->passport = $request->input('secretary_'.$no.'_passport');
            $companywpuser_secretary->bill = $request->input('secretary_'.$no.'_bill');
            $companywpuser_secretary->person_code = $request->input('secretary_'.$no.'_person_code');

            $companywpuser_secretary->save();
        }

        // when nominee person code entered save as normal director
        // previously saved only person code        
        if(!empty($request->nominee_secretary_person_code)) {
            $companywpuser_secretary = new CompanyWpuserSecretary;
            $companywpuser_secretary->companywpuser_id = $companywpuser_id;
            $companywpuser_secretary->person_code = $request->nominee_secretary_person_code;

            $person = Person::where("person_code", $request->nominee_secretary_person_code)->first();

            if(!empty($person)) $companywpuser_secretary->person_id = $person->id;
            if(!empty($person)) $companywpuser_secretary->type = $person->person_type;
            if(!empty($person)) $companywpuser_secretary->name = $person->first_name . ' ' . $person->surname;
            if(!empty($person)) $companywpuser_secretary->address = $person->home_address;
            if(!empty($person)) $companywpuser_secretary->address_2 = $person->home_address_3;
            if(!empty($person)) $companywpuser_secretary->address_3 = $person->home_address_5;
            if(!empty($person)) $companywpuser_secretary->address_4 = $person->home_address_6;
            if(!empty($person)) $companywpuser_secretary->address_5 = $person->home_address_2;
            if(!empty($person)) $companywpuser_secretary->telephone = $person->mobile_telephone;
            $companywpuser_secretary->save();
        }

        return redirect('officiumtutus/registeredcompany');
        

    }

    public function hidePendingOrder(Request $request) {
        $companywpuser_id = $request->companywpuser_id;
        $company_wpuser = CompanyWpuser::find($companywpuser_id);

        $company_wpuser->hide_in_pending_order = 1;
        $company_wpuser->save();

        return response()->json(['message' => 'Successfully deleted'], 200);    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ids = explode(',', $id);

        foreach ($ids as $key => $each_id) {

            $company = Company::find($each_id);
            $company_wpuser = CompanyWpuser::where("company_id", $each_id)->first();

            $company_wpuser_id = $company_wpuser->id;

            $company_wpuser_shareholder = CompanyWpuserShareholder::where("companywpuser_id", $company_wpuser_id);
            if($company_wpuser_shareholder) $company_wpuser_shareholder->delete();

            $company_wpuser_director = CompanyWpuserDirector::where("companywpuser_id", $company_wpuser_id);
            if($company_wpuser_director) $company_wpuser_director->delete();

            $company_wpuser_secretary = CompanyWpuserSecretary::where("companywpuser_id", $company_wpuser_id);
            if($company_wpuser_secretary) $company_wpuser_secretary->delete();

            $company_wpuser_service_country = CompanyWpuserServiceCountry::where("companywpuser_id", $company_wpuser_id);
            if($company_wpuser_service_country) $company_wpuser_service_country->delete();

            $company_wpuser_information_service = CompanyWpuserInformationService::where("companywpuser_id", $company_wpuser_id);
            if($company_wpuser_information_service) $company_wpuser_information_service->delete();

            $company_wpuser = CompanyWpuser::find($company_wpuser_id);        

            if($company_wpuser) $company_wpuser->delete();

            if($company) $affectedRows = $company->delete();

        }

        if($affectedRows) {
            return response()->json(['message' => 'Successfully deleted'], 200);    
        }else {
            return response()->json(['message' => 'Request failed', 'error' => $error], 412);    
        }
    }

}
