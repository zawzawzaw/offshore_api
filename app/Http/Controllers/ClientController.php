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

class ClientController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
    	
    	// $wpusers = Wpuser::select('ID', 'user_nicename', 'user_email', 'user_registered')->get();
        $persons = Person::get();

    	return view('client.index', ['persons'=>$persons]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('client.create');
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
        $person->third_party_company_name = $request->third_party_company_name;
        $person->third_party_company_jurisdiction = $request->third_party_company_jurisdiction;
        $person->third_party_company_reg_no = $request->third_party_company_reg_no;
        $person->title = $request->title;
        $person->first_name = $request->first_name;
        $person->surname = $request->surname;
        $person->nationality = $request->nationality;
        $person->passport_no = $request->passport_no;
        $person->passport_expiry = $request->passport_expiry;
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
        $person->account_registered = $request->account_registered;
        $person->login_ip = $request->login_ip;
        $person->relationship_commenced = $request->relationship_commenced;
        $person->relationship_ended = $request->relationship_ended;
        $person->passport_copy = $request->passport_copy;
        $person->proof_of_address = $request->proof_of_address;
        $person->bank_reference = $request->bank_reference;
        $person->professional_reference = $request->professional_reference;
        $person->notes = $request->notes;
        $person->save();

        return redirect('officiumtutus/jurisdiction');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {

    	// $client = Wpuser::find($id);

     //    $wpuserloginlog = WpuserLoginLog::where('uid', $id)->orderBy('time', 'DESC')->first();        
     //    $fields = WpBpXprofileFields::select('id', 'name')->get();

     //    foreach ($fields as $key => $field) {
     //        if($field->name == "Person code") $person_code_field_id = $field->id;
     //        if($field->name == "Person type") $person_type_field_id = $field->id;
     //        if($field->name == "Title") $title_field_id = $field->id;
     //        if($field->name == "First name") $first_name_field_id = $field->id;
     //        if($field->name == "Surname") $surname_field_id = $field->id;            
     //        if($field->name == "Nationality") $nationality_field_id = $field->id;
     //        if($field->name == "Passport no") $passport_no_field_id = $field->id;
     //        if($field->name == "Passport expiry") $passport_expiry_field_id = $field->id;
     //        if($field->name == "Tax residence") $tax_residence_field_id = $field->id;
     //        if($field->name == "Tax number") $tax_number_field_id = $field->id;
     //        if($field->name == "Mobile telephone") $mobile_telephone_field_id = $field->id;
     //        if($field->name == "Work telephone") $work_telephone_field_id = $field->id;
     //        if($field->name == "Home telephone") $home_telephone_field_id = $field->id;
     //        if($field->name == "Home address") $home_address_field_id = $field->id;
     //        if($field->name == "Home address 2") $home_address_2_field_id = $field->id;
     //        if($field->name == "Home address 3") $home_address_3_field_id = $field->id;
     //        if($field->name == "Home address 6") $home_address_6_field_id = $field->id;
     //        if($field->name == "Home address 5") $home_address_5_field_id = $field->id;
     //        if($field->name == "Postal address") $postal_address_field_id = $field->id;
     //        if($field->name == "Postal address 2") $postal_address_2_field_id = $field->id;
     //        if($field->name == "Postal address 3") $postal_address_3_field_id = $field->id;
     //        if($field->name == "Postal address 6") $postal_address_6_field_id = $field->id;
     //        if($field->name == "Postal address 5") $postal_address_5_field_id = $field->id;            
     //        if($field->name == "Preferred currency") $preferred_currency_field_id = $field->id;            
     //        if($field->name == "Relationship commenced") $relationship_commenced_field_id = $field->id;
     //        if($field->name == "Relationship ended") $relationship_ended_field_id = $field->id;
     //        if($field->name == "Passport copy") $passport_copy_field_id = $field->id;
     //        if($field->name == "Proof of address") $proof_of_address_field_id = $field->id;
     //        if($field->name == "Bank reference") $bank_reference_field_id = $field->id;
     //        if($field->name == "Professional reference") $professional_reference_field_id = $field->id;
     //        if($field->name == "Notes") $notes_field_id = $field->id;
     //    }

     //    if(isset($person_code_field_id)) $person_code = WpBpXprofileData::where("field_id", $person_code_field_id)->where("user_id", $id)->first();
     //    if(isset($person_type_field_id)) $person_type = WpBpXprofileData::where("field_id", $person_type_field_id)->where("user_id", $id)->first();
     //    if(isset($title_field_id)) $title =  WpBpXprofileData::where("field_id", $title_field_id)->where("user_id", $id)->first();
     //    if(isset($first_name_field_id)) $first_name =  WpBpXprofileData::where("field_id", $first_name_field_id)->where("user_id", $id)->first(); 
     //    if(isset($surname_field_id)) $surname =  WpBpXprofileData::where("field_id", $surname_field_id)->where("user_id", $id)->first();
     //    if(isset($nationality_field_id)) $nationality =  WpBpXprofileData::where("field_id", $nationality_field_id)->where("user_id", $id)->first();
     //    if(isset($passport_no_field_id)) $passport_no =  WpBpXprofileData::where("field_id", $passport_no_field_id)->where("user_id", $id)->first();
     //    if(isset($passport_expiry_field_id)) $passport_expiry =  WpBpXprofileData::where("field_id", $passport_expiry_field_id)->where("user_id", $id)->first();
     //    if(isset($tax_residence_field_id)) $tax_residence =  WpBpXprofileData::where("field_id", $tax_residence_field_id)->where("user_id", $id)->first();
     //    if(isset($tax_number_field_id)) $tax_number =  WpBpXprofileData::where("field_id", $tax_number_field_id)->where("user_id", $id)->first();        
     //    if(isset($mobile_telephone_field_id)) $mobile_telephone =  WpBpXprofileData::where("field_id", $mobile_telephone_field_id)->where("user_id", $id)->first();
     //    if(isset($work_telephone_field_id)) $work_telephone =  WpBpXprofileData::where("field_id", $work_telephone_field_id)->where("user_id", $id)->first();
     //    if(isset($home_telephone_field_id)) $home_telephone =  WpBpXprofileData::where("field_id", $home_telephone_field_id)->where("user_id", $id)->first();
     //    if(isset($home_address_field_id)) $home_address =  WpBpXprofileData::where("field_id", $home_address_field_id)->where("user_id", $id)->first();
     //    if(isset($home_address_2_field_id)) $home_address_2 =  WpBpXprofileData::where("field_id", $home_address_2_field_id)->where("user_id", $id)->first();
     //    if(isset($home_address_3_field_id)) $home_address_3 =  WpBpXprofileData::where("field_id", $home_address_3_field_id)->where("user_id", $id)->first();
     //    if(isset($home_address_6_field_id)) $home_address_6 =  WpBpXprofileData::where("field_id", $home_address_6_field_id)->where("user_id", $id)->first();
     //    if(isset($home_address_5_field_id)) $home_address_5 =  WpBpXprofileData::where("field_id", $home_address_5_field_id)->where("user_id", $id)->first();
     //    if(isset($postal_address_field_id)) $postal_address =  WpBpXprofileData::where("field_id", $postal_address_field_id)->where("user_id", $id)->first();
     //    if(isset($postal_address_2_field_id)) $postal_address_2 =  WpBpXprofileData::where("field_id", $postal_address_2_field_id)->where("user_id", $id)->first();
     //    if(isset($postal_address_3_field_id)) $postal_address_3 =  WpBpXprofileData::where("field_id", $postal_address_3_field_id)->where("user_id", $id)->first();
     //    if(isset($postal_address_6_field_id)) $postal_address_6 =  WpBpXprofileData::where("field_id", $postal_address_6_field_id)->where("user_id", $id)->first();
     //    if(isset($postal_address_5_field_id)) $postal_address_5 =  WpBpXprofileData::where("field_id", $postal_address_5_field_id)->where("user_id", $id)->first();
     //    if(isset($preferred_currency_field_id)) $preferred_currency =  WpBpXprofileData::where("field_id", $preferred_currency_field_id)->where("user_id", $id)->first();
     //    if(isset($relationship_commenced_field_id)) $relationship_commenced =  WpBpXprofileData::where("field_id", $relationship_commenced_field_id)->where("user_id", $id)->first();
     //    if(isset($relationship_ended_field_id)) $relationship_ended =  WpBpXprofileData::where("field_id", $relationship_ended_field_id)->where("user_id", $id)->first();
     //    if(isset($passport_copy_field_id)) $passport_copy =  WpBpXprofileData::where("field_id", $passport_copy_field_id)->where("user_id", $id)->first();
     //    if(isset($proof_of_address_field_id)) $proof_of_address =  WpBpXprofileData::where("field_id", $proof_of_address_field_id)->where("user_id", $id)->first();
     //    if(isset($bank_reference_field_id)) $bank_reference =  WpBpXprofileData::where("field_id", $bank_reference_field_id)->where("user_id", $id)->first();
     //    if(isset($professional_reference_field_id)) $professional_reference =  WpBpXprofileData::where("field_id", $professional_reference_field_id)->where("user_id", $id)->first();
     //    if(isset($notes_field_id)) $notes =  WpBpXprofileData::where("field_id", $notes_field_id)->where("user_id", $id)->first();

     //    $client->person_code = (isset($person_code)) ? $person_code->value : "";
     //    $client->person_type = (isset($person_type)) ?  $person_type->value : "";
     //    $client->title = (isset($title)) ? $title->value : "";
     //    $client->first_name = (isset($first_name)) ? $first_name->value : "";
     //    $client->surname = (isset($surname)) ? $surname->value : "";        
     //    $client->nationality = (isset($nationality)) ? $nationality->value : "";        
     //    $client->passport_no = (isset($passport_no)) ? $passport_no->value : "";        
     //    $client->passport_expiry = (isset($passport_expiry)) ? $passport_expiry->value : "";        
     //    $client->tax_residence = (isset($tax_residence)) ? $tax_residence->value : "";        
     //    $client->tax_number = (isset($tax_number)) ? $tax_number->value : "";        
     //    $client->email = (isset($client)) ? $client->user_email : "";        
     //    $client->mobile_telephone = (isset($mobile_telephone)) ? $mobile_telephone->value : "";
     //    $client->work_telephone = (isset($work_telephone)) ? $work_telephone->value : "";
     //    $client->home_telephone = (isset($home_telephone)) ? $home_telephone->value : "";
     //    $client->home_address = (isset($home_address)) ? $home_address->value : "";
     //    $client->home_address_2 = (isset($home_address_2)) ? $home_address_2->value : "";
     //    $client->home_address_3 = (isset($home_address_3)) ?  $home_address_3->value : "";
     //    $client->home_address_6 = (isset($home_address_6)) ? $home_address_6->value : "";
     //    $client->home_address_5 = (isset($home_address_5)) ? $home_address_5->value : ""; 
     //    $client->postal_address = (isset($postal_address)) ? $postal_address->value : ""; 
     //    $client->postal_address_2 = (isset($postal_address_2)) ? $postal_address_2->value : ""; 
     //    $client->postal_address_3 = (isset($postal_address_3)) ? $postal_address_3->value : ""; 
     //    $client->postal_address_6 = (isset($postal_address_6)) ? $postal_address_6->value : ""; 
     //    $client->postal_address_5 = (isset($postal_address_5)) ? $postal_address_5->value : ""; 
     //    $client->preferred_currency = (isset($preferred_currency)) ? $preferred_currency->value : ""; 
     //    $client->account_registered = (isset($client)) ? $client->user_registered : ""; 
     //    $client->login_ip = (isset($wpuserloginlog)) ? $wpuserloginlog->ip : "";
     //    $client->relationship_commenced = (isset($relationship_commenced)) ? $relationship_commenced->value : ""; 
     //    $client->relationship_ended = (isset($relationship_ended)) ? $relationship_ended->value : ""; 
     //    $client->passport_copy = (isset($passport_copy)) ? $passport_copy->value : ""; 
     //    $client->proof_of_address = (isset($proof_of_address)) ? $proof_of_address->value : ""; 
     //    $client->bank_reference = (isset($bank_reference)) ? $bank_reference->value : ""; 
     //    $client->professional_reference = (isset($professional_reference)) ? $professional_reference->value : ""; 
     //    $client->notes = (isset($notes)) ? $notes->value : "";

        $person = Person::find($id);

    	return view('client.edit', ['person'=>$person]);

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
        return $request->all();

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
        $person->passport_expiry = $request->passport_expiry;        
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
        $person->account_registered = $request->account_registered;
        $person->login_ip = $request->login_ip;
        $person->relationship_commenced = $request->relationship_commenced; 
        $person->relationship_ended = $request->relationship_ended; 
        $person->passport_copy = $request->passport_copy; 
        $person->proof_of_address = $request->proof_of_address; 
        $person->bank_reference = $request->bank_reference; 
        $person->professional_reference = $request->professional_reference; 
        $person->notes = $request->notes;

        if($request->person_role=="shareholder") {
            $companywpuser_shareholders = CompanyWpuserShareholder::where('person_code', $request->person_code)->get();
            $companywpuser_shareholder->type = $request->person_type; 
            $companywpuser_shareholder->name = $request->first_name . " " . $request->surname;
            $companywpuser_shareholder->address = $request->home_address;
            $companywpuser_shareholder->address_2 = $request->home_address_3;
            $companywpuser_shareholder->address_4 = $request->home_address_6;
            $companywpuser_shareholder->telephone = $request->mobile_telephone;
            $companywpuser_shareholder->passport = $request->passport_copy;
            $companywpuser_shareholder->bill = $request->input('shareholder_'.$no.'_bill');
            $companywpuser_shareholder->save();
        }


    	// return redirect('admin/client');

    }


}
