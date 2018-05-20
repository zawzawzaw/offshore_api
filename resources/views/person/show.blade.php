@extends('layouts.master')

@section('content')	
	
	<div class="container">
		<div class="row">
			<div class="col-md-8">				
				<div class="space50"></div>
				<div class="row heading">
					<div class="col-md-12">
						<h1>View person details</h1>				
						<a href="javascript:void(0);" class="print"><button class="custom-submit-class">Print</button></a>		
						<a href="{{ route('officiumtutus.person.index') }}"><button class="custom-submit-class">Back to person database</button></a>

						<div class="space50"></div>
					</div>
				</div>
				<div id="edit_client">
					<div class="labels">
						<input type="hidden" name="person_role" value="{{ $person->person_role }}">
						<div class="row">
							<div class="col-md-4"><p>Person code</p></div>
							<div class="col-md-8">{{ $person->person_code }}</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Person type</p></div>
							<div class="col-md-8">
								@if($person->person_type==1)
									<span>{{ "Individual" }}</span>
    						@else
									<span>{{ "Company" }}</span>
    						@endif
							</div>
						</div>			
						@if($person->person_type==2)
						<div class="row company-only">
							<div class="col-md-4"><p>Company name</p></div>
							<div class="col-md-8">{{ $person->third_party_company_name }}</div>
						</div>
						<div class="row company-only">
							<div class="col-md-4"><p>Jurisdiction</p></div>
							<div class="col-md-8">{{ $person->third_party_company_jurisdiction }}</div>
						</div>
						<div class="row company-only">
							<div class="col-md-4"><p>Company registration number</p></div>
							<div class="col-md-8">{{ $person->third_party_company_reg_no }}</div>
						</div>		
						@endif						
						<div class="row">
							<div class="col-md-4"><p>Title</p></div>
							<div class="col-md-8">
							@if($person->title==1)
								{{ "Mr" }}
							@elseif($person->title==2)
								{{ "Mrs" }}
							@elseif($person->title==3)
								{{ "Ms" }}
							@elseif($person->title==4)
								{{ "Miss" }}
							@endif
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>First name</p></div>
							<div class="col-md-8">{{ $person->first_name }}</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Surname</p></div>
							<div class="col-md-8">{{ $person->surname }}</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Nationality</p></div>
							<div class="col-md-8">
								{{ $person->nationality }}							
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Passport number</p></div>
							<div class="col-md-8">{{ $person->passport_no }}</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Passport expiry</p></div>
							<div class="col-md-8">{{ (strtotime($person->passport_expiry) <= 0) ? "" : date('d M Y', strtotime($person->passport_expiry)) }}</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Tax residence</p></div>
							<div class="col-md-8">{{ $person->tax_residence }}</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Tax number</p></div>
							<div class="col-md-8">{{ $person->tax_number }}</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Email</p></div>
							<div class="col-md-8">{{ $person->email }}</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Mobile telephone</p></div>
							<div class="col-md-8">{{ $person->mobile_telephone }}</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Business telephone</p></div>
							<div class="col-md-8">{{ $person->work_telephone }}</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Home telephone</p></div>
							<div class="col-md-8">{{ $person->home_telephone }}</div>
						</div>
						<fieldset>
							<legend>Home address</legend>
							<div class="row">
								<div class="col-md-4"><p>Line 1</p></div>
								<div class="col-md-8">{{ $person->home_address }}</div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>Line 2</p></div>
								<div class="col-md-8">{{ $person->home_address_2 }}</div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>City</p></div>
								<div class="col-md-8">{{ $person->home_address_3 }}</div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>Postcode</p></div>
								<div class="col-md-8">{{ $person->home_address_5 }}</div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>Country</p></div>
								<div class="col-md-8">{{ $person->home_address_6 }}</div>
							</div>
						</fieldset>		
						<fieldset>
							<legend>Postal address</legend>				
							<div class="row">
								<div class="col-md-4"><p>Line 1</p></div>
								<div class="col-md-8">{{ $person->postal_address }}</div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>Line 2</p></div>
								<div class="col-md-8">{{ $person->postal_address_2 }}</div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>City</p></div>
								<div class="col-md-8">{{ $person->postal_address_3 }}</div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>Postcode</p></div>
								<div class="col-md-8">{{ $person->postal_address_5 }}</div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>Country</p></div>
								<div class="col-md-8">{{ $person->postal_address_6 }}</div>
							</div>
						</fieldset>
						<div class="row">
							<div class="col-md-4"><p>Preferred currency </p></div>
							<div class="col-md-8">
								{{ $person->preferred_currency }}								
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Account registered</p></div>
							<div class="col-md-8">{{ (strtotime($person->account_registered) <= 0) ? "" : date('d M Y', strtotime($person->account_registered)) }}</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Login IP at registration</p></div>
							<div class="col-md-8"><p>{{ $person->login_ip }}</p></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Relationship commenced </p></div>
							<div class="col-md-8">{{ (strtotime($person->relationship_commenced) <= 0) ? "" : date('d M Y', strtotime($person->relationship_commenced)) }}</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Relationship ended </p></div>
							<div class="col-md-8">{{ (strtotime($person->relationship_ended) <= 0) ? "" : date('d M Y', strtotime($person->relationship_ended)) }}</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								@if($person->person_type==1)
									<p>Passport copy</p>
								@else
									<p>Incorporation certificate</p>
								@endif
							</div>
							<?php if(!empty($person->person_code)): $path = $person->person_code; else: $path = 'person'; endif; ?>
							<div class="col-md-8"><a target="_blank" href="{{ url('public/uploads/'.$path.'/'.$person->passport_copy) }}">{{ $person->passport_copy }}</a></div>
						</div>
						<div class="row">
							<div class="col-md-4">
								@if($person->person_type==1)
									<p>Proof of address</p>
								@else
									<p>Incumbency certificate</p>
								@endif
							</div>
							<?php if(!empty($person->person_code)): $path = $person->person_code; else: $path = 'person'; endif; ?>
							<div class="col-md-8"><a target="_blank" href="{{ url('public/uploads/'.$path.'/'.$person->proof_of_address) }}">{{ $person->proof_of_address }}</a></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Bank reference</p></div>
							<?php if(!empty($person->person_code)): $path = $person->person_code; else: $path = 'person'; endif; ?>
							<div class="col-md-8"><a target="_blank" href="{{ url('public/uploads/'.$path.'/'.$person->bank_reference) }}">{{ $person->bank_reference }}</a></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Professional reference</p></div>
							<?php if(!empty($person->person_code)): $path = $person->person_code; else: $path = 'person'; endif; ?>
							<div class="col-md-8"><a target="_blank" href="{{ url('public/uploads/'.$path.'/'.$person->professional_reference) }}">{{ $person->professional_reference }}</a></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Notes</p></div>
							<div class="col-md-8">{{ $person->notes }}</div>
						</div>
					</div>	
				</div>

				<div class="space50"></div>
			</div>
		</div>
	</div>
	<script>
		$(".print").on("click", function(e){
			window.print();
		});
	</script>
@endsection