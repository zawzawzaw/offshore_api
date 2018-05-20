@extends('layouts.master')

@section('content')	
	<style>
		.error {
			color: red;
		}
	</style>
	<div class="container">
		<div class="row">
			<div class="col-md-9">				
				<div class="space50"></div>
				<h1>Process company formation order</h1>				
				<a href="{{ route('officiumtutus.registeredcompany.index') }}"><button class="custom-submit-class">Back to pending orders</button></a>

				{{ Form::open([ 'route' => ['officiumtutus.registeredcompany.update', $company->id ], 'method' => 'put', 'id' => 'edit_registered_company' ]) }}	
					<div class="space50"></div>
					<div class="labels">
						<div class="row">
							<div class="col-md-4"><p>Company status</p></div>
							<div class="col-md-8">
								<?php 
								if($companywpuser->status == 1)
									$company_status = "Pending"; 
								elseif($companywpuser->status == 2)
									$company_status = "Approved"; 
								else
									$company_status = "Rejected"; 
								?>
								<p>{{ $company_status }}</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Company code</p></div>
							<div class="col-md-8">
								<input type="text" name="company_code" value="{{ $company->code }}">
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Company name</p></div>	
							<div class="col-md-8">
								<input type="text" name="company_name" value="{{ $company->name }}">
							</div>	
						</div>
						<div class="row">
							<div class="col-md-4"><p>Notes</p></div>	
							<div class="col-md-8">
								<textarea name="notes" id="notes" cols="60" rows="15">{{ $companywpuser->notes }}</textarea>
							</div>	
						</div>	
						<div class="row each-director">
							<div class="col-md-4">User</div>
							<div class="col-md-8">
								<fieldset>
									<legend>
										<p>
											<?php 
											$field = App\WpBpXprofileFields::where('name', 'First name')->first();
											$firstname = App\WpBpXprofileData::where('user_id', $companywpuser->wpuser_id)->where('field_id', $field->id)->first(); ?>
											{{ (count($firstname) == 0) ? "" : " ".$firstname->value }}
											<?php 
											$field = App\WpBpXprofileFields::where('name', 'Surname')->first();
											$lastname = App\WpBpXprofileData::where('user_id', $companywpuser->wpuser_id)->where('field_id', $field->id)->first(); ?>
											{{ (count($lastname) == 0) ? "" : " ".$lastname->value }}
										</p>
									</legend>
									<input type="hidden" name="wpuser_id" class="person" value="{{ $companywpuser->wpuser_id }}">
									<input type="hidden" name="companywpuser_id" class="person" value="{{ $companywpuser->id }}">
									<div class="each-input">
        						<label for="user_person_code">Person code</label>
        						<?php 
	        					$this_person = App\Person::where('person_code', $companywpuser->owner_person_code)->get(); 
	        					if(count($this_person)>0) {
	        						$first_name = $this_person[0]->first_name;
	        						$surname = $this_person[0]->surname;							        						

	        						$name = " - ".$first_name." ".$surname;							        						

	        						if(empty($first_name) && empty($surname)) {
	        							$name = " - ".$this_person[0]->third_party_company_name;
	        						}
	        					}else {
	        						$name = "";
	        					}
	        					?>			        					
        						<input type="text" id="user_person_code" value="{{ $companywpuser->owner_person_code.$name }}">	
        						<input type="hidden" name="user_person_code" value="{{ $companywpuser->owner_person_code }}" class="person">	
	        				</div>
									<div class="each-input">
	        					<button type="button" class="add-user-to-person custom-submit-class custom-submit-class-2">Add to person database</button>
	        				</div>	
								</fieldset>
								
							</div>
						</div>		
						<div class="row">
							<div class="col-md-4">Jurisdiction</div>
							<div class="col-md-8"><p>{{ $company->companytypes->jurisdiction }}</p></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Company type</p></div>
							<div class="col-md-8"><p>{{ $company->companytypes->name }}</p></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Company registration number</p></div>
							<div class="col-md-8">
								<input type="text" name="reg_no" value="{{ $companywpuser->reg_no }}">
							</div>
						</div>
						<!-- <div class="row">
							<div class="col-md-4"><p>Company tax number</p></div>
							<div class="col-md-8">
								<input type="text" name="tax_no" value="{{ $companywpuser->tax_no }}">
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>VAT registration number</p></div>
							<div class="col-md-8">
								<input type="text" name="vat_reg_no" value="{{ $companywpuser->vat_reg_no }}">
							</div>
						</div> -->
						<div class="row">
							<div class="col-md-4"><p>Incorporation Date</p></div>
							<div class="col-md-8">
								<input type="text" name="incorporation_date" id="incorporation_date" class="date-input" placeholder="dd/mm/yyyy" value="{{ (strtotime($company->incorporation_date) <= 0) ? "" : date('d/m/Y', strtotime($company->incorporation_date)) }}">
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Registered office</p></div>
							<div class="col-md-8">
								<input type="text" name="reg_office" value="{{ $companywpuser->reg_office }}">
							</div>
						</div>
				
						<div class="row">
							<div class="col-md-4"><p>Shareholders</p></div>
							<div class="col-md-8">								
	        					@if(count($company->companywpuser_shareholders) > 0)
		        					@foreach($company->companywpuser_shareholders as $key => $shareholder)
			        					<div class="row each-director">
			        						<div class="col-md-12">
			        							<fieldset>
				        							<legend>Shareholder {{ $key+1 }}</legend>	
				        							<input type="hidden" name="prefix" value="shareholder_{{ $key+1 }}" class="person">
				        							<input type="hidden" name="shareholder_{{ $key+1 }}_companywpuser_shareholder_id" value="{{ $shareholder->id }}" class="person">
				        							<input type="hidden" name="shareholder_{{ $key+1 }}_person_role" value="shareholder" class="person">
													<div class="each-input">
							        					<label for="shareholder_{{ $key+1 }}_shareholder">Nominee shareholder</label>
							        					@if($companywpuser->nominee_shareholder==1)
															<span>Yes</span>
														@else
															<span>No</span>
								        				@endif
							        				</div>
				        							<!-- <div class="each-input">
						        						<label for="shareholder_{{ $key+1 }}_type">Type</label>						        	
						        						@if($shareholder->type==1)
															<span>{{ "Individual" }}</span>
						        						@else
															<span>{{ "Company" }}</span>
						        						@endif						        				
							        				</div> -->
							        				<input type="hidden" name="shareholder_{{ $key+1 }}_type" id="shareholder_{{ $key+1 }}_type" class="person" value="{{ $shareholder->type }}">
							        				<div class="each-input">
							        					<label for="shareholder_{{ $key+1 }}_shareholder">Shareholder</label>
							        					<?php 
							        					$this_person = App\Person::where('person_code', $shareholder->shareholder)->get(); 
							        					if(count($this_person)>0) {
							        						$first_name = $this_person[0]->first_name;
							        						$surname = $this_person[0]->surname;							        						

							        						$name = " - ".$first_name." ".$surname;							        						

							        						if(empty($first_name) && empty($surname)) {
							        							$name = " - ".$this_person[0]->third_party_company_name;
							        						}
							        					}else {
							        						$name = "";
							        					}
							        					?>
							        					<input type="text" class="nominee_shareholder" value="{{ $shareholder->shareholder.$name }}">
							        					<input type="hidden" name="shareholder_{{ $key+1 }}_shareholder" value="{{ $shareholder->shareholder }}">
							        				</div>
							        				<div class="each-input">
						        						<label for="shareholder_{{ $key+1 }}_name">Beneficial owner</label>
						        						<input type="text" name="shareholder_{{ $key+1 }}_name" class="person" value="{{ $shareholder->name }}">
							        				</div>							        	
				        							<div class="each-input">
				        								<label for="shareholder_{{ $key+1 }}_person_code">Person code</label>
				        								<?php 
							        					$this_person = App\Person::where('person_code', $shareholder->person_code)->get(); 
							        					if(count($this_person)>0) {
							        						$first_name = $this_person[0]->first_name;
							        						$surname = $this_person[0]->surname;							        						

							        						$name = " - ".$first_name." ".$surname;							        						

							        						if(empty($first_name) && empty($surname)) {
							        							$name = " - ".$this_person[0]->third_party_company_name;
							        						}
							        					}else {
							        						$name = "";
							        					}
							        					?>
				        								<input type="text" data-field-name="shareholder_{{ $key+1 }}_person_code" class="shareholder" value="{{ $shareholder->person_code.$name }}" >
				        								<input type="hidden" name="shareholder_{{ $key+1 }}_person_code" class="person" value="{{ $shareholder->person_code }}" >
				        							</div>
				        							<div class="each-input">
							        					<button type="button" class="add-to-person custom-submit-class custom-submit-class-2">Add to person database</button>
							        				</div>						        					
							        				<div class="each-input">
							        					<label for="shareholder_{{ $key+1 }}_share_amount">Number of shares</label>
							        					<input type="text" class="person" name="shareholder_{{ $key+1 }}_share_amount" value="{{ $shareholder->share_amount }}">
							        				</div>				        				
							        				<div class="each-input">
							        					<label for="shareholder_{{ $key+1 }}_address">Street 1</label>
							        					<input type="text" class="person" name="shareholder_{{ $key+1 }}_address" value="{{ $shareholder->address }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="shareholder_{{ $key+1 }}_address_5">Street 2</label>
							        					<input type="text" class="person" name="shareholder_{{ $key+1 }}_address_5" value="{{ $shareholder->address_5 }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="shareholder_{{ $key+1 }}_address_2">City</label>
							        					<input type="text" class="person" name="shareholder_{{ $key+1 }}_address_2" value="{{ $shareholder->address_2 }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="shareholder_{{ $key+1 }}_address_3">Postcode</label>
							        					<input type="text" class="person" name="shareholder_{{ $key+1 }}_address_3" value="{{ $shareholder->address_3 }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="shareholder_{{ $key+1 }}_address_4">Country</label>
							        					<?php $keyplus = $key+1; $name = 'shareholder_'.$keyplus.'_address_4'; ?>
							        					{!! Form::select($name, $countryList, $shareholder->address_4, array("class"=>"person")) !!}		
							        				</div>							        				
							        				<div class="each-input">
							        					<label for="shareholder_{{ $key+1 }}_telephone">Telephone</label>
							        					<input type="text" class="person telephone" name="shareholder_{{ $key+1 }}_telephone" value="{{ $shareholder->telephone }}">
							        				</div>
							        				<div class="each-input upload-btn-container">
							        					<label for="shareholder_{{ $key+1 }}_passport">Passport</label>
							        					<input type="hidden" class="person" name="shareholder_{{ $key+1 }}_passport" value="{{ $shareholder->passport }}" />
							                            <span class="btn fileinput-button">
							                                <button class="upload-passport-btn custom-submit-class custom-submit-class-2" data-btn-text="Passport uploaded">Upload file</button>
							                                <!-- The file input field used as target for the file upload widget -->
							                                <input class="passport_upload" type="file" name="files" data-fieldname="shareholder_{{ $key+1 }}_passport" data-selector="shareholder_{{ $key+1 }}" />
							                            </span>
							                            <!-- The container for the uploaded files -->
							                            <div id="shareholder_{{ $key+1 }}_passport_files" class="files"><p>{{ $shareholder->passport }}</p></div>
							        				</div>
							        				<div class="each-input">
							        					<label for="shareholder_{{ $key+1 }}_bill">Utility Bill</label>
							        					<input type="hidden" class="person" name="shareholder_{{ $key+1 }}_bill" value="{{ $shareholder->bill }}" />
														<span class="btn fileinput-button">            
							                                <button class="upload-bill-btn custom-submit-class custom-submit-class-2" data-btn-text="Utility bill uploaded">Upload file</button>
							                                <!-- The file input field used as target for the file upload widget -->    
							                                <input class="bill_upload" type="file" name="files" data-fieldname="shareholder_{{ $key+1 }}_bill" data-selector="shareholder_{{ $key+1 }}" />
							                            </span>                
							                            <!-- The container for the uploaded files -->
							                            <div id="shareholder_{{ $key+1 }}_bill_files" class="files"><p>{{ $shareholder->bill }}</p></div>
							        				</div>
						        				</fieldset>
			        						</div>
			        					</div>	        					
		        					@endforeach
	        					@endif	        					
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<p>Directors</p>
							</div>
							<div class="col-md-8">								
	        					@if(count($company->companywpuser_directors) > 0)
		        					@foreach($company->companywpuser_directors as $key => $director)
			        					<div class="row each-director">
			        						<div class="col-md-12">
			        							<fieldset>
				        							<legend>Director {{ $key+1 }}</legend>
				        							<input type="hidden" class="person" name="prefix" value="director_{{ $key+1 }}">
				        							<input type="hidden" class="person" name="director_{{ $key+1 }}_companywpuser_director_id" value="{{ $director->id }}">
				        							<input type="hidden" class="person" name="director_{{ $key+1 }}_person_role" value="director">

				        							{{-- <div class="each-input">
						        						<label for="director_{{ $key+1 }}_type">Type</label>
						        						@if($director->type==1)
															<span>{{ "Individual" }}</span>
						        						@else
															<span>{{ "Company" }}</span>
						        						@endif						        				
							        				</div> --}}
							        				<input type="hidden" name="director_{{ $key+1 }}_type" id="director_{{ $key+1 }}_type" class="person" value="{{ $director->type }}">
							        				<div class="each-input">
							        					<label for="director_{{ $key+1 }}_name">Name</label>
							        					<input type="text" class="person" name="director_{{ $key+1 }}_name" value="{{ $director->name }}">
							        				</div>
							        				<div class="each-input">
				        								<label for="director_{{ $key+1 }}_person_code">Person code</label>
				        								<?php 
							        					$this_person = App\Person::where('person_code', $director->person_code)->get(); 
							        					if(count($this_person)>0) {
							        						$first_name = $this_person[0]->first_name;
							        						$surname = $this_person[0]->surname;							        						

							        						$name = " - ".$first_name." ".$surname;							        						

							        						if(empty($first_name) && empty($surname)) {
							        							$name = " - ".$this_person[0]->third_party_company_name;
							        						}
							        					}else {
							        						$name = "";
							        					}
							        					?>
				        								<input type="text" class="director" value="{{ $director->person_code.$name }}" >
				        								<input type="hidden" class="person" name="director_{{ $key+1 }}_person_code" value="{{ $director->person_code }}" >
				        							</div>
				        							<div class="each-input">
							        					<button type="button" class="add-to-person custom-submit-class custom-submit-class-2">Add to person database</button>
							        				</div>
							        				<div class="each-input">
							        					<label for="director_{{ $key+1 }}_address">Street 1</label>
							        					<input type="text" class="person" name="director_{{ $key+1 }}_address" value="{{ $director->address }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="director_{{ $key+1 }}_address_5">Street 2</label>
							        					<input type="text" class="person" name="director_{{ $key+1 }}_address_5" value="{{ $director->address_5 }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="director_{{ $key+1 }}_address_2">City</label>
							        					<input type="text" class="person" name="director_{{ $key+1 }}_address_2" value="{{ $director->address_2 }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="director_{{ $key+1 }}_address_3">Postcode</label>
							        					<input type="text" class="person" name="director_{{ $key+1 }}_address_3" value="{{ $director->address_3 }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="director_{{ $key+1 }}_address_4">Country</label>
							        					<?php 
							        					$keyplus = $key+1;
							        					$name = "director_".$keyplus."_address_4";
							        					?>
							        					{!! Form::select($name, $countryList, $director->address_4, array("class"=>"person")) !!}
							        				</div>
							        				<div class="each-input">
							        					<label for="director_{{ $key+1 }}_telephone">Telephone</label>
							        					<input type="text" class="person telephone" name="director_{{ $key+1 }}_telephone" value="{{ $director->telephone }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="director_{{ $key+1 }}_passport">Passport</label>
														<input type="hidden" class="person" name="director_{{ $key+1 }}_passport" value="{{ $director->passport }}" />
						                                <span class="btn fileinput-button">                            
						                                    <button class="upload-passport-btn custom-submit-class custom-submit-class-2" data-btn-text="Passport uploaded">Upload file</button>
						                                
						                                    <input class="passport_upload" type="file" name="files" data-fieldname="director_{{ $key+1 }}_passport" data-selector="director_{{ $key+1 }}" />
						                                </span>
						                
						                                <div id="director_{{ $key+1 }}_passport_files" class="files"><p>{{ $director->passport }}</p></div>
							        				</div>
							        				<div class="each-input">
							        					<label for="director_{{ $key+1 }}_bill">Utility Bill</label>
														<input type="hidden" class="person" name="director_{{ $key+1 }}_bill" value="{{ $director->bill }}" />
						                                <span class="btn fileinput-button">                            
						                                    <button class="upload-bill-btn custom-submit-class custom-submit-class-2" data-btn-text="Utility bill uploaded">Upload file</button>
						                           
						                                    <input class="bill_upload" type="file" name="files" data-fieldname="director_{{ $key+1 }}_bill" data-selector="director_{{ $key+1 }}" />
						                                </span>                
						                                <div id="director_{{ $key+1 }}_bill_files" class="files"><p>{{ $director->bill }}</p></div>	
							        				</div>							        				
						        				</fieldset>
			        						</div>
			        					</div>	        					
		        					@endforeach
	        					@elseif($companywpuser->nominee_director==1)
	        						<div class="row each-director">
		        						<div class="col-md-12">
			        						<fieldset>
			        							<legend>Director</legend>				
				        						<div class="each-input">
				        							<label for="nominee_director_person_code">Person Code</label>		
				        							<?php 
						        					$this_person = App\Person::where('person_code', $companywpuser->nominee_director_person_code)->get(); 
						        					if(count($this_person)>0) {
							        						$first_name = $this_person[0]->first_name;
							        						$surname = $this_person[0]->surname;							        						

							        						$name = " - ".$first_name." ".$surname;							        						

							        						if(empty($first_name) && empty($surname)) {
							        							$name = " - ".$this_person[0]->third_party_company_name;
							        						}
							        					}else {
							        						$name = "";
							        					}
						        					?>				        
						        					<input type="text" class="nominee_director" value="{{ $companywpuser->nominee_director_person_code.$name }}">
						        					<input type="hidden" name="nominee_director_person_code" value="{{ $companywpuser->nominee_director_person_code }}">
				        						</div>
				        					</fieldset>
        								</div>
		        					</div>
	        					@endif				
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<p>Company secretary</p>
							</div>
							<div class="col-md-8">								
	        					@if(count($company->companywpuser_secretaries) > 0)
		        					@foreach($company->companywpuser_secretaries as $key => $secretary)
												<div class="row each-director">
			        						<div class="col-md-12">
			        							<fieldset>
				        							<legend>Company secretary</legend>
													<input type="hidden" class="person" name="prefix" value="secretary_{{ $key+1 }}">
				        							<input type="hidden" class="person" name="secretary_{{ $key+1 }}_companywpuser_secretary_id" value="{{ $secretary->id }}">
				        							<input type="hidden" class="person" name="secretary_{{ $key+1 }}_person_role" value="secretary">

				        							{{-- <div class="each-input">
						        						<label for="secretary_{{ $key+1 }}_type">Type</label>
						        						@if($secretary->type==1)
															<span>{{ "Individual" }}</span>
						        						@else
															<span>{{ "Company" }}</span>
						        						@endif						        				
							        				</div> --}}
							        				<input type="hidden" name="secretary_{{ $key+1 }}_type" id="secretary_{{ $key+1 }}_type" class="person" value="{{ $secretary->type }}">
							        				<div class="each-input">
							        					<label for="secretary_{{ $key+1 }}_name">Name</label>
							        					<input type="text" class="person" name="secretary_{{ $key+1 }}_name" value="{{ $secretary->name }}">
							        				</div>
							        				<div class="each-input">
				        								<label for="secretary_{{ $key+1 }}_person_code">Person code</label>
				        								<?php 
							        					$this_person = App\Person::where('person_code', $secretary->person_code)->get(); 
							        					if(count($this_person)>0) {
							        						$first_name = $this_person[0]->first_name;
							        						$surname = $this_person[0]->surname;
							        						$third_party_company_name = $this_person[0]->third_party_company_name;

							        						if(!empty($first_name))
							        							$name = " - ".$first_name." ".$surname;
							        						else
							        							$name = $third_party_company_name;
							        					}else {
							        						$name = "";
							        					}
							        					?>
				        								<input type="text" class="secretary" value="{{ $secretary->person_code.$name }}" >
				        								<input type="hidden" class="person" name="secretary_{{ $key+1 }}_person_code" value="{{ $secretary->person_code }}" >
				        							</div>
				        							<div class="each-input">
							        					<button type="button" class="add-to-person custom-submit-class custom-submit-class-2">Add to person database</button>
							        				</div>
							        				<div class="each-input">
							        					<label for="secretary_{{ $key+1 }}_address">Street 1</label>
							        					<input type="text" class="person" name="secretary_{{ $key+1 }}_address" value="{{ $secretary->address }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="secretary_{{ $key+1 }}_address_5">Street 2</label>
							        					<input type="text" class="person" name="secretary_{{ $key+1 }}_address_5" value="{{ $secretary->address_5 }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="secretary_{{ $key+1 }}_address_2">City</label>
							        					<input type="text" class="person" name="secretary_{{ $key+1 }}_address_2" value="{{ $secretary->address_2 }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="secretary_{{ $key+1 }}_address_3">Postcode</label>
							        					<input type="text" class="person" name="secretary_{{ $key+1 }}_address_3" value="{{ $secretary->address_3 }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="secretary_{{ $key+1 }}_address_4">Country</label>
							        					<?php 
							        					$keyplus = $key+1;
							        					$name = "secretary_".$keyplus."_address_4";							        					
							        					?>
							        					{!! Form::select($name, $countryList, $secretary->address_4, array("class"=>"person")) !!}			
							        				</div>
							        				<div class="each-input">
							        					<label for="secretary_{{ $key+1 }}_telephone">Telephone</label>
							        					<input type="text" class="person telephone" name="secretary_{{ $key+1 }}_telephone" value="{{ $secretary->telephone }}">
							        				</div>
							        				<div class="each-input">
							        					<label for="secretary_{{ $key+1 }}_passport">Passport</label>
														<input type="hidden" class="person" name="secretary_{{ $key+1 }}_passport" value="{{ $secretary->passport }}" />
							                            <span class="btn fileinput-button">
							                                <button class="upload-passport-btn custom-submit-class custom-submit-class-2" data-btn-text="Passport uploaded">Upload file</button>
							                                
							                                <input class="passport_upload" type="file" name="files" data-fieldname="secretary_{{ $key+1 }}_passport" data-selector="secretary_{{ $key+1 }}" />
							                            </span>
							                            
							                            <div id="secretary_{{ $key+1 }}_passport_files" class="files"><p>{{ $secretary->passport }}</p></div>
							        				</div>
							        				<div class="each-input">
							        					<label for="secretary_{{ $key+1 }}_bill">Utility Bill</label>
							        					<input type="hidden" class="person" name="secretary_{{ $key+1 }}_bill" value="{{ $secretary->bill }}" />
						                                <span class="btn fileinput-button">                            
						                                    <button class="upload-btn upload-bill-btn custom-submit-class custom-submit-class-2" data-btn-text="Utility bill uploaded">Upload file</button>
						                                                      
						                                    <input class="bill_upload" type="file" name="files" data-fieldname="secretary_{{ $key+1 }}_bill" data-selector="secretary_{{ $key+1 }}" />
						                                </span>                
						                                
						                                <div id="secretary_{{ $key+1 }}_bill_files" class="files"><p>{{ $secretary->bill }}</p></div>
							        				</div>							        				
						        				</fieldset>
			        						</div>
			        					</div>
		        					@endforeach
		        				@elseif($companywpuser->nominee_secretary==1)
	        						<div class="row each-director">
		        						<div class="col-md-12">
			        						<fieldset>
			        							<legend>Company secretary</legend>				
				        						<div class="each-input">
				        							<label for="nominee_secretary_person_code">Person Code</label>
				        							<?php 
						        					$this_person = App\Person::where('person_code', $companywpuser->nominee_secretary_person_code)->get(); 
						        					if(count($this_person)>0) {
							        						$first_name = $this_person[0]->first_name;
							        						$surname = $this_person[0]->surname;							        						

							        						$name = " - ".$first_name." ".$surname;							        						

							        						if(empty($first_name) && empty($surname)) {
							        							$name = " - ".$this_person[0]->third_party_company_name;
							        						}
							        					}else {
							        						$name = "";
							        					}
						        					?>						        
						        					<input type="text" class="nominee_secretary" value="{{ $companywpuser->nominee_secretary_person_code.$name }}">
						        					<input type="hidden" name="nominee_secretary_person_code" value="{{ $companywpuser->nominee_secretary_person_code }}">
				        						</div>
				        					</fieldset>
        								</div>
		        					</div>
	        					@endif
							</div>
						</div>
						@if(count($servicescountries) > 1)								
						<div class="row">
							<div class="col-md-4">
								<p>Services</p>
							</div>
							<div class="col-md-8">
								<table class="table table-striped">
		                    		@foreach($servicescountries as $servicecountry)        	
	                    				<tr>	                    					
	                    					@if($servicecountry->service_name!=="Registered office annual fee (compulsory)")
		                    					<td>{{ $servicecountry->service_name }}</td>
		                    					<td>{{ $servicecountry->country_name }}</td>
		                    					<td>{{ ($servicecountry->pivot->credit_card_count==0) ? "" : $servicecountry->pivot->credit_card_count }}</td>
	                    					@endif
	                    				</tr>
		                    		@endforeach
	                    		</table>
							</div>
						</div>	
						@endif
						@if(count($informationservices) > 0)		
						<div class="row">
							<div class="col-md-4">
								<p>Infomation services</p>
							</div>
							<div class="col-md-8">
								<table class="table table-striped">
		                    		@foreach($informationservices as $informationservice)	
		                    			<tr>
		                    				<td>{{ $informationservice->name }}</td>
		                    			</tr>
		                    		@endforeach
	                    		</table>
							</div>
						</div>
						@endif
						<!-- <div class="row">
							<div class="col-md-4"><p>Date of next accounts</p></div>	
							<div class="col-md-8"><input type="text" name="date_of_next_accounts" id="date_of_next_accounts" value="{{ (strtotime($companywpuser->date_of_next_accounts) <= 0) ? $companywpuser->date_of_next_accounts : date('d M Y', strtotime($companywpuser->date_of_next_accounts)) }}"></div>			
						</div>
						<div class="row">
							<div class="col-md-4"><p>Date of last accounts</p></div>	
							<div class="col-md-8"><input type="text" name="date_of_last_accounts" id="date_of_last_accounts" value="{{ (strtotime($companywpuser->date_of_last_accounts) <= 0) ? $companywpuser->date_of_last_accounts : date('d M Y', strtotime($companywpuser->date_of_last_accounts)) }}"></div>			
						</div>						
						<div class="row">
							<div class="col-md-4"><p>Accounts completion deadline</p></div>	
							<div class="col-md-8"><input type="text" name="accounts_completion_deadline" id="accounts_completion_deadline" value="{{ (strtotime($companywpuser->accounts_completion_deadline) <= 0) ? $companywpuser->accounts_completion_deadline : date('d M Y', strtotime($companywpuser->accounts_completion_deadline)) }}"></div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p>Date of last VAT return</p></div>	
							<div class="col-md-8"><input type="text" name="date_of_last_vat_return" id="date_of_last_vat_return" value="{{ (strtotime($companywpuser->date_of_last_vat_return) <= 0) ? $companywpuser->date_of_last_vat_return : date('d M Y', strtotime($companywpuser->date_of_last_vat_return)) }}"></div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p>Date of next VAT return</p></div>	
							<div class="col-md-8"><input type="text" name="date_of_next_vat_return" id="date_of_next_vat_return" value="{{ (strtotime($companywpuser->date_of_next_vat_return) <= 0) ? $companywpuser->date_of_next_vat_return : date('d M Y', strtotime($companywpuser->date_of_next_vat_return)) }}"></div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p>VAT return deadline</p></div>	
							<div class="col-md-8"><input type="text" name="vat_return_deadline" id="vat_return_deadline" value="{{ (strtotime($companywpuser->vat_return_deadline) <= 0) ? $companywpuser->vat_return_deadline : date('d M Y', strtotime($companywpuser->vat_return_deadline)) }}"></div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p>Next AGM due by</p></div>	
							<div class="col-md-8"><input type="text" name="next_agm_due_by" id="next_agm_due_by" value="{{ (strtotime($companywpuser->next_agm_due_by) <= 0) ? $companywpuser->next_agm_due_by : date('d M Y', strtotime($companywpuser->next_agm_due_by)) }}"></div>						
						</div> -->
						<div class="row">
							<div class="col-md-4"><p>Next domiciliation renewal</p></div>	
							<div class="col-md-8"><input type="text" name="next_domiciliation_renewal" id="next_domiciliation_renewal" class="date-input" placeholder="dd/mm/yyyy" value="{{ (strtotime($companywpuser->next_domiciliation_renewal) <= 0) ? "" : date('d/m/Y', strtotime($companywpuser->next_domiciliation_renewal)) }}"></div>			
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text-2">Incorporation certificate</p></div><!--
							--><div class="col-md-4">
								<input type="hidden" name="incorporation_certificate" value="{{ $companywpuser->incorporation_certificate }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="File uploaded">@if($companywpuser->incorporation_certificate) {{ "File uploaded" }} @else {{ "Upload file" }} @endif</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="incorporation_certificate" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="incorporation_certificate_files" class="pdf_files files"><p>{{ $companywpuser->incorporation_certificate }}</p></div>								
							</div>						
						</div>
						{{-- <div class="row">
							<div class="col-md-4"><p class="align-text-2">Incumbency certificate</p></div><!--
							--><div class="col-md-4">
								<input type="hidden" name="incumbency_certificate" value="{{ $companywpuser->incumbency_certificate }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Certificate uploaded">Upload file</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="incumbency_certificate" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="incumbency_certificate_files" class="pdf_files files"><p>{{ $companywpuser->incumbency_certificate }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text-2" class="align-text">Company extract</p></div><!--
							--><div class="col-md-4">
								<input type="hidden" name="company_extract" value="{{ $companywpuser->company_extract }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Extract uploaded">Upload file</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="company_extract" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="company_extract_files" class="pdf_files files"><p>{{ $companywpuser->company_extract }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text-2">Last financial statements</p></div><!--
							--><div class="col-md-4">
								<input type="hidden" name="last_financial_statements" value="{{ $companywpuser->last_financial_statements }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Statement uploaded">Upload file</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="last_financial_statements" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="last_financial_statements_files" class="pdf_files files"><p>{{ $companywpuser->last_financial_statements }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text">Documents 5</p></div><!--
							--><div class="col-md-4">
								<input type="text" name="other_documents_1_title" placeholder="Document title" value="{{ $companywpuser->other_documents_1_title }}">
								<input type="hidden" name="other_documents_1" value="{{ $companywpuser->other_documents_1 }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Document uploaded">Upload file</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="other_documents_1" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="other_documents_1_files" class="pdf_files files"><p>{{ $companywpuser->other_documents_1 }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text">Documents 6</p></div><!--
							--><div class="col-md-4">
								<input type="text" name="other_documents_2_title" placeholder="Document title" value="{{ $companywpuser->other_documents_2_title }}">
								<input type="hidden" name="other_documents_2" value="{{ $companywpuser->other_documents_2 }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Document uploaded">Upload file</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="other_documents_2" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="other_documents_2_files" class="pdf_files files"><p>{{ $companywpuser->other_documents_2 }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text">Documents 7</p></div><!--
							--><div class="col-md-4">
								<input type="text" name="other_documents_3_title" placeholder="Document title" value="{{ $companywpuser->other_documents_3_title }}">
								<input type="hidden" name="other_documents_3" value="{{ $companywpuser->other_documents_3 }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Document uploaded">Upload file</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="other_documents_3" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="other_documents_3_files" class="pdf_files files"><p>{{ $companywpuser->other_documents_3 }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text">Documents 8</p></div><!--
							--><div class="col-md-4">
								<input type="text" name="other_documents_4_title" placeholder="Document title" value="{{ $companywpuser->other_documents_4_title }}">
								<input type="hidden" name="other_documents_4" value="{{ $companywpuser->other_documents_4 }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Document uploaded">Upload file</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="other_documents_4" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="other_documents_4_files" class="pdf_files files"><p>{{ $companywpuser->other_documents_4 }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text">Documents 9</p></div><!--
							--><div class="col-md-4">
								<input type="text" name="other_documents_5_title" placeholder="Document title" value="{{ $companywpuser->other_documents_5_title }}">
								<input type="hidden" name="other_documents_5" value="{{ $companywpuser->other_documents_5 }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Document uploaded">Upload file</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="other_documents_5" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="other_documents_5_files" class="pdf_files files"><p>{{ $companywpuser->other_documents_5 }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text">Documents 10</p></div><!--
							--><div class="col-md-4">
								<input type="text" name="other_documents_6_title" placeholder="Document title" value="{{ $companywpuser->other_documents_6_title }}">
								<input type="hidden" name="other_documents_6" value="{{ $companywpuser->other_documents_6 }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Document uploaded">Upload file</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="other_documents_6" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="other_documents_6_files" class="pdf_files files"><p>{{ $companywpuser->other_documents_6 }}</p></div>								
							</div>						
						</div> --}}
						@if(!empty($companywpuser->actual_payment_response))
							<?php	
								$time_stamp = json_decode($companywpuser->actual_payment_response)->completion_time_stamp;	
							?>
							<div class="space20"></div>
							<p class="payment-status">Payment collected {{ date("d/m/Y", strtotime($time_stamp)) }}</p>
							<div class="space20"></div>					
						@elseif(empty($companywpuser->parent_transaction_id))
							<div class="space20"></div>
							<p class="payment-status">Payment method: Bank transfer</p>
							<div class="space20"></div>
						@elseif(!empty($companywpuser->parent_transaction_id))
							<div class="space20"></div>							
							<p class="payment-status">Payment method: Credit card (Pending)</p>														
							<div class="space20"></div>
						@endif


						<input type="submit" name="submit" value="Save" class="save custom-submit-class">
						@if(!empty($companywpuser->parent_transaction_id) && empty($companywpuser->actual_payment_response))
						<input type="submit" name="submit" value="Collect payment" class="collect custom-submit-class">
						@endif
						<input type="submit" name="submit" value="Order completed" class="approve custom-submit-class">
						<input type="submit" name="submit" value="Reject order" class="reject custom-submit-class">
						<div class="loading-icon"></div>
					</div>					
				{{ Form::close() }}
			</div>
		</div>
	</div>
	<div class="space100"></div>
	<div id="reject-popup" style="display:none; cursor: default;">		
		<div class="row" style="margin-bottom: 20px;">
			<div class="col-md-4">
				<label for="">Amount to charge</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="payment_amount" id="payment_amount" style="width: 100%;">
			</div>
		</div>
		<a href="#" class="reject-with-charges custom-submit-class">Reject with charges</a>
		<a href="#" class="reject-without-charges custom-submit-class">Reject without charges</a>
		<div class="loading-icon"></div>
	</div>
	<script src="https://api.wirecard.com/engine/hpp/paymentPageLoader.js" type="text/javascript"></script>
	<script>

		///////////
        /// FILE UPLOAD
        ///////////

        function initFileUpload($selector) {
            $selector.each(function(i, obj) {
                var $button = $(obj).prev("button");                    
                var selector = $(obj).attr("data-fieldname");

                var url = "{{ url('api/uploadfiles') }}";
                $(obj).fileupload({
                    url: url,
                    dataType: "json",
                    formData: { "user_name" : "{{ $company->wpusers[0]->user_login }}" },
                    done: function (e, data) {

                        var shortText = jQuery.trim(data.result.file.org_name).substring(0, 30).trim(this);

                        $("input[name="+selector+"]").val(data.result.file.name);
                        $("#"+selector+"_files").html("");
                        $("<p/>").text(shortText).appendTo("#"+selector+"_files");
                        $("#"+selector+"_files").parent().find("label.error").hide();

                        $button.text($button.data("btn-text"));

                    }
                }).prop("disabled", !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : "disabled"); 

            });                

        }

		initFileUpload($(".passport_upload"));
        initFileUpload($(".bill_upload"));
        initFileUpload($(".pdf_upload"));

        $(".passport_upload").each(function(i, obj){
            var selector = $(obj).data("selector");
            var $this = $(this);                    

            if($("#"+selector+"_type").val()==2) {
                $this.prev("button").text("Upload file").data("btn-text", "Incorporation certificate uploaded");
                $this.parent().parent().find("label").text("Incorporation certificate");
            }
        });

        $(".bill_upload").each(function(i, obj){
            var selector = $(obj).data("selector");
            var $this = $(this);                    

            if($("#"+selector+"_type").val()==2) {
                $this.prev("button").text("Upload file").data("btn-text", "Memo & articles uploaded");
                $this.parent().parent().find("label").text("Memo and articles");
            }
        });

        $(".upload-passport-btn").on("click", function(e){
            e.preventDefault();
        });

        $(".upload-bill-btn").on("click", function(e){
            e.preventDefault();
        });

        $(".upload-pdf-btn").on("click", function(e){
            e.preventDefault();
        });

        // $('#incorporation_date').datepicker({ dateFormat: 'dd M yy' });
        // $('#date_of_next_accounts').datepicker({ dateFormat: 'dd M yy' });
        // $('#date_of_last_accounts').datepicker({ dateFormat: 'dd M yy' });
        // $('#accounts_completion_deadline').datepicker({ dateFormat: 'dd M yy' });
        // $('#date_of_last_vat_return').datepicker({ dateFormat: 'dd M yy' });
        // $('#date_of_next_vat_return').datepicker({ dateFormat: 'dd M yy' });
        // $('#vat_return_deadline').datepicker({ dateFormat: 'dd M yy' });
        // $('#next_agm_due_by').datepicker({ dateFormat: 'dd M yy' });
        // $('#next_domiciliation_renewal').datepicker({ dateFormat: 'dd M yy' });

        $.fn.serializeObject = function()
		{
		    var o = {};
		    var a = this.serializeArray();
		    $.each(a, function() {
		        if (o[this.name] !== undefined) {
		            if (!o[this.name].push) {
		                o[this.name] = [o[this.name]];
		            }
		            o[this.name].push(this.value || '');
		        } else {
		            o[this.name] = this.value || '';
		        }
		    });
		    return o;
		};

		//////////
        /// AJAX REQUEST
        //////////

        function makeRequest(Data, URL, Method) {

            var request = $.ajax({
                url: URL,
                type: Method,
                data: Data,
                success: function(response) {
                    // if success remove current item
                    // console.log(response);
                },
                error: function( error ){
                    // Log any error.
                    console.log("ERROR:", error);
                }
            });

            return request;
        };

        $(".add-to-person").on("click", function(e){
        	e.preventDefault();
        	var $this = $(this);
        	var $inputs = $(this).parent().parent('fieldset').find('.person');

        	data = $inputs.serializeObject();

        	var missing_fields = [];

        	$.each(data, function(i, val) {        		
        		if(val=="" && i.indexOf('passport') === -1 && i.indexOf('bill') === -1 && i.indexOf('address_5') === -1) {
        			missing_fields = i;
        			var field = $("input[name="+i+"]").prev("label").text();
        			$("input[name="+i+"]").attr("placeholder", field+" is required.").addClass("error");	
        		}        		
        	});

        	console.log(data);
        	// console.log(missing_fields);

        	if(missing_fields.length <= 0) {
        		var response = makeRequest(data, "{{ url('api/addtopersondb') }}", "POST");

	        	response.done(function(dataResponse, textStatus, jqXHR){                    
	                if(jqXHR.status==200) {
	                	if(dataResponse.message=="Success") {
	                		$this.after("<span style='padding-left:5px;'>Person added</span>");
	                	}
	                }
	            });
        	}
        });

        $(".add-user-to-person").on("click", function(e){
        	e.preventDefault();
        	var $this = $(this);    
        	var $inputs = $(this).parent().parent('fieldset').find('.person');        	

        	var missing_fields = [];    	

        	if($("#user_person_code").val()=="") {
        		$("#user_person_code").attr("placeholder", "Person code is required.").addClass("error");
        		missing_fields = 'user_person_code';
        	}

        	if(missing_fields.length <= 0) {

        		data = $inputs.serializeObject();

        		var response = makeRequest(data, "{{ url('api/addusertopersondb') }}", "POST");

	        	response.done(function(dataResponse, textStatus, jqXHR){                    
	                if(jqXHR.status==200) {
	                	if(dataResponse.message=="Success") {
	                		$this.after("<span style='padding-left:5px;'>Person added</span>");
	                	}
	                }
	            });
        	}
        });

        var persons = [];

        <?php
        foreach ($person as $key => $value):
        	$name = (!empty($value->first_name)) ? $value->first_name . " " . $value->surname : $value->third_party_company_name;
        ?>
        	persons.push('<?php echo $value->person_code." - ".$name; ?>');
        <?php
        endforeach;        
		?>

		$(".add-user-to-person").hide();
		$( "#user_person_code" ).autocomplete({
			source: persons,
			select: function (event, ui) {
			    var label = ui.item.label;
			    var value = ui.item.value;
			   	
			   	var res = value.split("-");			   	
			  	$(this).next("input").val(res[0].trim());

			  	// showHideAddUserToPerson($(".add-user-to-person"), value);			  	
			  	$( "#user_person_code" ).parent().next('.each-input').find(".add-user-to-person").hide();
			}
		});

		function showHideAddUserToPerson($selector, inputValue) {
			if(jQuery.inArray(inputValue, persons) == -1 && inputValue!= "") {
				$selector.parent().next('.each-input').find(".add-user-to-person").show();
				$selector.next("input").val(inputValue);
			}else {
				$selector.parent().next('.each-input').find(".add-user-to-person").hide();
			}
		}

		$("#user_person_code").on("change keyup paste", function(e){
			var inputValue = $(this).val();

			console.log(persons)
			console.log(inputValue)

			showHideAddUserToPerson($(this), inputValue);

		});

		function autoCompleteIndividuals($selector) {
			$selector.autocomplete({
				source: persons,
				select: function (event, ui) {
				    var label = ui.item.label;
				    var value = ui.item.value;				   				   	

				   	var res = value.split("-");
				  	$(this).next("input").val(res[0].trim());

				  	$(this).parent().next('.each-input').find(".add-to-person").hide();
				}
			});
		}

		autoCompleteIndividuals($( ".shareholder" ));
		autoCompleteIndividuals($( ".director" ));
		autoCompleteIndividuals($( ".secretary" ));

		$(".add-to-person").hide();

		function showHideAddToPerson($selector, inputValue) {
			
			if(jQuery.inArray(inputValue, persons) == -1 && inputValue!= "") {
				$selector.parent().next('.each-input').find(".add-to-person").show();				
			}else {
				$selector.parent().next('.each-input').find(".add-to-person").hide();
			}

			$selector.next("input").val(inputValue);
			
		}

		function showHideButtonAndUpdateInput($selector) {
			$selector.on("change keyup paste", function(e){
				var inputValue = $(this).val();

				console.log(inputValue);

				showHideAddToPerson($(this), inputValue)
			});
		}
		
		showHideButtonAndUpdateInput($(".shareholder"));
		showHideButtonAndUpdateInput($(".director"));
		showHideButtonAndUpdateInput($(".secretary"));

		function autoCompleteNominee($selector) {
			$selector.autocomplete({
		      	source: function( request, response ) {
			        $.ajax({
			          url: "{{ url('api/getperson') }}",
			          success: function( data ) {		 			
			          	// var update_to_date_persons = [];
			          	// if(data.length){		          		
			          	// 	$.each(data, function(i, v) {
			          	// 		update_to_date_persons.push(v.person_code+" ("+v.first_name+" "+v.surname+")");
			          	// 	});
			          	// }

			          	var data = $.map(data, function(v, i){
			          		if(v.first_name!=="")
			          			return (v.person_code+" - "+v.first_name+" "+v.surname);
			          		else
			          			return (v.person_code+" - "+v.third_party_company_name);
			          	});

			            // Handle 'no match' indicated by [ "" ] response
			            // response( data.length === 1 && data[ 0 ].length === 0 ? [] : data );

			            response($.ui.autocomplete.filter(data, request.term));
			          }
			        });
		      	},
		      	change: function (event, ui) {
	                if(!ui.item){
	                    //http://api.jqueryui.com/autocomplete/#event-change -
	                    // The item selected from the menu, if any. Otherwise the property is null
	                    //so clear the item for force selection
	                    $(this).val("");
	                    $(this).next("input").val("");
	                }

	            },
	            select: function (event, ui) {
				    var label = ui.item.label;
				    var value = ui.item.value;
				   	
				   	var res = value.split("-");
				  	$(this).next("input").val(res[0].trim());
				}
		    });
		}

    autoCompleteNominee($( ".nominee_shareholder" ));
    autoCompleteNominee($( ".nominee_director" ));
    autoCompleteNominee($( ".nominee_secretary" ));	 

    ///////////
    /// PHONE INPUT
    ///////////

    function initInputTel($selector) {
        $selector.intlTelInput({
            utilsScript: "{{ url('/js') }}/plugins/utils.js",
            nationalMode: false,
            preferredCountries: [],
            autoPlaceholder: false,
            formatOnInit: false,
            excludeCountries: ["mm", "ye", "sy", "sd", "so", "sa", "pk", "kp", "ng", "ly", "lr", "lv", "la", "iq", "ir", "gh", "er", "cu", "cg", "kh", "af"]
        });

        // $selector.intlTelInput("setNumber", $selector.val());
        
        // $selector.intlTelInput("setCountry", "sg");
    }

    initInputTel($(".telephone")); 

    $(document).ready(function(){
    	$(".date-input").inputmask("d/m/y", 
    		{ 
    			"placeholder": "dd/mm/yyyy",
    			showMaskOnHover: false,
					showMaskOnFocus: false,
					onincomplete: function(){
            $(this).val('');
          }
    		}
    	);
    });

    function processSucceededResult(result) {
    	if(result.transaction_type=="capture-authorization" && result.transaction_state=="success") {

		    var form = $("#edit_registered_company"),
		    		tempElement2 = $("<input type='hidden'/>");

		    tempElement2
		    		.attr("name", "actual_payment_response")
		    		.val(JSON.stringify(result))
		    		.appendTo(form);

		    $(".save").trigger("click");
         
      }
    }	

    function processRejectSucceededResult(result) {
    	if(result.transaction_type=="capture-authorization" && result.transaction_state=="success") {
         
    		var self= $(".reject"),
		        form = $("#edit_registered_company"),
		        tempElement = $("<input type='hidden'/>"),
		        tempElement2 = $("<input type='hidden'/>");

		    tempElement
		        .attr("name", "action_type")//self.attr("name")
		        .val(self.val())
		        .appendTo(form);

		    tempElement2
		    		.attr("name", "actual_payment_response")
		    		.val(JSON.stringify(result))
		    		.appendTo(form);

		    $("input[name=submit]").remove(); // bcaz js not submitting form with three submit button

		    console.log(result);
		    console.log(form);
		    form.submit();

		    // tempElement.remove();
		    // tempElement2.remove();
         
      }
    }	

    function processErrorResult(errors) {
    	console.log(errors);
    	alert(errors.status_description_1);
    }

    @if(!empty($companywpuser->parent_transaction_id))
    	<?php
    	$request_time_stamp = date("YmdHis");
	    $request_id = $companywpuser->wpuser_id.uniqid();
	    $merchant_account_id = 'b79ada18-a107-4442-b5ba-466ca500ed30';//test'9105bb4f-ae68-4768-9c3b-3eda968f57ea';//live
	    $transaction_type = 'capture-authorization';
	    $requested_amount = $companywpuser->amount;
	    $reject_requested_amount = '100';
	    $requested_amount_currency = $companywpuser->currency;
	    $secretkey = '59c6176a-6e79-4afc-b880-18e3763af03e';//test'd1efed51-4cb9-46a5-ba7b-0fdc87a66544';//live

	    $signature = $request_time_stamp . $request_id . $merchant_account_id . $transaction_type . $requested_amount . $requested_amount_currency . $secretkey;

	    $reject_signature = $request_time_stamp . $request_id . $merchant_account_id . $transaction_type . $reject_requested_amount . $requested_amount_currency . $secretkey;

	    $request_signature = hash('sha256', $signature);
	    $reject_request_signature = hash('sha256', $reject_signature);
    	?>

	    // $(".approve").on("click", function(e){
	    // 	e.preventDefault();	    		    	

	    	// var company_code_val = $("input[name=company_code]").val();

	    	// if(company_code_val=="Pending" || company_code_val=="" || /^[A-Z]{2}[0-9]{4}$/.test(company_code_val) === false) {
	    	// 	alert("Invalid company code.");
	    	// 	$("input[name=company_code]").focus();
	    	// }else {
	    	// 	$(".loading-icon").addClass('active');
	    	// 	$(this).prop('disabled', true);

	    	// 	var self= $(".approve"),
		    //     form = $("#edit_registered_company"),
		    //     tempElement = $("<input type='hidden'/>");		        

			   //  tempElement
			   //      .attr("name", "action_type")//self.attr("name")
			   //      .val(self.val())
			   //      .appendTo(form);
			    
			   //  $("input[name=submit]").remove(); // bcaz js not submitting form with three submit button
			    
			   //  console.log(form);
			   //  form.submit();

			   //  tempElement.remove();			    
	    	// }	    	
	    	
	    // });

	    $(".collect").on("click", function(e){
	    	e.preventDefault();

	    	$(".loading-icon").addClass('active');
    		$(this).prop('disabled', true);

    		var requestData = {
				  "request_id" : "{{ $request_id }}",
				  "request_time_stamp" : "{{ $request_time_stamp }}",
				  "merchant_account_id" : "{{ $merchant_account_id }}",
				  "transaction_type" : "capture-authorization",
				  "requested_amount" : "{{ $requested_amount }}",
				  "requested_amount_currency" : "{{ $requested_amount_currency }}",
				  "locale": "en",	          
				  "request_signature" : "{{ $request_signature }}",
				  "payment_method" : "creditcard",				  
				  "parent_transaction_id" : "{{ $companywpuser->parent_transaction_id }}"
				};
				WirecardPaymentPage.seamlessPay({
				  requestData : requestData,
				  onSuccess : processSucceededResult,
				  onError : processErrorResult
				});

	    });

	    $(".reject").on("click", function(e){
	    	e.preventDefault();	   	    	

				$.blockUI({ 
      		message: $("#reject-popup"),
      		css: {
						padding: "30px",
						margin: 0,
						border: '0px',
						width: '45%',
						left: '26%',
						backgroundColor: '#fff'					
      		},
    			onOverlayClick: $.unblockUI
      	});

	    });

	    $(".reject-with-charges").on("click", function(e){
	    	e.preventDefault();

	    	$("#reject-popup").find(".loading-icon").addClass('active');
	    	$(this).prop('disabled', true);

	    	var data = {};

        data.request_id = "{{ $request_id }}";
        data.requested_amount = $("#reject-popup").find("#payment_amount").val();
        data.currency_code = "{{ $requested_amount_currency }}";
        data.request_time_stamp = "{{ $request_time_stamp }}";
        data.transaction_type = "capture-authorization";

        var response = makeRequest(data, "{{ url('api/preparerequestdata') }}", "POST");

        response.done(function(data, textStatus, jqXHR){                    
            if(jqXHR.status==200) {
            	 	var requestData = {
								  "request_id" : "{{ $request_id }}",
								  "request_time_stamp" : "{{ $request_time_stamp }}",
								  "merchant_account_id" : "{{ $merchant_account_id }}",
								  "transaction_type" : "capture-authorization",
								  "requested_amount" : $("#reject-popup").find("#payment_amount").val(),
								  "requested_amount_currency" : "{{ $requested_amount_currency }}",
								  "locale": "en",          
								  "request_signature" : data.signature,
								  "payment_method" : "creditcard",				  
								  "parent_transaction_id" : "{{ $companywpuser->parent_transaction_id }}"
								};
								WirecardPaymentPage.seamlessPay({
								  requestData : requestData,
								  onSuccess : processRejectSucceededResult,
								  onError : processErrorResult
								});
        		}
      	});
	    });

	    $(".reject-without-charges").on("click", function(e){
	    	e.preventDefault();

	    	var self= $(".reject"),
		        form = $("#edit_registered_company"),
		        tempElement = $("<input type='hidden'/>");

		    tempElement.attr("name", "action_type").val(self.val()).appendTo(form);

	      $("input[name=submit]").remove();

	    	form.submit();
	    });

	  @else
	  // $(".approve").on("click", function(e){
   //  	e.preventDefault();

    	// var company_code_val = $("input[name=company_code]").val();

    	// if(company_code_val=="Pending" || company_code_val=="" || /^[A-Z]{2}[0-9]{4}$/.test(company_code_val) === false) {
    	// 	alert("Invalid company code.");
    	// 	$("input[name=company_code]").focus();
    	// }else {
    	// 	var self= $(".approve"),
		   //      form = $("#edit_registered_company"),
		   //      tempElement = $("<input type='hidden'/>");

		   //  tempElement.attr("name", "action_type").val(self.val()).appendTo(form);

	    //   $("input[name=submit]").remove();

	    // 	form.submit();
    	// }

    // });
    @endif  

    var form = $("#edit_registered_company");
  	form.validate({
  		ignore: "",
  		onkeyup: false, 
    	onfocusout: false,
    	onclick: false,
			rules : {
				'company_code': "required"				
			},
			errorPlacement: function(error, element) {    
      	if(element.attr("name")!=="company_code")                   
        	$(element).prev().attr("placeholder", error.text()).addClass("error");
      	else
      		$(element).attr("placeholder", error.text());
      }
		});

		$.validator.addMethod("code", function (value, element) 
    {
        return this.optional(element) || /^[A-Z]{2}[0-9]{4}$/.test(value);
    }, "Invalid code");

    $(".approve").on("click", function(e){
    	e.preventDefault();

    	var form = $("#edit_registered_company");

    	$("input[name=company_code]").rules("add", {
        code: true        
    	});

    	if($("input[name=user_person_code]").length) {
	    	$("input[name=user_person_code]").rules("add", {
	        required: true        
	    	});
	    }

    	for(var i=1;i<=$(".shareholder").length;i++) {    		
    		if($("input[name=shareholder_"+i+"_person_code]").length) {
	    		$("input[name=shareholder_"+i+"_person_code]").rules("add", {
	          required: true
	      	});
	    	}
    	}

    	for(var i=1;i<=$(".director").length;i++) {    		
    		if($("input[name=director_"+i+"_person_code]").length) {
    			$("input[name=director_"+i+"_person_code]").rules("add", {
	          required: true
	      	});	
    		}
    		
    	}

    	for(var i=1;i<=$(".secretary").length;i++) {  
    		if($("input[name=secretary_"+i+"_person_code]").length) {
    			$("input[name=secretary_"+i+"_person_code]").rules("add", {
	          required: true
	      	});	
    		}	    		
    	}

    	if($("input[name=nominee_director_person_code]").length) {
	    	$("input[name=nominee_director_person_code]").rules("add", {
	        required: true
	    	});
	    }

	    if($("input[name=nominee_secretary_person_code]").length) {
	    	$("input[name=nominee_secretary_person_code]").rules("add", {
	        required: true        
	    	});
	    }

	    if(form.valid()) {
	    	var self= $(".approve"),
		        form = $("#edit_registered_company"),
		        tempElement = $("<input type='hidden'/>");

		    tempElement.attr("name", "action_type").val(self.val()).appendTo(form);

	      $("input[name=submit]").remove();

	    	form.submit();
	    }
	    

    });

	</script>
@endsection