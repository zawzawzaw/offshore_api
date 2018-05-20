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
use App\CompanyWpuserServiceCountry;
use App\CompanyWpuserInformationService;
use App\CompanyWpuserNominee;
use App\CompanyType;
use App\Wpuser;
use App\Person;

class ApprovedcompanyController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private function isDateField($field) {

        $field = mb_strtolower($field);
        $field = trim($field);
        $field = str_replace(' ', '_', $field);

        return in_array($field, ['renewal', 'next_accounts', 'last_accounts', 'accounts_completion', 'last_vat', 'next_vat', 'domiciliation_renewal', 'vat_return', 'last_agm', 'next_agm']);
    }

    private function getFieldName($field) {

        $field = mb_strtolower($field);
        $field = trim($field);
        $field = str_replace(' ', '_', $field);

        $field_names = [
            'renewal' => 'renewal_date', 
            'next_accounts' => 'date_of_next_accounts', 
            'last_accounts' => 'date_of_last_accounts', 
            'accounts_completion' => 'accounts_completion_deadline', 
            'last_vat' => 'date_of_last_vat_return', 
            'next_vat' => 'date_of_next_vat_return', 
            'domiciliation_renewal' => 'next_domiciliation_renewal', 
            'vat_return' => 'vat_return_deadline', 
            'last_agm' => 'date_of_last_agm', 
            'next_agm' => 'next_agm_due_by'
        ];

        return (isset($field_names[$field])) ? $field_names[$field] : [];
    }

    private function checkIfDateIsValid($date) {
        # check if input date is valid
        $date = date_parse($this->replaceDateFormat($date));

        if ($date["error_count"] == 0 && checkdate($date["month"], $date["day"], $date["year"])) $date_valid = true;
        else $date_valid = false;

        return $date_valid;
    }

    public function changeDbDateFormat($date) {
        return date('Y-m-d', strtotime($this->replaceDateFormat($date)));
    }

    public function index(Request $request)
    {        
        if($request->search || ($request->search_from_date && $request->search_to_date && $request->search_date_field)) {            

            $from_date = $request->search_from_date;
            $to_date = $request->search_to_date;
            $date_field = $request->search_date_field;
            $keyword = $request->search;

            // return $from_date . ' ' . $to_date . ' ' . $date_field;

            if(!empty($date_field) && !empty($from_date) && !empty($to_date)) {
                $from_date = $this->changeDbDateFormat($from_date);
                $to_date = $this->changeDbDateFormat($to_date);

                if($date_field=='incorporation_date') {
                    $companies = Company::with(['wpusers' => function($q) {
                         $q->wherePivot('status', 2);
                    }, 'companytypes'])              
                    ->where(function($q) use($from_date, $to_date) {
                        $q->where('incorporation_date', '>=', $from_date)
                          ->where('incorporation_date', '<=', $to_date);
                    })
                    ->where(function($q) use($keyword) {
                        $q->where('name', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('code', 'LIKE', '%'.$keyword.'%')
                        ->orWhereHas('wpusers', function($q) use($keyword) {
                            $q->where('display_name', 'LIKE', '%'.$keyword.'%');
                        })
                        ->orWhereHas('companywpuser_shareholders', function($q) use($keyword) {
                            $q->where('name', 'LIKE', '%'.$keyword.'%');
                        })
                        ->orWhereHas('companywpuser_directors', function($q) use($keyword) {
                            $q->where('name', 'LIKE', '%'.$keyword.'%');
                        })
                        ->orWhereHas('companywpuser_secretaries', function($q) use($keyword) {
                            $q->where('name', 'LIKE', '%'.$keyword.'%');
                        });
                    })
                    ->get();

                    // return $companies;

                } else {

                    $companies = Company::with(['wpusers' => function($q) {
                        $q->wherePivot('status', 2);
                    }, 'companytypes'])                    
                    ->whereHas('wpusers', function($q) use($from_date, $to_date, $date_field) {
                        $q->where($date_field, '>=', $from_date)
                          ->where($date_field, '<=', $to_date);
                    })                    
                    ->where(function($q) use($keyword) {
                        $q->where('name', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('code', 'LIKE', '%'.$keyword.'%')
                        ->orWhereHas('wpusers', function($q) use($keyword) {
                            $q->where('display_name', 'LIKE', '%'.$keyword.'%');
                        })
                        ->orWhereHas('companywpuser_shareholders', function($q) use($keyword) {
                            $q->where('name', 'LIKE', '%'.$keyword.'%');
                        })
                        ->orWhereHas('companywpuser_directors', function($q) use($keyword) {
                            $q->where('name', 'LIKE', '%'.$keyword.'%');
                        })
                        ->orWhereHas('companywpuser_secretaries', function($q) use($keyword) {
                            $q->where('name', 'LIKE', '%'.$keyword.'%');
                        });
                    })
                    ->get();    

                    // return $companies;
                }                

            } else {

                $companies = Company::with(['wpusers' => function($q) {
                    $q->wherePivot('status', 2);
                }, 'companytypes', 'companywpuser_shareholders', 'companywpuser_directors', 'companywpuser_secretaries'])
                ->where('name', 'LIKE', '%'.$keyword.'%')
                ->orWhere('code', 'LIKE', '%'.$keyword.'%')             
                ->orWhere(function($q) use($keyword) {
                    $q->whereHas('companytypes', function($q) use($keyword) {
                        $q->where('jurisdiction', 'LIKE', '%'.$keyword.'%');
                    })
                    ->orWhereHas('wpusers', function($q) use($keyword) {
                        $q->where('display_name', 'LIKE', '%'.$keyword.'%');
                    });
                })
                ->orWhere(function($q) use($keyword) {
                    $q->whereHas('companywpuser_shareholders', function($q) use($keyword) {
                        $q->where('name', 'LIKE', '%'.$keyword.'%');
                    })
                    ->orWhereHas('companywpuser_directors', function($q) use($keyword) {
                        $q->where('name', 'LIKE', '%'.$keyword.'%');
                    })
                    ->orWhereHas('companywpuser_secretaries', function($q) use($keyword) {
                        $q->where('name', 'LIKE', '%'.$keyword.'%');
                    });
                })                
                ->get();

                // return $companies;

            }            

            // return $companies;

            // $companies = Company::with(['wpusers' => function($q) {
            //     $q->wherePivot('status', 2);
            // }, 'companytypes'])->whereHas('wpusers', function($q) use($from_date) {
            //     $q->where('renewal_date', '>=', $from_date);
            // })->get();        
            
        }else {
            $companies = Company::with(['wpusers' => function($q) {
                $q->wherePivot('status', 2);
            }, 'companytypes'])->get();
        }        

        $approvedcompanies = [];

        foreach ($companies as $key => $company) {
            if(count($company->wpusers) > 0) {
                $approvedcompanies[] = $company;
            }
        }    

    	// $companies = Company::with(['wpusers'])->where('status', 1)->where('code', '<>' , '')->where('code', '<>' , 'Rejected')->where('code', '<>' , 'New Inc')->get();

    	return view('approvedcompany.index', ['companies'=>$approvedcompanies]);
    }

    public function create() {

        $wpuser_companies = Wpuser::with(['companies'])->get();

        $userList = [];

        foreach ($wpuser_companies as $key => $wpuser_company) {
            foreach ($wpuser_company->companies as $key => $comp) {
                if(!empty($comp->pivot->owner_person_code)) {                                       

                    $p = Person::where('person_code', $comp->pivot->owner_person_code)->first();
                    $name = $p->first_name . ' ' . $p->surname;

                    $userList[$comp->pivot->wpuser_id] = $comp->pivot->owner_person_code . ' - ' . $name;
                                        
                    break;
                }
            }
        }     

        $placeholder = ["" => "Please select"];
        $userList = $placeholder + $userList;

        $companytypeList = CompanyType::orderBy('name', 'ASC')->lists('name', 'name')->all();
        $jurisdictionList = CompanyType::orderBy('jurisdiction', 'ASC')->lists('jurisdiction', 'jurisdiction')->all();

        $companytypeList = $placeholder + $companytypeList;
        $jurisdictionList = $placeholder + $jurisdictionList;

        $person = Person::select('person_code', 'first_name', 'surname')->get();

        return view('approvedcompany.create', ['userList'=>$userList, 'companytypeList'=>$companytypeList, 'jurisdictionList'=>$jurisdictionList, 'person'=> $person]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();

        $company = new Company;
        $company->code = $request->company_code;
        $company->name = $request->company_name;
        $company->incorporation_date = date('Y-m-d', strtotime($this->replaceDateFormat($request->incorporation_date)));
        $company->price = 0;
        $company->price_eu = 0;
        $company->shelf = 0;
        $company->status = 1;

        $company_type = CompanyType::where("jurisdiction", $request->jurisdiction)->where('name', $request->company_type)->first();

        if($company_type) $company->company_type_id = $company_type->id;
        else {
            $company_type = CompanyType::where("name", $request->company_type)->first();
            $company->company_type_id = $company_type->id;
        }

        $company->save();

        if($company->id) {

            $companywpuser = new CompanyWpuser;
            $companywpuser->company_id = $company->id;
            $companywpuser->wpuser_id = $request->wpuser_id;        
            // $companywpuser->renewal_date = date('Y-m-d H:i:s', strtotime(date("Y-m-d", time()) . " + 365 day"));
            $companywpuser->nominee_director = 0;
            $companywpuser->nominee_shareholder = 0;
            $companywpuser->nominee_secretary = 0;

            $companywpuser->reg_no = $request->reg_no;
            $companywpuser->tax_no = $request->tax_no;
            $companywpuser->vat_reg_no = $request->vat_reg_no;        
            $companywpuser->reg_office = $request->reg_office;
            $companywpuser->status = 2;
            $companywpuser->return = 0;

            $companywpuser->date_of_next_accounts = date('Y-m-d', strtotime($this->replaceDateFormat($request->date_of_next_accounts)));
            $companywpuser->date_of_last_accounts = date('Y-m-d', strtotime($this->replaceDateFormat($request->date_of_last_accounts)));
            $companywpuser->next_domiciliation_renewal = date('Y-m-d', strtotime($this->replaceDateFormat($request->next_domiciliation_renewal)));
            $companywpuser->accounts_completion_deadline = date('Y-m-d', strtotime($this->replaceDateFormat($request->accounts_completion_deadline)));
            $companywpuser->date_of_last_vat_return = date('Y-m-d', strtotime($this->replaceDateFormat($request->date_of_last_vat_return)));
            $companywpuser->date_of_next_vat_return = date('Y-m-d', strtotime($this->replaceDateFormat($request->date_of_next_vat_return)));
            $companywpuser->vat_return_deadline = date('Y-m-d', strtotime($this->replaceDateFormat($request->vat_return_deadline)));
            $companywpuser->next_agm_due_by = date('Y-m-d', strtotime($this->replaceDateFormat($request->next_agm_due_by)));

            $companywpuser->owner_person_code = $request->user_person_code;
            
            $companywpuser->save();

            $companywpuser_id = $companywpuser->id;

            ## Shareholder

            for($i = 1; $i<=$request->shareholder_count; $i++) {

                $companywpuser_shareholder = new CompanyWpuserShareholder;
                $companywpuser_shareholder->companywpuser_id = $companywpuser_id;
                $companywpuser_shareholder->shareholder = $request->input('shareholder_'.$i.'_shareholder');
                $companywpuser_shareholder->share_amount = $request->input('shareholder_'.$i.'_share_amount');
                $companywpuser_shareholder->person_code = $request->input('shareholder_'.$i.'_person_code');

                $person = Person::where("person_code", $request->input('shareholder_'.$i.'_person_code'))->first();

                if(!empty($person)) $companywpuser_shareholder->person_id = $person->id;
                if(!empty($person)) $companywpuser_shareholder->type = $person->person_type;
                if(!empty($person)) $companywpuser_shareholder->name = $person->first_name . ' ' . $person->surname;
                if(!empty($person)) $companywpuser_shareholder->address = $person->home_address;
                if(!empty($person)) $companywpuser_shareholder->address_2 = $person->home_address_3;
                if(!empty($person)) $companywpuser_shareholder->address_3 = $person->home_address_5;
                if(!empty($person)) $companywpuser_shareholder->address_4 = $person->home_address_6;
                if(!empty($person)) $companywpuser_shareholder->address_5 = $person->home_address_2;
                if(!empty($person)) $companywpuser_shareholder->telephone = $person->mobile_telephone;
                $companywpuser_shareholder->save();

            }

            ## Directors

            for($i = 1; $i<=$request->director_count; $i++) {

                $companywpuser_director = new CompanyWpuserDirector;
                $companywpuser_director->companywpuser_id = $companywpuser_id;
                $companywpuser_director->person_code = $request->input('director_'.$i.'_person_code');
                $person = Person::where("person_code", $request->input('director_'.$i.'_person_code'))->first();

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

            ## Secretaries

            $companywpuser_secretary = new CompanyWpuserSecretary;
            $companywpuser_secretary->companywpuser_id = $companywpuser_id;
            $companywpuser_secretary->person_code = $request->input('secretary_1_person_code');
            $person = Person::where("person_code", $request->input('secretary_1_person_code'))->first();

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

        return redirect('officiumtutus/approvedcompany');

    }

    public function show(Request $request, $id) {

        $company = Company::with(['wpusers'])->where("id", $id)->where('status', 1)->first();

        // $companywpuser_id = $company->wpusers[0]->pivot->id;
        foreach($company->wpusers as $key => $wpuser) {
            if($wpuser->pivot->status==2) {
                $companywpuser_id = $wpuser->pivot->id;
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
            }])->where("id", $id)->where('status', 1)->first();

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
        // return $company;

        return view('approvedcompany.show', ['company'=>$company, 'informationservices'=>$informationservices, 'servicescountries'=>$servicescountries, 'companywpuser_nominee_shareholder'=>$companywpuser_nominee_shareholder, 'companywpuser_nominee_director'=>$companywpuser_nominee_director, 'companywpuser_nominee_secretary'=> $companywpuser_nominee_secretary, 'companywpuser' => $companywpuser]);
    }

    public function edit(Request $request, $id) {

        $company = Company::with(['wpusers'])->where("id", $id)->where('status', 1)->first();

        $users_list = Wpuser::lists("user_nicename", "id")->all();

        $wpuser_companies = Wpuser::with(['companies'])->get();

        $usersList = [];

        foreach ($wpuser_companies as $key => $wpuser_company) {
            foreach ($wpuser_company->companies as $key => $comp) {
                if(!empty($comp->pivot->owner_person_code)) {                                       

                    $p = Person::where('person_code', $comp->pivot->owner_person_code)->first();
                    $name = $p->first_name . ' ' . $p->surname;

                    $usersList[$comp->pivot->wpuser_id] = $comp->pivot->owner_person_code . ' - ' . $name;
                                        
                    break;
                }
            }
        }

        if(count($company->wpusers) > 0) {
            foreach ($company->wpusers as $key => $wpuser) {
                if($wpuser->pivot->status==2) {
                    $companywpuser_id = $wpuser->pivot->id;
                }
            }            
        }

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
            }])->where("id", $id)->where('status', 1)->first();

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
        $companytypeList = CompanyType::orderBy('name', 'ASC')->lists('name', 'name')->all();
        $jurisdiction = CompanyType::orderBy('jurisdiction', 'ASC')->lists('jurisdiction', 'jurisdiction')->all();

        return view('approvedcompany.edit', ['company'=>$company, 'informationservices'=>$informationservices, 'servicescountries'=>$servicescountries, 'companywpuser_nominee_shareholder'=>$companywpuser_nominee_shareholder, 'companywpuser_nominee_director'=>$companywpuser_nominee_director, 'companywpuser_nominee_secretary'=> $companywpuser_nominee_secretary, 'companywpuser' => $companywpuser, 'person' => $person, 'countryList' => $countryList, 'userList' => $usersList, 'companytypeList' => $companytypeList, 'jurisdictionList' => $jurisdiction ]);
    }

    private function replaceDateFormat($value) {
        return str_replace('/', '-', $value);
    }

    public function update(Request $request, $id) {                    

        $company = Company::with(['wpusers'])->where('id', $id)->where('status', 1)->first();
                
        // $companywpuser_id = $company->wpusers[0]->pivot->id;
        foreach($company->wpusers as $key => $wpuser) {
            if($wpuser->pivot->status==2) {
                $companywpuser_id = $wpuser->pivot->id;
            }
        }

        $companywpuser = CompanyWpuser::find($companywpuser_id);

        ////
        //// updating company related fields
        ////

        $companywpuser->reg_no = $request->reg_no;
        $companywpuser->tax_no = $request->tax_no;
        $companywpuser->vat_reg_no = $request->vat_reg_no;        
        $companywpuser->reg_office = $request->reg_office;
        $companywpuser->wpuser_id = $request->wpuser_id;

        ////
        //// updating date fields
        //// 
        // $date_arr = date_parse_from_format("d/m/y", $request->date_of_next_accounts);
        // $companywpuser->date_of_next_accounts = date('Y-m-d', strtotime($request->date_of_next_accounts));

        // echo $request->date_of_next_accounts;
        // $request->date_of_next_accounts = str_replace('/', '-', $request->date_of_next_accounts);
        // echo date("jS F, Y", strtotime("11/12/10")); 
        // echo date('Y-m-d', strtotime($date_arr['year'].'-'.$date_arr['month'].'-'.$date_arr['day'])); exit();

        // echo date('Y-m-d', strtotime($request->date_of_next_accounts));
        // echo date('Y-m-d', strtotime($request->date_of_last_accounts));
        // echo date('Y-m-d', strtotime($request->accounts_completion_deadline));
        // exit();
        // $request->date_of_last_accounts;
        // $request->accounts_completion_deadline;        

        $companywpuser->date_of_next_accounts = date('Y-m-d', strtotime($this->replaceDateFormat($request->date_of_next_accounts)));
        $companywpuser->date_of_last_accounts = date('Y-m-d', strtotime($this->replaceDateFormat($request->date_of_last_accounts)));
        $companywpuser->next_domiciliation_renewal = date('Y-m-d', strtotime($this->replaceDateFormat($request->next_domiciliation_renewal)));
        $companywpuser->accounts_completion_deadline = date('Y-m-d', strtotime($this->replaceDateFormat($request->accounts_completion_deadline)));
        $companywpuser->date_of_last_vat_return = date('Y-m-d', strtotime($this->replaceDateFormat($request->date_of_last_vat_return)));
        $companywpuser->date_of_next_vat_return = date('Y-m-d', strtotime($this->replaceDateFormat($request->date_of_next_vat_return)));
        $companywpuser->vat_return_deadline = date('Y-m-d', strtotime($this->replaceDateFormat($request->vat_return_deadline)));
        $companywpuser->date_of_last_agm = date('Y-m-d', strtotime($this->replaceDateFormat($request->date_of_last_agm)));
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

        ////
        //// updating nominee director/secretary fields
        ////

        // $companywpuser->nominee_director_person_code = $request->nominee_director_person_code;
        // $companywpuser->nominee_secretary_person_code = $request->nominee_secretary_person_code;

        $companywpuser->save(); 

        // update company    

        $company = Company::find($id);
        $company->name = $request->input('company_name');
        $company->code = $request->input('company_code');
        $company->incorporation_date = date('Y-m-d', strtotime($this->replaceDateFormat($request->incorporation_date)));
        
        $company_type = CompanyType::where("jurisdiction", $request->jurisdiction)->where('name', $request->company_type)->first();

        if($company_type) $company->company_type_id = $company_type->id;
        else {
            $company_type = CompanyType::where("name", $request->company_type)->first();
            $company->company_type_id = $company_type->id;
        }

        $company->save();           

        ////
        //// updating persons fields
        ////

        $companywpuser_directors = CompanyWpuserDirector::where('companywpuser_id', $companywpuser_id)->get();
        $companywpuser_shareholders = CompanyWpuserShareholder::where('companywpuser_id', $companywpuser_id)->get();
        $companywpuser_secretaries = CompanyWpuserSecretary::where('companywpuser_id', $companywpuser_id)->get();        

        ###### SHAREHOLDERS

        // if(count($companywpuser_shareholders) > 0) {

            // save existing first
            // foreach ($companywpuser_shareholders as $key => $companywpuser_shareholder) {
            //     $no = $key + 1;                
            //     $companywpuser_shareholder->shareholder = $request->input('shareholder_'.$no.'_shareholder');
            //     $companywpuser_shareholder->share_amount = $request->input('shareholder_'.$no.'_share_amount');
            //     $companywpuser_shareholder->person_code = $request->input('shareholder_'.$no.'_person_code');

            //     $person = Person::where("person_code", $request->input('shareholder_'.$no.'_person_code'))->first();            

            //     if(!empty($person)) $companywpuser_shareholder->person_id = $person->id;
            //     if(!empty($person)) $companywpuser_shareholder->type = $person->person_type;
            //     if(!empty($person)) $companywpuser_shareholder->name = $person->first_name . ' ' . $person->surname;
            //     if(!empty($person)) $companywpuser_shareholder->address = $person->home_address;
            //     if(!empty($person)) $companywpuser_shareholder->address_2 = $person->home_address_3;
            //     if(!empty($person)) $companywpuser_shareholder->address_3 = $person->home_address_5;
            //     if(!empty($person)) $companywpuser_shareholder->address_4 = $person->home_address_6;
            //     if(!empty($person)) $companywpuser_shareholder->address_5 = $person->home_address_2;
            //     if(!empty($person)) $companywpuser_shareholder->telephone = $person->mobile_telephone;
            //     $companywpuser_shareholder->save();
            // }

            // // then save the new ones start from existings plus one
            // $i = count($companywpuser_shareholders) + 1;

            // for($i; $i<=$request->shareholder_count; $i++) {

            //     # debug
            //     // echo $i .'<br>';
            //     // echo $request->input('shareholder_'.$i.'_shareholder') .'<br>';
            //     // echo $request->input('shareholder_'.$i.'_person_code') .'<br>';
            //     // echo $request->input('shareholder_'.$i.'_share_amount') .'<br>';                

            //     $companywpuser_shareholder = new CompanyWpuserShareholder;
            //     $companywpuser_shareholder->companywpuser_id = $companywpuser_id;
            //     $companywpuser_shareholder->shareholder = $request->input('shareholder_'.$i.'_shareholder');
            //     $companywpuser_shareholder->share_amount = $request->input('shareholder_'.$i.'_share_amount');
            //     $companywpuser_shareholder->person_code = $request->input('shareholder_'.$i.'_person_code');

            //     $person = Person::where("person_code", $request->input('shareholder_'.$i.'_person_code'))->first();

            //     if(!empty($person)) $companywpuser_shareholder->person_id = $person->id;
            //     if(!empty($person)) $companywpuser_shareholder->type = $person->person_type;
            //     if(!empty($person)) $companywpuser_shareholder->name = $person->first_name . ' ' . $person->surname;
            //     if(!empty($person)) $companywpuser_shareholder->address = $person->home_address;
            //     if(!empty($person)) $companywpuser_shareholder->address_2 = $person->home_address_3;
            //     if(!empty($person)) $companywpuser_shareholder->address_3 = $person->home_address_5;
            //     if(!empty($person)) $companywpuser_shareholder->address_4 = $person->home_address_6;
            //     if(!empty($person)) $companywpuser_shareholder->address_5 = $person->home_address_2;
            //     if(!empty($person)) $companywpuser_shareholder->telephone = $person->mobile_telephone;
            //     $companywpuser_shareholder->save();

            // }

        // } else {            

            for($i = 1; $i<=$request->shareholder_count; $i++) {

                if(isset($companywpuser_shareholders[$i-1])) {
                    # replace/save existing shareholder
                    $companywpuser_shareholder = $companywpuser_shareholders[$i-1];                    
                }else {
                    # create new shareholder                    
                    $companywpuser_shareholder = new CompanyWpuserShareholder;
                    $companywpuser_shareholder->companywpuser_id = $companywpuser_id;
                }

                $companywpuser_shareholder->shareholder = $request->input('shareholder_'.$i.'_shareholder');
                $companywpuser_shareholder->share_amount = $request->input('shareholder_'.$i.'_share_amount');
                $companywpuser_shareholder->person_code = $request->input('shareholder_'.$i.'_person_code');

                $person = Person::where("person_code", $request->input('shareholder_'.$i.'_person_code'))->first();            

                if(!empty($person)) $companywpuser_shareholder->person_id = $person->id;
                if(!empty($person)) $companywpuser_shareholder->type = $person->person_type;
                if(!empty($person)) $companywpuser_shareholder->name = $person->first_name . ' ' . $person->surname;
                if(!empty($person)) $companywpuser_shareholder->address = $person->home_address;
                if(!empty($person)) $companywpuser_shareholder->address_2 = $person->home_address_3;
                if(!empty($person)) $companywpuser_shareholder->address_3 = $person->home_address_5;
                if(!empty($person)) $companywpuser_shareholder->address_4 = $person->home_address_6;
                if(!empty($person)) $companywpuser_shareholder->address_5 = $person->home_address_2;
                if(!empty($person)) $companywpuser_shareholder->telephone = $person->mobile_telephone;
                $companywpuser_shareholder->save();                

            }

            $existing_shareholder_count = count($companywpuser_shareholders);
            if($existing_shareholder_count > $request->shareholder_count) {
                
                // delete existing shareholders if they got deleted in edit form
                $i = $request->shareholder_count + 1;

                for($i; $i<=$existing_shareholder_count; $i++) {
                    $companywpuser_shareholder = $companywpuser_shareholders[$i-1];
                    $companywpuser_shareholder->delete();
                }

            }

        // }

        ####### DIRECTORS

        // if(count($companywpuser_directors) > 0) {

            // save existing first
            // foreach ($companywpuser_directors as $key => $companywpuser_director) {
            //     $no = $key + 1;
            //     $companywpuser_director->person_code = $request->input('director_'.$no.'_person_code');

            //     $person = Person::where("person_code", $request->input('director_'.$no.'_person_code'))->first();

            //     if(!empty($person)) $companywpuser_director->person_id = $person->id;
            //     if(!empty($person)) $companywpuser_director->type = $person->person_type;
            //     if(!empty($person)) $companywpuser_director->name = $person->first_name . ' ' . $person->surname;
            //     if(!empty($person)) $companywpuser_director->address = $person->home_address;
            //     if(!empty($person)) $companywpuser_director->address_2 = $person->home_address_3;
            //     if(!empty($person)) $companywpuser_director->address_3 = $person->home_address_5;
            //     if(!empty($person)) $companywpuser_director->address_4 = $person->home_address_6;
            //     if(!empty($person)) $companywpuser_director->address_5 = $person->home_address_2;
            //     if(!empty($person)) $companywpuser_director->telephone = $person->mobile_telephone;
            //     $companywpuser_director->save();
            // }

            // // then save the new ones start from existings plus one
            // $i = count($companywpuser_directors) + 1;

            // for($i; $i<=$request->director_count; $i++) {
            //     $companywpuser_director = new CompanyWpuserDirector;
            //     $companywpuser_director->companywpuser_id = $companywpuser_id;
            //     $companywpuser_director->person_code = $request->input('director_'.$i.'_person_code');

            //     $person = Person::where("person_code", $request->input('director_'.$i.'_person_code'))->first();

            //     if(!empty($person)) $companywpuser_director->person_id = $person->id;
            //     if(!empty($person)) $companywpuser_director->type = $person->person_type;
            //     if(!empty($person)) $companywpuser_director->name = $person->first_name . ' ' . $person->surname;
            //     if(!empty($person)) $companywpuser_director->address = $person->home_address;
            //     if(!empty($person)) $companywpuser_director->address_2 = $person->home_address_3;
            //     if(!empty($person)) $companywpuser_director->address_3 = $person->home_address_5;
            //     if(!empty($person)) $companywpuser_director->address_4 = $person->home_address_6;
            //     if(!empty($person)) $companywpuser_director->address_5 = $person->home_address_2;
            //     if(!empty($person)) $companywpuser_director->telephone = $person->mobile_telephone;
            //     $companywpuser_director->save();
            // }

        // } else if(count($companywpuser_directors) <= 0 && empty($request->nominee_director_person_code)) {
        // } else {
            
            for($i = 1; $i<=$request->director_count; $i++) {                

                if(isset($companywpuser_directors[$i-1])) {
                    # replace/save existing director
                    $companywpuser_director = $companywpuser_directors[$i-1];
                }else {
                    # create new director                    
                    $companywpuser_director = new CompanyWpuserDirector;
                    $companywpuser_director->companywpuser_id = $companywpuser_id;
                }

                $companywpuser_director->person_code = $request->input('director_'.$i.'_person_code');
                $person = Person::where("person_code", $request->input('director_'.$i.'_person_code'))->first();

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

            $existing_director_count = count($companywpuser_directors);
            if($existing_director_count > $request->director_count) {
                
                // delete existing directors if they got deleted in edit form
                $i = $request->director_count + 1;

                for($i; $i<=$existing_director_count; $i++) {
                    $companywpuser_director = $companywpuser_directors[$i-1];
                    $companywpuser_director->delete();
                }

            }

        // }

        ####### SECRETARIES

        if(count($companywpuser_secretaries) > 0) {

            foreach ($companywpuser_secretaries as $key => $companywpuser_secretary) {
                $no = $key + 1;
                $companywpuser_secretary->person_code = $request->input('secretary_'.$no.'_person_code');

                $person = Person::where("person_code", $request->input('secretary_'.$no.'_person_code'))->first();

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

        } else {
        //else if(count($companywpuser_secretaries) <= 0 && empty($request->nominee_secretary_person_code)) {

            $companywpuser_secretary = new CompanyWpuserSecretary;
            $companywpuser_secretary->companywpuser_id = $companywpuser_id;
            $companywpuser_secretary->person_code = $request->input('secretary_1_person_code');
            $person = Person::where("person_code", $request->input('secretary_1_person_code'))->first();

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

        //////
        // update owner person code

        $company_wpuser = CompanyWpuser::find($companywpuser_id);
        $company_wpuser->owner_person_code = $request->user_person_code;        
        $company_wpuser->save();


        return redirect('officiumtutus/approvedcompany');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);
        $company_wpuser = CompanyWpuser::where("company_id", $id)->first();

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

        if($affectedRows)
            return redirect('officiumtutus/approvedcompany');
        else
            return redirect('officiumtutus/approvedcompany?error=true');
    }
}
