<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Wpuser;
use App\WpBpXprofileData;
use App\WpBpXprofileFields;
use App\WpuserLoginLog;
use App\Person;
use App\CompanyWpuserShareholder;
use App\CompanyWpuserDirector;
use App\CompanyWpuserSecretary;
use App\Country;
use App\CompanyWpuser;

class PersonController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
    	
    	// $wpusers = Wpuser::select('ID', 'user_nicename', 'user_email', 'user_registered')->get();
        $persons = Person::get();

    	return view('person.index', ['persons'=>$persons]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $countryList = Country::lists('name', 'name')->all();

        $placeholder = ["" => "Please select"];
        $countryList = $placeholder + $countryList;

        return view('person.create', ['countryList'=>$countryList]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $person = new Person;
        $person->person_code = $request->person_code;
        $person->person_type = $request->person_type;
        $person->third_party_company_name = (!empty($request->third_party_company_name)) ? $request->third_party_company_name : "";
        $person->third_party_company_jurisdiction = (!empty($request->third_party_company_jurisdiction)) ? $request->third_party_company_jurisdiction: "";
        $person->third_party_company_reg_no = (!empty($request->third_party_company_name)) ? $request->third_party_company_reg_no: "";
        $person->title = $request->title;
        $person->first_name = $request->first_name;
        $person->surname = $request->surname;
        $person->nationality = $request->nationality;
        $person->passport_no = $request->passport_no;
        $person->passport_expiry = date('Y-m-d', strtotime($this->replaceDateFormat($request->passport_expiry)));
        $person->tax_residence = $request->tax_residence;
        $person->tax_number = $request->tax_number;
        $person->email = $request->email;
        $person->mobile_telephone = $request->mobile_telephone;
        $person->work_telephone = $request->work_telephone;
        $person->home_telephone = $request->home_telephone;
        $person->home_address = $request->home_address;
        $person->home_address_2 = $request->home_address_2;
        $person->home_address_3 = $request->home_address_3;
        $person->home_address_6 = $request->home_address_6;
        $person->home_address_5 = $request->home_address_5;
        $person->postal_address = $request->postal_address;
        $person->postal_address_2 = $request->postal_address_2;
        $person->postal_address_3 = $request->postal_address_3;
        $person->postal_address_6 = $request->postal_address_6;
        $person->postal_address_5 = $request->postal_address_5;
        $person->preferred_currency = $request->preferred_currency;
        // $person->account_registered = date('Y-m-d', strtotime($this->replaceDateFormat($request->account_registered)));
        // $person->login_ip = (!empty($request->login_ip)) ? $request->login_ip : "";
        $person->relationship_commenced = date('Y-m-d', strtotime($this->replaceDateFormat($request->relationship_commenced)));
        $person->relationship_ended = date('Y-m-d', strtotime($this->replaceDateFormat($request->relationship_ended)));
        $person->passport_copy = $request->passport_copy;
        $person->proof_of_address = $request->proof_of_address;
        $person->bank_reference = $request->bank_reference;
        $person->professional_reference = $request->professional_reference;
        $person->notes = $request->notes;
        $person->save();

        return redirect('officiumtutus/person');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //              
        $person = Person::find($id);
        $countryList = Country::lists('name', 'name')->all();

        $placeholder = ["" => "Please select"];
        $countryList = $placeholder + $countryList;

        return view('person.show', ['person'=>$person, 'countryList'=> $countryList]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {

        $person = Person::find($id);
        $countryList = Country::lists('name', 'name')->all();

        $placeholder = ["" => "Please select"];
        $countryList = $placeholder + $countryList;

    	return view('person.edit', ['person'=>$person, 'countryList'=> $countryList]);

    }

    private function replaceDateFormat($value) {
        return str_replace('/', '-', $value);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {    	

        $person = Person::find($id);
        $person->person_code = $request->person_code;
        $person->person_type = $request->person_type;
        $person->third_party_company_name = $request->third_party_company_name;
        $person->third_party_company_jurisdiction = $request->third_party_company_jurisdiction;
        $person->third_party_company_reg_no = $request->third_party_company_reg_no;
        $person->title = $request->title;
        $person->first_name = $request->first_name;
        $person->surname = $request->surname;        
        $person->nationality = $request->nationality;        
        $person->passport_no = $request->passport_no;        
        $person->passport_expiry = date('Y-m-d', strtotime($this->replaceDateFormat($request->passport_expiry)));
        $person->tax_residence = $request->tax_residence;        
        $person->tax_number = $request->tax_number;        
        $person->email = $request->email;        
        $person->mobile_telephone = $request->mobile_telephone;
        $person->work_telephone = $request->work_telephone;
        $person->home_telephone = $request->home_telephone;
        $person->home_address = $request->home_address;
        $person->home_address_2 = $request->home_address_2;
        $person->home_address_3 = $request->home_address_3;
        $person->home_address_6 = $request->home_address_6;
        $person->home_address_5 = $request->home_address_5; 
        $person->postal_address = $request->postal_address; 
        $person->postal_address_2 = $request->postal_address_2; 
        $person->postal_address_3 = $request->postal_address_3; 
        $person->postal_address_6 = $request->postal_address_6; 
        $person->postal_address_5 = $request->postal_address_5; 
        $person->preferred_currency = $request->preferred_currency; 
        // $person->account_registered = date('Y-m-d', strtotime($this->replaceDateFormat($request->account_registered)));
        // $person->login_ip = $request->login_ip;
        $person->relationship_commenced = date('Y-m-d', strtotime($this->replaceDateFormat($request->relationship_commenced)));
        $person->relationship_ended = date('Y-m-d', strtotime($this->replaceDateFormat($request->relationship_ended)));
        $person->passport_copy = $request->passport_copy; 
        $person->proof_of_address = $request->proof_of_address; 
        $person->bank_reference = $request->bank_reference; 
        $person->professional_reference = $request->professional_reference; 
        $person->notes = $request->notes;
        $person->save();

        if($request->person_role=="shareholder") {
            $companywpuser_shareholder = CompanyWpuserShareholder::where('person_code', $request->person_code)->first();
            $companywpuser_shareholder->type = $request->person_type; 
            $companywpuser_shareholder->name = $request->first_name . " " . $request->surname;
            $companywpuser_shareholder->address = $request->home_address;
            $companywpuser_shareholder->address_2 = $request->home_address_3;
            $companywpuser_shareholder->address_4 = $request->home_address_6;
            $companywpuser_shareholder->telephone = $request->mobile_telephone;
            $companywpuser_shareholder->passport = $request->passport_copy;
            $companywpuser_shareholder->save();
        }

        if($request->person_role=="director") {
            $companywpuser_director = CompanyWpuserDirector::where('person_code', $request->person_code)->first();
            $companywpuser_director->type = $request->person_type; 
            $companywpuser_director->name = $request->first_name . " " . $request->surname;
            $companywpuser_director->address = $request->home_address;
            $companywpuser_director->address_2 = $request->home_address_3;
            $companywpuser_director->address_4 = $request->home_address_6;
            $companywpuser_director->telephone = $request->mobile_telephone;
            $companywpuser_director->passport = $request->passport_copy;
            $companywpuser_director->save();
        }

        if($request->person_role=="secretary") {
            $companywpuser_secretary = CompanyWpuserSecretary::where('person_code', $request->person_code)->first();
            $companywpuser_secretary->type = $request->person_type; 
            $companywpuser_secretary->name = $request->first_name . " " . $request->surname;
            $companywpuser_secretary->address = $request->home_address;
            $companywpuser_secretary->address_2 = $request->home_address_3;
            $companywpuser_secretary->address_4 = $request->home_address_6;
            $companywpuser_secretary->telephone = $request->mobile_telephone;
            $companywpuser_secretary->passport = $request->passport_copy;
            $companywpuser_secretary->save();
        }

        if($request->person_role=="owner") {
            /* edit of exisitng account owners */
            $companywpuser = CompanyWpuser::where('owner_person_code', $request->person_code)->first();

            if($companywpuser) {

                $wpuser = Wpuser::find($companywpuser->wpuser_id);
                $wpuser->user_email = $request->email;
                // $wpuser->user_registered = $request->account_registered;
                $wpuser->save();

                $fields = WpBpXprofileFields::select('id', 'name')->get();

                foreach ($fields as $key => $field) {
                    if($field->name == "Person code") $person_code_field_id = $field->id;
                    if($field->name == "Person type") $person_type_field_id = $field->id;
                    if($field->name == "Title") $title_field_id = $field->id;
                    if($field->name == "First name") $first_name_field_id = $field->id;
                    if($field->name == "Surname") $surname_field_id = $field->id;           
                    if($field->name == "Nationality") $nationality_field_id = $field->id;
                    if($field->name == "Passport no") $passport_no_field_id = $field->id;
                    if($field->name == "Passport expiry") $passport_expiry_field_id = $field->id;
                    if($field->name == "Tax residence") $tax_residence_field_id = $field->id;
                    if($field->name == "Tax number") $tax_number_field_id = $field->id;
                    if($field->name == "Mobile telephone") $mobile_telephone_field_id = $field->id;
                    if($field->name == "Work telephone") $work_telephone_field_id = $field->id;
                    if($field->name == "Home telephone") $home_telephone_field_id = $field->id;
                    if($field->name == "Home address") $home_address_field_id = $field->id;
                    if($field->name == "Home address 2") $home_address_2_field_id = $field->id;
                    if($field->name == "Home address 3") $home_address_3_field_id = $field->id;
                    if($field->name == "Home address 6") $home_address_6_field_id = $field->id;
                    if($field->name == "Home address 5") $home_address_5_field_id = $field->id;
                    if($field->name == "Postal address") $postal_address_field_id = $field->id;
                    if($field->name == "Postal address 2") $postal_address_2_field_id = $field->id;
                    if($field->name == "Postal address 3") $postal_address_3_field_id = $field->id;
                    if($field->name == "Postal address 6") $postal_address_6_field_id = $field->id;
                    if($field->name == "Postal address 5") $postal_address_5_field_id = $field->id;         
                    if($field->name == "Preferred currency") $preferred_currency_field_id = $field->id;         
                    if($field->name == "Relationship commenced") $relationship_commenced_field_id = $field->id;
                    if($field->name == "Relationship ended") $relationship_ended_field_id = $field->id;
                    if($field->name == "Passport copy") $passport_copy_field_id = $field->id;
                    if($field->name == "Proof of address") $proof_of_address_field_id = $field->id;
                    if($field->name == "Bank reference") $bank_reference_field_id = $field->id;
                    if($field->name == "Professional reference") $professional_reference_field_id = $field->id;
                    if($field->name == "Notes") $notes_field_id = $field->id;
                }

                $id = $companywpuser->wpuser_id;

                $person_code = WpBpXprofileData::where("field_id", $person_code_field_id)->where("user_id", $id)->first();
                if(empty($person_code)){
                 $person_code = new WpBpXprofileData;
                 $person_code->field_id = $person_code_field_id;
                 $person_code->user_id = $id;
                }
                $person_code->value = $request->person_code;
                $person_code->save();

                $person_type = WpBpXprofileData::where("field_id", $person_type_field_id)->where("user_id", $id)->first();
                if(empty($person_type)){
                 $person_type = new WpBpXprofileData;
                 $person_type->field_id = $person_type_field_id;
                 $person_type->user_id = $id;
                }
                $person_type->value = $request->person_type;
                $person_type->save();

                $title =  WpBpXprofileData::where("field_id", $title_field_id)->where("user_id", $id)->first();
                if(empty($title)){
                    $title = new WpBpXprofileData;
                    $title->field_id = $title_field_id;
                    $title->user_id = $id;
                }
                $title->value = $request->title;
                $title->save();

                $first_name =  WpBpXprofileData::where("field_id", $first_name_field_id)->where("user_id", $id)->first();
                if(empty($first_name)){
                 $first_name = new WpBpXprofileData;
                 $first_name->field_id = $first_name_field_id;
                 $first_name->user_id = $id;
                }
                $first_name->value = $request->first_name;
                $first_name->save();

                $surname =  WpBpXprofileData::where("field_id", $surname_field_id)->where("user_id", $id)->first();
                if(empty($surname)){
                    $surname = new WpBpXprofileData;
                    $surname->field_id = $surname_field_id;
                    $surname->user_id = $id;
                }
                $surname->value = $request->surname;
                $surname->save();

                $nationality =  WpBpXprofileData::where("field_id", $nationality_field_id)->where("user_id", $id)->first();
                if(empty($nationality)){
                    $nationality = new WpBpXprofileData;
                    $nationality->field_id = $nationality_field_id;
                    $nationality->user_id = $id;
                }
                $nationality->value = $request->nationality;
                $nationality->save();

                $passport_no =  WpBpXprofileData::where("field_id", $passport_no_field_id)->where("user_id", $id)->first();
                if(empty($passport_no)){
                    $passport_no = new WpBpXprofileData;
                    $passport_no->field_id = $passport_no_field_id;
                    $passport_no->user_id = $id;
                }
                $passport_no->value = $request->passport_no;
                $passport_no->save();

                $passport_expiry =  WpBpXprofileData::where("field_id", $passport_expiry_field_id)->where("user_id", $id)->first();
                if(empty($passport_expiry)){
                    $passport_expiry = new WpBpXprofileData;
                    $passport_expiry->field_id = $passport_expiry_field_id;
                    $passport_expiry->user_id = $id;
                }
                $passport_expiry->value = $request->passport_expiry;
                $passport_expiry->save();

                $tax_residence =  WpBpXprofileData::where("field_id", $tax_residence_field_id)->where("user_id", $id)->first();
                if(empty($tax_residence)){
                    $tax_residence = new WpBpXprofileData;
                    $tax_residence->field_id = $tax_residence_field_id;
                    $tax_residence->user_id = $id;
                }
                $tax_residence->value = $request->tax_residence;
                $tax_residence->save();

                $tax_number =  WpBpXprofileData::where("field_id", $tax_number_field_id)->where("user_id", $id)->first();
                if(empty($tax_number)){
                    $tax_number = new WpBpXprofileData;
                    $tax_number->field_id = $tax_number_field_id;
                    $tax_number->user_id = $id;
                }
                $tax_number->value = $request->tax_number;
                $tax_number->save();

                $mobile_telephone =  WpBpXprofileData::where("field_id", $mobile_telephone_field_id)->where("user_id", $id)->first();
                if(empty($mobile_telephone)){
                    $mobile_telephone = new WpBpXprofileData;
                    $mobile_telephone->field_id = $mobile_telephone_field_id;
                    $mobile_telephone->user_id = $id;
                }
                $mobile_telephone->value = $request->mobile_telephone;
                $mobile_telephone->save();

                $work_telephone =  WpBpXprofileData::where("field_id", $work_telephone_field_id)->where("user_id", $id)->first();
                if(empty($work_telephone)){
                    $work_telephone = new WpBpXprofileData;
                    $work_telephone->field_id = $work_telephone_field_id;
                    $work_telephone->user_id = $id;
                }
                $work_telephone->value = $request->work_telephone;
                $work_telephone->save();

                $home_telephone =  WpBpXprofileData::where("field_id", $home_telephone_field_id)->where("user_id", $id)->first();
                if(empty($home_telephone)){
                    $home_telephone = new WpBpXprofileData;
                    $home_telephone->field_id = $home_telephone_field_id;
                    $home_telephone->user_id = $id;
                }
                $home_telephone->value = $request->home_telephone;
                $home_telephone->save();

                $home_address =  WpBpXprofileData::where("field_id", $home_address_field_id)->where("user_id", $id)->first();
                if(empty($home_address)){
                    $home_address = new WpBpXprofileData;
                    $home_address->field_id = $home_address_field_id;
                    $home_address->user_id = $id;
                }
                $home_address->value = $request->home_address;
                $home_address->save();

                $home_address_2 =  WpBpXprofileData::where("field_id", $home_address_2_field_id)->where("user_id", $id)->first();
                if(empty($home_address_2)){
                    $home_address_2 = new WpBpXprofileData;
                    $home_address_2->field_id = $home_address_2_field_id;
                    $home_address_2->user_id = $id;
                }
                $home_address_2->value = $request->home_address_2;
                $home_address_2->save();

                $home_address_3 =  WpBpXprofileData::where("field_id", $home_address_3_field_id)->where("user_id", $id)->first();
                if(empty($home_address_3)){
                    $home_address_3 = new WpBpXprofileData;
                    $home_address_3->field_id = $home_address_3_field_id;
                    $home_address_3->user_id = $id;
                }
                $home_address_3->value = $request->home_address_3;
                $home_address_3->save();

                $home_address_5 =  WpBpXprofileData::where("field_id", $home_address_5_field_id)->where("user_id", $id)->first();
                if(empty($home_address_5)){
                    $home_address_5 = new WpBpXprofileData;
                    $home_address_5->field_id = $home_address_5_field_id;
                    $home_address_5->user_id = $id;
                }
                $home_address_5->value = $request->home_address_5;
                $home_address_5->save();

                $home_address_6 =  WpBpXprofileData::where("field_id", $home_address_6_field_id)->where("user_id", $id)->first();
                if(empty($home_address_6)){
                    $home_address_6 = new WpBpXprofileData;
                    $home_address_6->field_id = $home_address_6_field_id;
                    $home_address_6->user_id = $id;
                }
                $home_address_6->value = $request->home_address_6;
                $home_address_6->save();

                $postal_address =  WpBpXprofileData::where("field_id", $postal_address_field_id)->where("user_id", $id)->first();
                if(empty($postal_address)){
                    $postal_address = new WpBpXprofileData;
                    $postal_address->field_id = $postal_address_field_id;
                    $postal_address->user_id = $id;
                }
                $postal_address->value = $request->postal_address;
                $postal_address->save();

                $postal_address_2 =  WpBpXprofileData::where("field_id", $postal_address_2_field_id)->where("user_id", $id)->first();
                if(empty($postal_address_2)){
                    $postal_address_2 = new WpBpXprofileData;
                    $postal_address_2->field_id = $postal_address_2_field_id;
                    $postal_address_2->user_id = $id;
                }
                $postal_address_2->value = $request->postal_address_2;
                $postal_address_2->save();

                $postal_address_3 =  WpBpXprofileData::where("field_id", $postal_address_3_field_id)->where("user_id", $id)->first();
                if(empty($postal_address_3)){
                    $postal_address_3 = new WpBpXprofileData;
                    $postal_address_3->field_id = $postal_address_3_field_id;
                    $postal_address_3->user_id = $id;
                }
                $postal_address_3->value = $request->postal_address_3;
                $postal_address_3->save();        

                $postal_address_5 =  WpBpXprofileData::where("field_id", $postal_address_5_field_id)->where("user_id", $id)->first();
                if(empty($postal_address_5)){
                    $postal_address_5 = new WpBpXprofileData;
                    $postal_address_5->field_id = $postal_address_5_field_id;
                    $postal_address_5->user_id = $id;
                }
                $postal_address_5->value = $request->postal_address_5;
                $postal_address_5->save();

                $postal_address_6 =  WpBpXprofileData::where("field_id", $postal_address_6_field_id)->where("user_id", $id)->first();
                if(empty($postal_address_6)){
                    $postal_address_6 = new WpBpXprofileData;
                    $postal_address_6->field_id = $postal_address_6_field_id;
                    $postal_address_6->user_id = $id;
                }
                $postal_address_6->value = $request->postal_address_6;
                $postal_address_6->save();

                $preferred_currency =  WpBpXprofileData::where("field_id", $preferred_currency_field_id)->where("user_id", $id)->first();
                if(empty($preferred_currency)){
                    $preferred_currency = new WpBpXprofileData;
                    $preferred_currency->field_id = $preferred_currency_field_id;
                    $preferred_currency->user_id = $id;
                }
                $preferred_currency->value = $request->preferred_currency;
                $preferred_currency->save();

                $relationship_commenced =  WpBpXprofileData::where("field_id", $relationship_commenced_field_id)->where("user_id", $id)->first();
                if(empty($relationship_commenced)){
                    $relationship_commenced = new WpBpXprofileData;
                    $relationship_commenced->field_id = $relationship_commenced_field_id;
                    $relationship_commenced->user_id = $id;
                }
                $relationship_commenced->value = $request->relationship_commenced;
                $relationship_commenced->save();

                $relationship_ended =  WpBpXprofileData::where("field_id", $relationship_ended_field_id)->where("user_id", $id)->first();
                if(empty($relationship_ended)){
                    $relationship_ended = new WpBpXprofileData;
                    $relationship_ended->field_id = $relationship_ended_field_id;
                    $relationship_ended->user_id = $id;
                }
                $relationship_ended->value = $request->relationship_ended;
                $relationship_ended->save();

                $passport_copy =  WpBpXprofileData::where("field_id", $passport_copy_field_id)->where("user_id", $id)->first();
                if(empty($passport_copy)){
                    $passport_copy = new WpBpXprofileData;
                    $passport_copy->field_id = $passport_copy_field_id;
                    $passport_copy->user_id = $id;
                }
                $passport_copy->value = $request->passport_copy;
                $passport_copy->save();

                $proof_of_address =  WpBpXprofileData::where("field_id", $proof_of_address_field_id)->where("user_id", $id)->first();
                if(empty($proof_of_address)){
                    $proof_of_address = new WpBpXprofileData;
                    $proof_of_address->field_id = $proof_of_address_field_id;
                    $proof_of_address->user_id = $id;
                }
                $proof_of_address->value = $request->proof_of_address;
                $proof_of_address->save();

                $bank_reference =  WpBpXprofileData::where("field_id", $bank_reference_field_id)->where("user_id", $id)->first();
                if(empty($bank_reference)){
                    $bank_reference = new WpBpXprofileData;
                    $bank_reference->field_id = $bank_reference_field_id;
                    $bank_reference->user_id = $id;
                }
                $bank_reference->value = $request->bank_reference;
                $bank_reference->save();

                $professional_reference =  WpBpXprofileData::where("field_id", $professional_reference_field_id)->where("user_id", $id)->first();
                if(empty($professional_reference)){
                    $professional_reference = new WpBpXprofileData;
                    $professional_reference->field_id = $professional_reference_field_id;
                    $professional_reference->user_id = $id;
                }
                $professional_reference->value = $request->professional_reference;
                $professional_reference->save();

                $notes =  WpBpXprofileData::where("field_id", $notes_field_id)->where("user_id", $id)->first();
                if(empty($notes)){
                    $notes = new WpBpXprofileData;
                    $notes->field_id = $notes_field_id;
                    $notes->user_id = $id;
                }
                $notes->value = $request->notes;
                $notes->save();
            }
            
        }


    	return redirect('officiumtutus/person');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {           
        $person = Person::find($id);

        // return $person;

        // if($person->person_role=="shareholder") {
            $companywpuser_shareholders = CompanyWpuserShareholder::where("person_code", $person->person_code)->get();

            if(count($companywpuser_shareholders) > 0) {
                foreach ($companywpuser_shareholders as $key => $companywpuser_shareholder) {
                    $companywpuser_shareholder->person_code = "";
                    $companywpuser_shareholder->person_id = NULL;
                    $companywpuser_shareholder->save();
                }
            }    

        // }

        // if($person->person_role=="director") {
            $companywpuser_directors = CompanyWpuserDirector::where("person_code", $person->person_code)->get();

            if(count($companywpuser_directors) > 0) {
                foreach ($companywpuser_directors as $key => $companywpuser_director) {
                    $companywpuser_director->person_code = "";
                    $companywpuser_director->person_id = NULL;
                    $companywpuser_director->save();
                }
            }
        // }

        // if($person->person_role=="secretary") {
            $companywpuser_secretaries = CompanyWpuserSecretary::where("person_code", $person->person_code)->get();

            if(count($companywpuser_secretaries) > 0) {
                foreach ($companywpuser_secretaries as $key => $companywpuser_secretary) {
                    $companywpuser_secretary->person_code = "";
                    $companywpuser_secretary->person_id = NULL;
                    $companywpuser_secretary->save();
                }
            }
        // }

        // if($person->person_role=="owner") {
            $companywpusers = CompanyWpuser::where("owner_person_code", $person->person_code)->get();

            if(count($companywpusers) > 0) {
                foreach ($companywpusers as $key => $companywpuser) {
                    $companywpuser->owner_person_code = "";
                    $companywpuser->save();
                }
            }
        // }

        $affectedRows = $person->delete();

        if($affectedRows)
            return redirect('officiumtutus/person');
        else
            return redirect('officiumtutus/person?error=true');
    }


}
