@extends('layouts.master')

@section('content')
	<style>
		.remove-this {
	    position: absolute;
	    right: 25px;
	    top: 12px;
		}
		.add-this {
	    font-size: 12px;	    
		}
		i {
    	font-size: 10px;
    }
	</style>
	<div class="container">
		<div class="row">
			<div class="col-md-8">				
				<div class="space50"></div>
				<h1>Edit company record</h1>	 
				{{ Form::open(['route' => ['officiumtutus.approvedcompany.destroy', $company->id], 'method' => 'delete', 'style' => 'display:inline-block;']) }}		
					<button type="submit" class="remove-record custom-submit-class">Remove record</button>
				{{ Form::close() }}
				{!! link_to_route('officiumtutus.approvedcompany.index', 'Back to company database', [ '', 'search_from_date' => Request::input('search_from_date'), 'search_to_date' => Request::input('search_to_date'), 'search_date_field' => Request::input('search_date_field'), 'search' => Request::input('search')], ['class'=>'custom-submit-class'] ) !!}
				<!--<a href="{{ route('officiumtutus.approvedcompany.index') }}"><button class="custom-submit-class">Back to company database</button></a>-->

				{{ Form::open([ 'route' => ['officiumtutus.approvedcompany.update', $company->id ], 'method' => 'put', 'id' => 'edit_registered_company' ]) }}	
					<div class="space50"></div>
					<div class="labels">
						<!--<div class="row">
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
						</div>-->
						<div class="row">
							<div class="col-md-12">
								@if($companywpuser->actual_payment_response)								
								<?php	
								$time_stamp = json_decode($companywpuser->actual_payment_response)->completion_time_stamp;				
								?>
								<p>Payment collected {{ date("d/m/Y", strtotime($time_stamp)) }}</p>								
								@endif
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
									<input type="hidden" name="companywpuser_id" class="person" value="{{ $companywpuser->id }}">
									<div class="each-input">
										<label for="user_person_code">Contact person</label>
										{!! Form::select("wpuser_id", $userList, $companywpuser->wpuser_id, array('id'=>'change_owner_dropdown')) !!}
										<input type="hidden" name="user_person_code" id="user_person_code" value="{{ $companywpuser->owner_person_code }}" class="person">
									</div>
								</fieldset>
								
							</div>
						</div>		
						<div class="row">
							<div class="col-md-4">Jurisdiction</div>
							<div class="col-md-8">
								{!! Form::select("jurisdiction", $jurisdictionList, $company->companytypes->jurisdiction, array('id'=> 'jurisdiction')) !!}
								{{-- <p>{{ $company->companytypes->jurisdiction }}</p> --}}
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Company type</p></div>
							<div class="col-md-8">
								{!! Form::select("company_type", $companytypeList, $company->companytypes->name, array('id'=> 'company_type')) !!}
								{{-- <p>{{ $company->companytypes->name }}</p> --}}
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Company registration number</p></div>
							<div class="col-md-8">
								<input type="text" name="reg_no" value="{{ $companywpuser->reg_no }}">
							</div>
						</div>
						<div class="row">
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
						</div>
						<div class="row">
							<div class="col-md-4"><p>Incorporation date</p></div>
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
								<div class="shareholder">			
									<input type="hidden" name="shareholder_count" class="shareholder_count" value="">						
        					@if(count($company->companywpuser_shareholders) > 0)
	        					@foreach($company->companywpuser_shareholders as $key => $shareholder)
		        					<div class="row each-director">
		        						<div class="col-md-12">		        							
		        							<fieldset>
		        								{{-- @if($key!==0) --}}
			        							<a href="#" class="remove-this" data-selector="shareholder"><i class="fa fa-times" aria-hidden="true"></i></a>
			        							{{-- @endif --}}
			        							<legend>Shareholder {{ $key+1 }}</legend>

			        							<input type="hidden" name="prefix" value="shareholder_{{ $key+1 }}" class="person">
			        							<input type="hidden" name="shareholder_{{ $key+1 }}_companywpuser_shareholder_id" value="{{ $shareholder->id }}" class="person">
			        							<input type="hidden" name="shareholder_{{ $key+1 }}_person_role" value="shareholder" class="person">

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
						        					<input type="hidden" name="shareholder_{{ $key+1 }}_shareholder" class="shareholder-nominee-shareholder" value="{{ $shareholder->shareholder }}">
						        				</div>
			        							<div class="each-input">
			        								<label for="shareholder_{{ $key+1 }}_person_code">Beneficial owner</label>
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
			        								<input type="text" class="shareholder-ac" value="{{ $shareholder->person_code . $name }}" >
			        								<input type="hidden" name="shareholder_{{ $key+1 }}_person_code" class="shareholder-person-code person" value="{{ $shareholder->person_code }}" >
			        							</div>
						        				<div class="each-input">
						        					<label for="shareholder_{{ $key+1 }}_share_amount">Shares held</label>
						        					<input type="text" class="shareholder-share-amount person" name="shareholder_{{ $key+1 }}_share_amount" value="{{ $shareholder->share_amount }}">
						        				</div>				        											        				
					        				</fieldset>
		        						</div>
		        					</div>			        					
	        					@endforeach
	        				@else
										<div class="row each-director">
	        						<div class="col-md-12">
	        							<fieldset>
		        							<legend>Shareholder 1</legend>

					        				<div class="each-input">
					        					<label for="shareholder_1_shareholder">Shareholder</label>
					        					<input type="text" class="nominee_shareholder" value="">
					        					<input type="hidden" class="shareholder-nominee-shareholder" name="shareholder_1_shareholder" value="">
					        				</div>
		        							<div class="each-input">
		        								<label for="shareholder_1_person_code">Beneficial owner</label>				
		        								<input type="text" class="shareholder-ac" value="" >
		        								<input type="hidden" name="shareholder_1_person_code" class="shareholder-person-code person" value="" >
		        							</div>
					        				<div class="each-input">
					        					<label for="shareholder_1_share_amount">Shares held</label>
					        					<input type="text" class="shareholder-share-amount person" name="shareholder_1_share_amount" value="">
					        				</div>				        											        				
				        				</fieldset>
	        						</div>
	        					</div>
        					@endif
        					<div class="cloneable" style="display:none;">
        						<div class="row">
        							<div class="col-md-12">        								
	        							<fieldset>
	        								<a href="#" class="remove-this" data-selector="shareholder"><i class="fa fa-times" aria-hidden="true"></i></a>
		        							<legend>Shareholder 0</legend>													
					        				<div class="each-input">
					        					<label for="shareholder_0_shareholder">Shareholder</label>					
					        					<input type="text" disabled="disabled" class="nominee_shareholder" value="">
					        					<input type="hidden" class="shareholder-nominee-shareholder" disabled="disabled" name="shareholder_0_shareholder" value="">
					        				</div>
		        							<div class="each-input">
		        								<label for="shareholder_0_person_code">Beneficial owner</label>			
		        								<input type="text" disabled="disabled" class="shareholder-ac" value="">
		        								<input type="hidden" class="shareholder-person-code person" disabled="disabled" name="shareholder_0_person_code" value="">
		        							</div>
					        				<div class="each-input">
					        					<label for="shareholder_0_share_amount">Shares held</label>
					        					<input type="text" class="shareholder-share-amount person" disabled="disabled" name="shareholder_0_share_amount" value="">
					        				</div>
				        				</fieldset>
	        						</div>
        						</div>
      						</div>
        					<div class="pasteclone"></div>
      						<a href="#" class="add-this" data-selector="shareholder">Add shareholder <i class="fa fa-plus"></i></a>
    						</div>	        					
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<p>Directors</p>
							</div>
							<div class="col-md-8">
									<div class="director">			
										<input type="hidden" name="director_count" class="director_count" value="">														
	        					@if(count($company->companywpuser_directors) > 0)
		        					@foreach($company->companywpuser_directors as $key => $director)
			        					<div class="row each-director">
			        						<div class="col-md-12">
			        							<fieldset>
			        								{{-- @if($key!==0) --}}
			        								<a href="#" class="remove-this" data-selector="director"><i class="fa fa-times" aria-hidden="true"></i></a>
			        								{{-- @endif --}}
				        							<legend>Director {{ $key+1 }}</legend>
				        							<input type="hidden" class="person" name="prefix" value="director_{{ $key+1 }}">
				        							<input type="hidden" class="person" name="director_{{ $key+1 }}_companywpuser_director_id" value="{{ $director->id }}">
				        							<input type="hidden" class="person" name="director_{{ $key+1 }}_person_role" value="director">

				        							<div class="each-input">
						        						<label for="director_{{ $key+1 }}_type">Type</label>
						        						@if($director->type==1)
																	<span>{{ "Individual" }}</span>
						        						@else
																	<span>{{ "Company" }}</span>
						        						@endif
						        						<input type="hidden" name="director_{{ $key+1 }}_type" id="director_{{ $key+1 }}_type" value="{{ $director->type }}">
							        				</div>
							        				<div class="each-input">
				        								<label for="director_{{ $key+1 }}_person_code">Name</label>
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
				        								<input type="text" class="director-ac" value="{{ $director->person_code.$name }}" >
				        								<input type="hidden" class="person director-person-code" name="director_{{ $key+1 }}_person_code" value="{{ $director->person_code }}" >
				        							</div>				        							    				
						        				</fieldset>
			        						</div>
			        					</div>	        					
		        					@endforeach
		        				@else
		        					<div class="row each-director">
		        						<div class="col-md-12">
		        							<fieldset>
			        							<legend>Director 1</legend>

						        				<div class="each-input">
			        								<label for="director_1_person_code">Name</label>				        					
			        								<input type="text" class="director-ac" value="" >
			        								<input type="hidden" class="person director-person-code" name="director_1_person_code" value="" >
			        							</div>				        							    				
					        				</fieldset>
		        						</div>
		        					</div>
	        					@endif
										<div class="cloneable" style="display:none;">
											<div class="row">
		        						<div class="col-md-12">
		        							<fieldset>
		        								<a href="#" class="remove-this" data-selector="director"><i class="fa fa-times" aria-hidden="true"></i></a>
			        							<legend>Director 0</legend>

						        				<div class="each-input">
			        								<label for="director_0_person_code">Name</label>				        					
			        								<input type="text" disabled="disabled" class="director-ac" value="" >
			        								<input type="hidden" disabled="disabled" class="person director-person-code" name="director_0_person_code" value="" >
			        							</div>			        							    				
					        				</fieldset>
		        						</div>
		        					</div>
										</div>
										<div class="pasteclone"></div>
      							<a href="#" class="add-this" data-selector="director">Add director <i class="fa fa-plus"></i></a>	        					
	        				</div>									        					
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<p>Secretaries</p>
							</div>
							<div class="col-md-8">								
	        					@if(count($company->companywpuser_secretaries) > 0)	        						
		        					@foreach($company->companywpuser_secretaries as $key => $secretary)		        				
												<div class="row each-director">
			        						<div class="col-md-12">
			        							<fieldset>
				        							<legend>Secretary {{ $key+1 }}</legend>
															<input type="hidden" class="person" name="prefix" value="secretary_{{ $key+1 }}">
				        							<input type="hidden" class="person" name="secretary_{{ $key+1 }}_companywpuser_secretary_id" value="{{ $secretary->id }}">
				        							<input type="hidden" class="person" name="secretary_{{ $key+1 }}_person_role" value="secretary">

				        							<div class="each-input">
						        						<label for="secretary_{{ $key+1 }}_type">Type</label>
						        						@if($secretary->type==1)
																	<span>{{ "Individual" }}</span>
						        						@else
																	<span>{{ "Company" }}</span>
						        						@endif
						        						<input type="hidden" name="secretary_{{ $key+1 }}_type" id="secretary_{{ $key+1 }}_type" value="{{ $secretary->type }}">
							        				</div>							        				
							        				<div class="each-input">
				        								<label for="secretary_{{ $key+1 }}_person_code">Name</label>
				        								<?php 
								        					$this_person = App\Person::where('person_code', $secretary->person_code)->get(); 								        					
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
				        								<input type="text" class="secretary-ac" value="{{ $secretary->person_code.$name }}" >
				        								<input type="hidden" class="person" name="secretary_{{ $key+1 }}_person_code" value="{{ $secretary->person_code }}" >
				        							</div>				        							
						        				</fieldset>
			        						</div>
			        					</div>
		        					@endforeach
		        				@else
											<div class="row each-director">
			        						<div class="col-md-12">
			        							<fieldset>
				        							<legend>Secretary 1</legend>

							        				<div class="each-input">
				        								<label for="secretary_1_person_code">Name</label>				        					
				        								<input type="text" class="secretary-ac" value="" >
				        								<input type="hidden" class="person" name="secretary_1_person_code" value="" >
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
						<div class="row">
							<div class="col-md-4"><p>Date of next accounts</p></div>	
							<div class="col-md-8"><input type="text" name="date_of_next_accounts" id="date_of_next_accounts" class="date-input" placeholder="dd/mm/yyyy" value="{{ (strtotime($companywpuser->date_of_next_accounts) <= 0) ? "" : date('d/m/Y', strtotime($companywpuser->date_of_next_accounts)) }}"></div>			
						</div>
						<div class="row">
							<div class="col-md-4"><p>Date of last accounts</p></div>	
							<div class="col-md-8"><input type="text" name="date_of_last_accounts" id="date_of_last_accounts" class="date-input" placeholder="dd/mm/yyyy" value="{{ (strtotime($companywpuser->date_of_last_accounts) <= 0) ? "" : date('d/m/Y', strtotime($companywpuser->date_of_last_accounts)) }}"></div>			
						</div>						
						<div class="row">
							<div class="col-md-4"><p>Accounts completion deadline</p></div>	
							<div class="col-md-8"><input type="text" name="accounts_completion_deadline" id="accounts_completion_deadline" class="date-input" placeholder="dd/mm/yyyy" value="{{ (strtotime($companywpuser->accounts_completion_deadline) <= 0) ? "" : date('d/m/Y', strtotime($companywpuser->accounts_completion_deadline)) }}"></div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p>Date of last VAT return</p></div>	
							<div class="col-md-8"><input type="text" name="date_of_last_vat_return" id="date_of_last_vat_return" class="date-input" placeholder="dd/mm/yyyy" value="{{ (strtotime($companywpuser->date_of_last_vat_return) <= 0) ? "" : date('d/m/Y', strtotime($companywpuser->date_of_last_vat_return)) }}"></div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p>Date of next VAT return</p></div>	
							<div class="col-md-8"><input type="text" name="date_of_next_vat_return" id="date_of_next_vat_return" class="date-input" placeholder="dd/mm/yyyy" value="{{ (strtotime($companywpuser->date_of_next_vat_return) <= 0) ? "" : date('d/m/Y', strtotime($companywpuser->date_of_next_vat_return)) }}"></div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p>VAT return deadline</p></div>	
							<div class="col-md-8"><input type="text" name="vat_return_deadline" id="vat_return_deadline" class="date-input" placeholder="dd/mm/yyyy" value="{{ (strtotime($companywpuser->vat_return_deadline) <= 0) ? "" : date('d/m/Y', strtotime($companywpuser->vat_return_deadline)) }}"></div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p>Date of last AGM</p></div>	
							<div class="col-md-8"><input type="text" name="date_of_last_agm" id="date_of_last_agm" class="date-input" placeholder="dd/mm/yyyy" value="{{ (strtotime($companywpuser->date_of_last_agm) <= 0) ? "" : date('d/m/Y', strtotime($companywpuser->date_of_last_agm)) }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Next AGM due by</p></div>	
							<div class="col-md-8"><input type="text" name="next_agm_due_by" id="next_agm_due_by"  class="date-input" placeholder="dd/mm/yyyy" value="{{ (strtotime($companywpuser->next_agm_due_by) <= 0) ? "" : date('d/m/Y', strtotime($companywpuser->next_agm_due_by)) }}"></div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p>Next domiciliation renewal</p></div>	
							<div class="col-md-8"><input type="text" name="next_domiciliation_renewal" id="next_domiciliation_renewal" class="date-input" placeholder="dd/mm/yyyy" value="{{ (strtotime($companywpuser->next_domiciliation_renewal) <= 0) ? "" : date('d/m/Y', strtotime($companywpuser->next_domiciliation_renewal)) }}"></div>			
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text-2">Incorporation certificate</p></div><!--
							--><div class="col-md-4">
								<input type="hidden" name="incorporation_certificate" value="{{ $companywpuser->incorporation_certificate }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="File uploaded">Upload file</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="incorporation_certificate" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="incorporation_certificate_files" class="pdf_files files"><p>{{ $companywpuser->incorporation_certificate }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text-2">Incumbency certificate</p></div><!--
							--><div class="col-md-4">
								<input type="hidden" name="incumbency_certificate" value="{{ $companywpuser->incumbency_certificate }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="File uploaded">Upload file</button>
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
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="File uploaded">Upload file</button>
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
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="File uploaded">Upload file</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="last_financial_statements" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="last_financial_statements_files" class="pdf_files files"><p>{{ $companywpuser->last_financial_statements }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text">Document 5</p></div><!--
							--><div class="col-md-4">
								<input type="text" name="other_documents_1_title" placeholder="Document title" value="{{ $companywpuser->other_documents_1_title }}">
								<input type="hidden" name="other_documents_1" value="{{ $companywpuser->other_documents_1 }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="File uploaded">Upload file</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="other_documents_1" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="other_documents_1_files" class="pdf_files files"><p>{{ $companywpuser->other_documents_1 }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text">Document 6</p></div><!--
							--><div class="col-md-4">
								<input type="text" name="other_documents_2_title" placeholder="Document title" value="{{ $companywpuser->other_documents_2_title }}">
								<input type="hidden" name="other_documents_2" value="{{ $companywpuser->other_documents_2 }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="File uploaded">Upload file</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="other_documents_2" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="other_documents_2_files" class="pdf_files files"><p>{{ $companywpuser->other_documents_2 }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text">Document 7</p></div><!--
							--><div class="col-md-4">
								<input type="text" name="other_documents_3_title" placeholder="Document title" value="{{ $companywpuser->other_documents_3_title }}">
								<input type="hidden" name="other_documents_3" value="{{ $companywpuser->other_documents_3 }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="File uploaded">Upload file</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="other_documents_3" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="other_documents_3_files" class="pdf_files files"><p>{{ $companywpuser->other_documents_3 }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text">Document 8</p></div><!--
							--><div class="col-md-4">
								<input type="text" name="other_documents_4_title" placeholder="Document title" value="{{ $companywpuser->other_documents_4_title }}">
								<input type="hidden" name="other_documents_4" value="{{ $companywpuser->other_documents_4 }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="File uploaded">Upload file</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="other_documents_4" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="other_documents_4_files" class="pdf_files files"><p>{{ $companywpuser->other_documents_4 }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text">Document 9</p></div><!--
							--><div class="col-md-4">
								<input type="text" name="other_documents_5_title" placeholder="Document title" value="{{ $companywpuser->other_documents_5_title }}">
								<input type="hidden" name="other_documents_5" value="{{ $companywpuser->other_documents_5 }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="File uploaded">Upload file</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="other_documents_5" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="other_documents_5_files" class="pdf_files files"><p>{{ $companywpuser->other_documents_5 }}</p></div>								
							</div>						
						</div>
						<div class="row">
							<div class="col-md-4"><p class="align-text">Document 10</p></div><!--
							--><div class="col-md-4">
								<input type="text" name="other_documents_6_title" placeholder="Document title" value="{{ $companywpuser->other_documents_6_title }}">
								<input type="hidden" name="other_documents_6" value="{{ $companywpuser->other_documents_6 }}" />
	                            <span class="btn fileinput-button">
	                                <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="File uploaded">Upload file</button>
	                                <!-- The file input field used as target for the file upload widget -->
	                                <input class="pdf_upload" type="file" name="files" data-fieldname="other_documents_6" />
	                            </span>
	                            <!-- The container for the uploaded files -->
	                            <div id="other_documents_6_files" class="pdf_files files"><p>{{ $companywpuser->other_documents_6 }}</p></div>								
							</div>						
						</div>
						<input type="submit" name="submit" value="Save" class="save custom-submit-class">
						<!-- <input type="submit" name="submit" value="Approve" class="approve custom-submit-class">
						<input type="submit" name="submit" value="Reject" class="reject custom-submit-class"> -->
					</div>					
				{{ Form::close() }}
			</div>
		</div>
	</div>
	<div class="space100"></div>
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
            $this.parent().parent().find("label").text("Memo & articles");
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
    		if(val=="" && i.indexOf('passport') === -1 && i.indexOf('bill') === -1) missing_fields = i;
    		var field = $("input[name="+i+"]").prev("label").text();
    		$("input[name="+i+"]").attr("placeholder", field+" is required.").addClass("error");
    	});

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

		// $(".add-user-to-person").hide();
		// $( "#user_person_code" ).autocomplete({
		// 	source: persons,
		// 	select: function (event, ui) {
		// 	    var label = ui.item.label;
		// 	    var value = ui.item.value;
			   	
		// 	   	var res = value.split("-");
		// 	  	$(this).next("input").val(res[0].trim());

		// 	  	showHideAddUserToPerson($(".add-user-to-person"), value)
		// 	}
		// });

		// function showHideAddUserToPerson($selector, inputValue) {
		// 	if(jQuery.inArray(inputValue, persons) == -1 && inputValue!= "") {
		// 		$selector.parent().next('.each-input').find(".add-user-to-person").show();
		// 		$selector.next("input").val(inputValue);
		// 	}else {
		// 		$selector.parent().next('.each-input').find(".add-user-to-person").hide();
		// 	}
		// }

		// $("#user_person_code").on("change keyup paste", function(e){
		// 	var inputValue = $(this).val();

		// 	console.log(persons)
		// 	console.log(inputValue)

		// 	showHideAddUserToPerson($(this), inputValue);

		// });

		function autoCompleteIndividuals($selector) {
			$selector.autocomplete({
				source: persons,
				select: function (event, ui) {
				    var label = ui.item.label;
				    var value = ui.item.value;
				   	
				   	var res = value.split("-");
				  	$(this).next("input").val(res[0].trim());		

				  	// showHideAddToPerson($(this), value);		  	
				}
			});
		}

		autoCompleteIndividuals($( ".shareholder-ac" ));
		autoCompleteIndividuals($( ".director-ac" ));
		autoCompleteIndividuals($( ".secretary-ac" ));		

		$(".add-to-person").hide();

		function showHideAddToPerson($selector, inputValue) {
			if(jQuery.inArray(inputValue, persons) == -1 && inputValue!= "") {
				$selector.parent().next('.each-input').find(".add-to-person").show();
				$selector.next("input").val(inputValue);
			}else {
				$selector.parent().next('.each-input').find(".add-to-person").hide();
			}
		}

		function showHideButtonAndUpdateInput($selector) {
			$selector.on("change keyup paste", function(e){
				var inputValue = $(this).val();

				showHideAddToPerson($(this), inputValue)
			});
		}
		
		showHideButtonAndUpdateInput($(".shareholder-ac"));
		showHideButtonAndUpdateInput($(".director-ac"));
		showHideButtonAndUpdateInput($(".secretary-ac"));

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

			            // Handle 'no match' indicated by [ "" ] response
			            // response( data.length === 1 && data[ 0 ].length === 0 ? [] : update_to_date_persons );

			            var data = $.map(data, function(v, i){
			            	if(v.first_name!=="")
			          			return (v.person_code+" - "+v.first_name+" "+v.surname);
			          		else
			          			return (v.person_code+" - "+v.third_party_company_name);			          		
			          	});

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

	    $(".remove-record").on("click", function(e){
	    	e.preventDefault();
	    	if (confirm("Are you sure you want to delete?")) {
	    		$(this).parent('form').submit();
	    	}	
	    });

	    $("#change_owner_dropdown").on("change", function(e){
	    	var value = $("#change_owner_dropdown option:selected").text();

	    	var res = value.split("-");

	    	var code = res[0].trim();

	    	$("#user_person_code").val(code);

	    });

	    // $("#jurisdiction").on("change", function(e){
	    // 	console.log($(this).val());
	    // 	$("#company_type").val($(this).val())
	    // });

	    // $("#company_type").on("change", function(e){
	    // 	console.log($(this).val());
	    // 	$("#jurisdiction").val($(this).val())
	    // });

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

	    /// CLONE FORM

	    function cloneForm($el) {
          var html = $el.children('.row').clone();
          $(html).addClass("each-director");
          $el.next(".pasteclone").append(html);
      }

      function updateClonedFields($pasteclone, selector) {
          var fieldID = $("."+selector).find(".each-director").length;
          var $fieldContainer = $pasteclone.find(".each-director").last();
          var lblName = selector.charAt(0).toUpperCase() + selector.slice(1);

          amendFields(fieldID, selector, lblName, $fieldContainer, "add");

      }

      function updateExistingFieldsAfterDelete(selector) {
          var $fieldContainers = $("."+selector).find(".each-director");

          $fieldContainers.each(function(i, obj){
              var fieldID = i + 1;
              var lblName = selector.charAt(0).toUpperCase() + selector.slice(1);
              var $fieldContainer = $(obj);

              amendFields(fieldID, selector, lblName, $fieldContainer, "delete");

          });
      }

      function amendFields(fieldID, selector, lblName, $fieldContainer, action) {          

          $fieldContainer.find("legend").html(lblName+" "+fieldID);

          $fieldContainer.find("input").attr("disabled", false);

          if(selector=='shareholder') {
            if(action!=="delete") $fieldContainer.find("."+selector+"-nominee-shareholder").val("");
            $fieldContainer.find("."+selector+"-nominee-shareholder").attr("name", selector+"_"+fieldID+"_shareholder");

            autoCompleteNominee($( ".nominee_shareholder" ));
          }          

          if(action!=="delete") $fieldContainer.find("."+selector+"-person-code").val("");
          $fieldContainer.find("."+selector+"-person-code").attr("name", selector+"_"+fieldID+"_person_code");

          autoCompleteIndividuals($( "."+selector+"-ac" ));

          if(selector=='shareholder') {
            if(action!=="delete") $fieldContainer.find("."+selector+"-share-amount").val("");
            $fieldContainer.find("."+selector+"-share-amount").attr("name", selector+"_"+fieldID+"_share_amount");
          }

          $("."+selector+"_count").val(fieldID);

      }

      $(".shareholder_count").val($('.shareholder').find(".each-director").length);
      $(".director_count").val($('.director').find(".each-director").length);

      $('.add-this').on('click', function(e){
      	e.preventDefault();
      	cloneForm($(this).parent().find('.cloneable'));
      	updateClonedFields($(this).parent().find('.pasteclone'), $(this).data("selector"));
      });

      $(document).on("click", '.remove-this', function(e){
      	e.preventDefault();
      	var selector = $(this).data("selector");
      	if (confirm("Are you sure you want to remove?")) {
      		$(this).parent().parent().parent(".each-director").remove();    
          updateExistingFieldsAfterDelete(selector);
      	}
      });
    
	</script>	
@endsection