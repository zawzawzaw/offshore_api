@extends("layouts.master")

@section("content")
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="space50"></div>
				<h1>View order</h1>			
				<a href="javascript:void(0);" class="print"><button class="hidden-print custom-submit-class">Print</button></a>	
				<a href="{{ route('officiumtutus.registeredcompany.index') }}"><button class="hidden-print custom-submit-class">Back to pending orders</button></a>				
				
				<div class="space50"></div>
				<div class="labels">
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
						<div class="col-md-3"><p>Company status</p></div>
						<div class="col-md-7">
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
						<div class="col-md-3"><p>Company code</p></div>	
						<div class="col-md-7"><p>{{ $company->code }}</p></div>	
					</div>
					<div class="row">
						<div class="col-md-3"><p>Company name</p></div>	
						<div class="col-md-7"><p>{{ $company->name }}</p></div>	
					</div>
					<div class="row">
						<div class="col-md-3"><p>Notes</p></div>	
						<div class="col-md-7"><p>{{ $companywpuser->notes }}</p></div>	
					</div>					
					<div class="row">
						<div class="col-md-3">User</div>
						<div class="col-md-7">
							<fieldset class="persons">
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
								<div class="row">
	        						<div class="col-md-6">Person code</div>
	        						<div class="col-md-6">
        							<?php $person = App\Person::where('person_code', $companywpuser->owner_person_code)->first(); ?>
									@if($person)
									{{ $companywpuser->owner_person_code . " - " . $person->first_name . " ". $person->surname }}
									@endif
	        						</div>
		        				</div>								
							</fieldset>						
						</div>
					</div>
					<div class="row">
						<div class="col-md-3"><p>Jurisdiction</p></div>
						<div class="col-md-7"><p>{{ $company->companytypes->jurisdiction }}</p></div>
					</div>
					<div class="row">
						<div class="col-md-3"><p>Company type</p></div>
						<div class="col-md-7"><p>{{ $company->companytypes->name }}</p></div>
					</div>
					<div class="row">
						<div class="col-md-3"><p>Company registration number</p></div>
						<div class="col-md-7">
							<p>{{ $companywpuser->reg_no }}</p>
						</div>
					</div>
					<!-- <div class="row">
						<div class="col-md-3"><p>Company tax number</p></div>
						<div class="col-md-7">
							<p>{{ $companywpuser->tax_no }}</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3"><p>VAT registration number</p></div>
						<div class="col-md-7">
							<p>{{ $companywpuser->vat_reg_no }}</p>
						</div>
					</div> -->
					<div class="row">
						<div class="col-md-3"><p>Incorporation date</p></div>
						<div class="col-md-7">
							<p>{{ (strtotime($company->incorporation_date) <= 0) ? "" : date('d M Y', strtotime($company->incorporation_date)) }}</p>
						</div>
					</div>
					@if(!empty($companywpuser->incorporation_certificate))
					<div class="row">
						<div class="col-md-3">Incorporation certificate</div>
						<div class="col-md-7"><p><a target="_blank" href="{{ url('public/uploads/'.$company->wpusers[0]->user_login.'/'.$companywpuser->incorporation_certificate) }}">{{ $companywpuser->incorporation_certificate }}</a></p></div>
					</div>
					@endif
					<div class="row">
						<div class="col-md-3"><p>Registered office</p></div>
						<div class="col-md-7">
							<p>{{ $companywpuser->reg_office }}</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3"><p>Shareholders</p></div>
						<div class="col-md-7">
							@if(count($company->companywpuser_shareholders) > 0)							
      					@foreach($company->companywpuser_shareholders as $key => $shareholder)
        						@if($companywpuser->nominee_shareholder==1)
								<br>
        						@endif
								<fieldset class="persons">
        							<legend>Shareholder {{ $key+1 }}</legend>
									<!-- <div class="row">
										<div class="col-md-6">Type</div>
										<div class="col-md-6">
											@if($shareholder->type==1)
		                    					<p>{{ "Individual" }}</p>
		                    				@else
												<p>{{ "Company" }}</p>
		                    				@endif
										</div>
									</div> -->
									<div class="row">
										<div class="col-md-6">Beneficial owner</div>
										<div class="col-md-6">{{ $shareholder->name }}</div>
									</div>
									<div class="row">
        								<div class="col-md-6">Person code</div>
        								<div class="col-md-6">
        									<?php $person = App\Person::where('person_code', $shareholder->person_code)->first(); ?>        									
        									@if($person)
        										@if(!empty($person->first_name))
        											{{ $shareholder->person_code . " - " . $person->first_name . " ". $person->surname }}
        										@else
        											{{ $shareholder->person_code . " - " . $person->third_party_company_name }}
        										@endif
        									@else
        										{{ $shareholder->person_code }}
        									@endif
        								</div>
        							</div>
        							<!-- <div class="row">
			        					<div class="col-md-6"">Nominee shareholder selected</div>
			        					@if($companywpuser->nominee_shareholder==1)
											<div class="col-md-6">Yes</div>
										@else
											<div class="col-md-6">No</div>
				        				@endif
			        				</div> -->
			        				<div class="row">
										<div class="col-md-6">Shareholder</div>
										<div class="col-md-6">
											<?php $person = App\Person::where('person_code', $shareholder->shareholder)->first(); ?>											
											@if($person)
												@if(!empty($person->first_name))
													{{ $shareholder->shareholder . " - " . $person->first_name . " ". $person->surname }}
												@else
													{{ $shareholder->shareholder . " - " . $person->third_party_company_name }}
												@endif
											@else
												{{ $shareholder->shareholder }}
											@endif
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">Number of shares</div>
										<div class="col-md-6">{{ $shareholder->share_amount }}</div>
									</div>
									<div class="row">
										<div class="col-md-6">Address</div>
										<div class="col-md-6">
											<p>{{ $shareholder->address }}</p>
											<p>{{ $shareholder->address_5 }}</p>
											<p>{{ $shareholder->address_2 }}</p>
											<p>{{ $shareholder->address_3 }}</p>
											<p>{{ $shareholder->address_4 }}</p>											
										</div>
									</div>									
									<div class="row">
										<div class="col-md-6">Telephone</div>
										<div class="col-md-6">{{ $shareholder->telephone }}</div>
									</div>
									<div class="row">
										<div class="col-md-6">@if($shareholder->type==1){{ "Passport" }} @else {{ "Incorporation certificate" }} @endif</div>
										<div class="col-md-6"><a target="_blank" href="{{ url('public/uploads/'.$company->wpusers[0]->user_login.'/'.$shareholder->passport) }}">{{ $shareholder->passport }}</a></div>
									</div>
									<div class="row">
										<div class="col-md-6">@if($shareholder->type==1){{ "Utility bill" }} @else {{ "Memo & articles" }} @endif</div>
										<div class="col-md-6"><a target="_blank" href="{{ url('public/uploads/'.$company->wpusers[0]->user_login.'/'.$shareholder->bill) }}">{{ $shareholder->bill }}</a></div>
									</div>									
    							</fieldset>
        					@endforeach	
        				@endif
						</div>
					</div>
					<div class="row">
						<div class="col-md-3"><p>Directors</p></div>
						<div class="col-md-7">			
							@if(count($company->companywpuser_directors) > 0)				
	    					@foreach($company->companywpuser_directors as $key => $director)
	        						@if($companywpuser->nominee_director==1)
											<br>
	        						@endif
	        						<fieldset class="persons">
	        							<legend>Director {{ $key+1 }}</legend>
										<!-- <div class="row">
											<div class="col-md-6">Type</div>
											<div class="col-md-6">
												@if($director->type==1)
			                    					<p>{{ "Individual" }}</p>
			                    				@else
													<p>{{ "Company" }}</p>
			                    				@endif
											</div>
										</div> -->									
										<div class="row">
											<div class="col-md-6">Name</div>
											<div class="col-md-6">{{ $director->name }}</div>
										</div>
										<div class="row">
		    								<div class="col-md-6">Person code</div>	    						
		    								<div class="col-md-6">
	    									<?php $person = App\Person::where('person_code', $director->person_code)->first(); ?>
												@if($person)
													@if(empty($person->first_name) && empty($person->surname))
														{{ $director->person_code . " - " . $person->third_party_company_name }}
													@else
														{{ $director->person_code . " - " . $person->first_name . " ". $person->surname }}
													@endif
												@endif	    									
		    								</div>	    								
		    							</div>
										<div class="row">
											<div class="col-md-6">Address</div>
											<div class="col-md-6">
												<p>{{ $director->address }}</p>
												<p>{{ $director->address_5 }}</p>
												<p>{{ $director->address_2 }}</p>
												<p>{{ $director->address_3 }}</p>
												<p>{{ $director->address_4 }}</p>
											</div>
										</div>									
										<div class="row">
											<div class="col-md-6">Telephone</div>
											<div class="col-md-6">{{ $director->telephone }}</div>
										</div>
										<div class="row">
											<div class="col-md-6">@if($director->type==1){{ "Passport" }} @else {{ "Incorporation certificate" }} @endif</div>
											<div class="col-md-6"><a href="{{ url('public/uploads/'.$company->wpusers[0]->user_login.'/'.$director->passport) }}">{{ $director->passport }}</a></div>
										</div>
										<div class="row">
											<div class="col-md-6">@if($director->type==1){{ "Utility bill" }} @else {{ "Memo & articles" }} @endif</div>
											<div class="col-md-6"><a href="{{ url('public/uploads/'.$company->wpusers[0]->user_login.'/'.$director->bill) }}">{{ $director->bill }}</a></div>
										</div>
									</fieldset>
	    					@endforeach
							@elseif($companywpuser->nominee_director==1)
    						<div class="row">
      						<div class="col-md-12">
        						<fieldset class="persons">
        							<legend>Professional director</legend>
        							<div class="row">
										<div class="col-md-6">Person code</div>
										<div class="col-md-6">
											<?php $person = App\Person::where('person_code', $companywpuser->nominee_director_person_code)->first(); ?>
											@if($person)
												@if(!empty($person->first_name))
													{{ $companywpuser->nominee_director_person_code . " - " . $person->first_name . " ". $person->surname }}
												@else
													{{ $companywpuser->nominee_director_person_code . " - " . $person->third_party_company_name }}
												@endif
											@endif													
										</div>
									</div>
	        					</fieldset>
								</div>
      					</div>
    					@endif
						</div>
					</div>
					<div class="row">
						<div class="col-md-3"><p>Company secretary</p></div>
						<div class="col-md-7">	
								@if(count($company->companywpuser_secretaries) > 0)						
        					@foreach($company->companywpuser_secretaries as $key => $secretary)
        						@if($companywpuser->nominee_secretary==1)
								<br>
        						@endif
								<fieldset class="persons">
        							<legend>Secretary</legend>
									<!-- <div class="row">
										<div class="col-md-6">Type</div>
										<div class="col-md-6">
											@if($secretary->type==1)
		                    					<p>{{ "Individual" }}</p>
		                    				@else
												<p>{{ "Company" }}</p>
		                    				@endif
										</div>
									</div> -->
									<div class="row">
										<div class="col-md-6">Name</div>
										<div class="col-md-6">{{ $secretary->name }}</div>
									</div>
									<div class="row">
        								<div class="col-md-6">Person code</div>
        								<div class="col-md-6">
        									<?php $person = App\Person::where('person_code', $secretary->person_code)->first(); ?>
											@if($person)
												@if(!empty($person->first_name))
													{{ $secretary->person_code . " - " . $person->first_name . " ". $person->surname }}
												@else
													{{ $secretary->person_code . " - " . $person->third_party_company_name }}
												@endif
											@endif        									
        								</div>
        							</div>
									<div class="row">
										<div class="col-md-6">Address</div>
										<div class="col-md-6">
											<p>{{ $secretary->address }}</p>
											<p>{{ $secretary->address_5 }}</p>
											<p>{{ $secretary->address_2 }}</p>
											<p>{{ $secretary->address_3 }}</p>
											<p>{{ $secretary->address_4 }}</p>
										</div>
									</div>									
									<div class="row">
										<div class="col-md-6">Telephone</div>
										<div class="col-md-6">{{ $secretary->telephone }}</div>
									</div>
									<div class="row">
										<div class="col-md-6">@if($secretary->type==1){{ "Passport" }} @else {{ "Incorporation certificate" }} @endif</div>
										<div class="col-md-6"><a target="_blank" href="{{ url('public/uploads/'.$company->wpusers[0]->user_login.'/'.$secretary->passport) }}">{{ $secretary->passport }}</a></div>
									</div>
									<div class="row">
										<div class="col-md-6">@if($secretary->type==1){{ "Utility bill" }} @else {{ "Memo & articles" }} @endif</div>
										<div class="col-md-6"><a target="_blank" href="{{ url('public/uploads/'.$company->wpusers[0]->user_login.'/'.$secretary->bill) }}">{{ $secretary->bill }}</a></div>
									</div>
    							</fieldset>
        					@endforeach	
      					@elseif($companywpuser->nominee_secretary==1)
        						<div class="row">
	        						<div class="col-md-12">
		        						<fieldset class="persons">
		        							<legend>Professional secretary</legend>
		        							<div class="row">
												<div class="col-md-6">Person Code</div>
												<div class="col-md-6">
													<?php $person = App\Person::where('person_code', $companywpuser->nominee_secretary_person_code)->first(); ?>
													@if($person)
														@if(!empty($person->first_name))
															{{ $companywpuser->nominee_secretary_person_code . " - " . $person->first_name . " ". $person->surname }}
														@else
															{{ $companywpuser->nominee_secretary_person_code . " - " . $person->third_party_company_name }}
														@endif
													@endif													
												</div>
											</div>
			        					</fieldset>
    								</div>
	        					</div>
      					@endif						
						</div>
					</div>
					@if(count($servicescountries) > 1)
					<div class="row">
						<div class="col-md-3"><p>Additional services</p></div>
						<div class="col-md-7">							
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
						<div class="col-md-3"><p>Information requested</p></div>
						<div class="col-md-7">
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
						<div class="col-md-3">Date of next accounts</div>
						<div class="col-md-7"><p>{{ $companywpuser->date_of_next_accounts }}</p></div>
					</div>
					<div class="row">
						<div class="col-md-3">Date of last accounts</div>
						<div class="col-md-7"><p>{{ $companywpuser->date_of_last_accounts }}</p></div>
					</div>
					<div class="row">
						<div class="col-md-3">Accounts completion deadline</div>
						<div class="col-md-7"><p>{{ $companywpuser->accounts_completion_deadline }}</p></div>
					</div>
					<div class="row">
						<div class="col-md-3">Date of last VAT return</div>
						<div class="col-md-7"><p>{{ $companywpuser->date_of_last_vat_return }}</p></div>
					</div>
					<div class="row">
						<div class="col-md-3">Date of next VAT return</div>
						<div class="col-md-7"><p>{{ $companywpuser->date_of_next_vat_return }}</p></div>
					</div>	
					<div class="row">
						<div class="col-md-3">VAT return deadline</div>
						<div class="col-md-7"><p>{{ $companywpuser->vat_return_deadline }}</p></div>
					</div>	
					<div class="row">
						<div class="col-md-3">Next AGM due by</div>
						<div class="col-md-7"><p>{{ $companywpuser->next_agm_due_by }}</p></div>
					</div> -->
					<div class="row">
						<div class="col-md-3">Next domiciliation renewal</div>
						<div class="col-md-7"><p>{{ (strtotime($companywpuser->next_domiciliation_renewal) <= 0) ? "" : date('d M Y', strtotime($companywpuser->next_domiciliation_renewal)) }}</p></div>
					</div>					
					@if(!empty($companywpuser->incumbency_certificate))
					<div class="row">
						<div class="col-md-3">Incumbency certificate</div>
						<div class="col-md-7"><p><a target="_blank" href="{{ url('public/uploads/'.$company->wpusers[0]->user_login.'/'.$companywpuser->incumbency_certificate) }}">{{ $companywpuser->incumbency_certificate }}</a></p></div>
					</div>
					@endif
					@if(!empty($companywpuser->company_extract))
					<div class="row">
						<div class="col-md-3">Company extract</div>
						<div class="col-md-7"><p><a target="_blank" href="{{ url('public/uploads/'.$company->wpusers[0]->user_login.'/'.$companywpuser->company_extract) }}">{{ $companywpuser->company_extract }}</a></p></div>
					</div>	
					@endif
					@if(!empty($companywpuser->last_financial_statements))
						<div class="row">
							<div class="col-md-3">Last financial statements</div>
							<div class="col-md-7"><p><a target="_blank" href="{{ url('public/uploads/'.$company->wpusers[0]->user_login.'/'.$companywpuser->last_financial_statements) }}">{{ $companywpuser->last_financial_statements }}</a></p></div>
						</div>
					@endif
					@if(!empty($companywpuser->other_documents_1_title))
					<div class="row">
						<div class="col-md-3">{{ $companywpuser->other_documents_1_title }}</div>
						<div class="col-md-7"><p><a target="_blank" href="{{ url('public/uploads/'.$company->wpusers[0]->user_login.'/'.$companywpuser->other_documents_1) }}">{{ $companywpuser->other_documents_1 }}</a></p></div>
					</div>
					@endif
					@if(!empty($companywpuser->other_documents_2_title))
					<div class="row">
						<div class="col-md-3">{{ $companywpuser->other_documents_2_title }}</div>
						<div class="col-md-7"><p><a target="_blank" href="{{ url('public/uploads/'.$company->wpusers[0]->user_login.'/'.$companywpuser->other_documents_2) }}">{{ $companywpuser->other_documents_2 }}</a></p></div>
					</div>
					@endif
					@if(!empty($companywpuser->other_documents_3_title))
					<div class="row">
						<div class="col-md-3">{{ $companywpuser->other_documents_3_title }}</div>
						<div class="col-md-7"><p><a target="_blank" href="{{ url('public/uploads/'.$company->wpusers[0]->user_login.'/'.$companywpuser->other_documents_3) }}">{{ $companywpuser->other_documents_3 }}</a></p></div>
					</div>
					@endif
					@if(!empty($companywpuser->other_documents_4_title))
					<div class="row">
						<div class="col-md-3">{{ $companywpuser->other_documents_4_title }}</div>
						<div class="col-md-7"><p><a target="_blank" href="{{ url('public/uploads/'.$company->wpusers[0]->user_login.'/'.$companywpuser->other_documents_4) }}">{{ $companywpuser->other_documents_4 }}</a></p></div>
					</div>
					@endif
					@if(!empty($companywpuser->other_documents_5_title))
					<div class="row">
						<div class="col-md-3">{{ $companywpuser->other_documents_5_title }}</div>
						<div class="col-md-7"><p><a target="_blank" href="{{ url('public/uploads/'.$company->wpusers[0]->user_login.'/'.$companywpuser->other_documents_5) }}">{{ $companywpuser->other_documents_5 }}</a></p></div>
					</div>
					@endif
					@if(!empty($companywpuser->other_documents_6_title))
					<div class="row">
						<div class="col-md-3">{{ $companywpuser->other_documents_6_title }}</div>
						<div class="col-md-7"><p><a target="_blank" href="{{ url('public/uploads/'.$company->wpusers[0]->user_login.'/'.$companywpuser->other_documents_6) }}">{{ $companywpuser->other_documents_6 }}</a></p></div>
					</div>
					@endif								

					<div class="space50"></div>										
				</div>
			</div>
		</div>
	</div>
	<script>
		$(".print").on("click", function(e){
			window.print();
		});
	</script>
@endsection