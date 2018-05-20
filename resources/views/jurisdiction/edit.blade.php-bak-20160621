@extends('layouts.master')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="space50"></div>
			<h1>Edit a company type</h1>
			<a href="{{ route('admin.jurisdiction.index') }}"><button class="custom-submit-class">Return to company types</button></a>
				
			<div class="space50"></div>
			
			<div class="form-container">
				{{ Form::open([ 'route' => ['admin.jurisdiction.update', $company_type->id ], 'method' => 'put' ]) }}
					<div class="field-container">
						{{ Form::label('company_type_name', 'Company type')}}
						{{ Form::text('company_type_name', $company_type->name, ['class'=>'custom-input-class']) }}
					</div>
					<div class="field-container">
						{{ Form::label('company_name_rules', 'Company name rules')}}
						{{ Form::textarea('company_name_rules', $company_type->rules, ['class'=>'custom-input-class']) }}
					</div>
					{{ Form::hidden('shareholder_id', $company_type->shareholders[0]->id) }}
					<div class="field-container">
						{{ Form::label('shareholder_name_rules', 'Shareholder rules')}}
						{{ Form::textarea('shareholder_name_rules', $company_type->shareholders[0]->name_rules, ['class'=>'custom-input-class']) }}
					</div>
					{{ Form::hidden('director_id', $company_type->directors[0]->id) }}
					<div class="field-container">
						{{ Form::label('director_name_rules', 'Director rules')}}
						{{ Form::textarea('director_name_rules', $company_type->directors[0]->name_rules, ['class'=>'custom-input-class']) }}
					</div>
					{{ Form::hidden('secretary_id', $company_type->secretaries[0]->id) }}
					<div class="field-container">
						{{ Form::label('secretary_name_rules', 'Secretary rules')}}
						{{ Form::textarea('secretary_name_rules', $company_type->secretaries[0]->name_rules, ['class'=>'custom-input-class']) }}
					</div>

					<div class="field-container">
						{{ Form::label('service_3_price_eu_1', 'Incorporation charge €')}}
						{{ Form::text('service_3_price_eu_1', $company_type->price_eu, ['class'=>'custom-input-class service_prices_eu']) }}
					</div>					
					<div class="field-container">
						{{ Form::label('service_3_price_1', 'Incorporation charge $')}}
						{{ Form::text('service_3_price_1', $company_type->price, ['class'=>'custom-input-class service_prices']) }}
					</div>

					{{ Form::hidden('service_3_id', $company_type->services[0]->id) }}
					{{ Form::hidden('service_3_name', 'Registered office annual fee (compulsory)') }}
					{{ Form::hidden('service_3_country_1', '2') }}

					<div class="field-container">
						{{ Form::label('service_3_price_eu_1', 'Registered office fee €')}}
						{{ Form::text('service_3_price_eu_1', $company_type->services[0]->countries[0]->pivot->price_eu, ['class'=>'custom-input-class service_prices_eu']) }}
					</div>					
					<div class="field-container">
						{{ Form::label('service_3_price_1', 'Registered office fee $')}}
						{{ Form::text('service_3_price_1', $company_type->services[0]->countries[0]->pivot->price, ['class'=>'custom-input-class service_prices']) }}
					</div>	

					<div class="field-container">
						{{ Form::label('shareholder_price_eu', 'Shareholder fee €')}}
						{{ Form::text('shareholder_price_eu', $company_type->shareholders[0]->price_eu, ['class'=>'custom-input-class']) }}
					</div>
					<div class="field-container">
						{{ Form::label('shareholder_price', 'Shareholder fee $')}}
						{{ Form::text('shareholder_price', $company_type->shareholders[0]->price, ['class'=>'custom-input-class']) }}
					</div>						
					<div class="field-container">
						{{ Form::label('director_price_eu', 'Director fee €')}}
						{{ Form::text('director_price_eu', $company_type->directors[0]->price_eu, ['class'=>'custom-input-class']) }}
					</div>		
					<div class="field-container">
						{{ Form::label('director_price', 'Director fee $')}}
						{{ Form::text('director_price', $company_type->directors[0]->price, ['class'=>'custom-input-class']) }}
					</div>								
					<div class="field-container">
						{{ Form::label('secretary_price_eu', 'Secretary fee €')}}
						{{ Form::text('secretary_price_eu', $company_type->secretaries[0]->price_eu, ['class'=>'custom-input-class']) }}
					</div>
					<div class="field-container">
						{{ Form::label('secretary_price', 'Secretary fee $')}}
						{{ Form::text('secretary_price', $company_type->secretaries[0]->price, ['class'=>'custom-input-class']) }}
					</div>
					
					<div class="each-service">
						<h3 class="form-header">Bank accounts</h3>
						{{ Form::hidden('service_1_id', $company_type->services[1]->id) }}
						{{ Form::hidden('service_1_name', 'Bank accounts') }}
						
						@foreach($company_type->services[1]->countries as $key => $country)
							@if ($country == $company_type->services[1]->countries->last()) <div id="cloneable"> @endif

								{{ Form::hidden('service_1_country_'.intval($key+1).'_id', $country->pivot->id) }}
								<div class="field-group">												
									<div class="field-container">
										{{ Form::label('service_1_country_'.intval($key+1), 'Bank location')}}
										<div class="custom-input-class-select-container">																				
											{{ Form::select('service_1_country_'.intval($key+1), $countries, $country->pivot->country_id, ['class' => 'custom-input-class service_countries']) }}
										</div>
									</div>		
									<div class="field-container">
										{{ Form::label('service_1_price_eu_'.intval($key+1), 'Account fee €')}}
										{{ Form::text('service_1_price_eu_'.intval($key+1), $country->pivot->price_eu, ['class'=>'custom-input-class service_prices_eu']) }}
									</div>					
									<div class="field-container">
										{{ Form::label('service_1_price_'.intval($key+1), 'Account fee $')}}
										{{ Form::text('service_1_price_'.intval($key+1), $country->pivot->price, ['class'=>'custom-input-class service_prices']) }}
									</div>								
								</div>
							@if ($country == $company_type->services[1]->countries->last()) </div><!-- end cloneable--> @endif							
						@endforeach
						<div class="pasteclone"></div>

						{{ Form::hidden('service_1_count', count($company_type->services[1]->countries), ['id'=>'service_1_count']) }}
						<a href="#" class="add-more" data-service="service_1"><button class="custom-submit-class">Add another bank account</button></a>
					</div>
					
					<div class="each-service">
						<h3 class="form-header">Credit/debit cards</h3>
						{{ Form::hidden('service_2_id', $company_type->services[2]->id) }}
						{{ Form::hidden('service_2_name', 'Credit/debit cards', ['class'=>'custom-input-class']) }}
						
						@foreach($company_type->services[2]->countries as $key => $country)
							@if ($country == $company_type->services[2]->countries->last()) <div id="cloneable"> @endif
								
								{{ Form::hidden('service_2_country_'.intval($key+1).'_id', $country->pivot->id) }}
								<div class="field-group">												
									<div class="field-container">
										{{ Form::label('service_2_country_'.intval($key+1), 'Bank location')}}
										<div class="custom-input-class-select-container">										
											{{ Form::select('service_2_country_'.intval($key+1), $countries, $country->pivot->country_id, ['class' => 'custom-input-class service_countries']) }}
										</div>
									</div>							
									<div class="field-container">
										{{ Form::label('service_2_price_'.intval($key+1), 'Card fee $')}}
										{{ Form::text('service_2_price_'.intval($key+1), $country->pivot->price_eu, ['class'=>'custom-input-class service_prices']) }}
									</div>
									<div class="field-container">
										{{ Form::label('service_2_price_eu_'.intval($key+1), 'Card fee €')}}
										{{ Form::text('service_2_price_eu_'.intval($key+1), $country->pivot->price, ['class'=>'custom-input-class service_prices_eu']) }}
									</div>
								</div>
							@if ($country == $company_type->services[2]->countries->last()) </div><!-- end cloneable--> @endif							
						@endforeach
						<div class="pasteclone"></div>

						{{ Form::hidden('service_2_count', count($company_type->services[2]->countries), ['id'=>'service_2_count']) }}
						<a href="#" class="add-more" data-service="service_2"><button class="custom-submit-class">Add another card</button></a>
					</div>					

					<!--<div class="each-service">
						<h3 class="form-header">Information services</h3>
						
						@foreach($company_type->informationservices as $key => $informationservice)
							@if ($informationservice == $company_type->informationservices->last()) <div id="cloneable"> @endif
								<div class="field-group">
									<div class="field-container">
										{{ Form::hidden('information_service_'.intval($key+1).'_id', $informationservice->id) }}
										{{ Form::label('information_service_'.intval($key+1), 'Information services name')}}										
										{{ Form::text('information_service_'.intval($key+1), $informationservice->name, ['class'=>'custom-input-class information_services']) }}
									</div>
								</div>
							@if ($informationservice == $company_type->informationservices->last()) </div>@endif
						@endforeach
						<div class="pasteclone"></div>

						{{ Form::hidden('information_service_count', count($company_type->informationservices), ['id'=>'information_service_count']) }}
						<a href="#" class="add-more" data-service="information_service"><button class="custom-submit-class">Add information service</button></a>
					</div>-->
					
					{{ Form::submit('Save', ['class'=>'custom-submit-class']) }}
			{!! Form::close() !!}
			</div>

		</div>
	</div>
</div>
<script>
	function cloneForm($el) {
		var clonedHtml = $el.clone();

		$el.parent().parent().find('.pasteclone').append(clonedHtml);
	}
	function updateHiddenField(serviceName, $this) {	
		if(serviceName=="information_service") {

			console.log($this.parent().find('.information_services').length);
			console.log('#'+serviceName+'_count')

			$('#'+serviceName+'_count').val($this.parent().find('.information_services').length);	
		}else {

			// console.log($this.parent().find('.service_countries').length);
			// console.log('#'+serviceName+'_count')

			$('#'+serviceName+'_count').val($this.parent().find('.service_countries').length);	
		}		
	}
	function updateClonedFields(serviceName, $this) {
		var id = parseInt($this.parent().find('.field-group').length);

		console.log(id);

		var $lastElAdded = $this.parent().find('.field-group').last();

		if(serviceName=="information_service") {
			$lastElAdded.find('input').attr('name', serviceName+'_'+id).val('');			
		}else {
			$lastElAdded.find('select').attr('name', serviceName+'_country_'+id).val('');
			$lastElAdded.find('input.service_prices').attr('name', serviceName+'_price_'+id).val('');			
			$lastElAdded.find('input.service_prices_eu').attr('name', serviceName+'_price_eu_'+id).val('');			
		}		
	}

	$('.add-more').on('click', function(e){
		e.preventDefault();


		var serviceName = $(this).data('service');

		cloneForm($(this).parent('.each-service').children('#cloneable').find('.field-group'));
		updateClonedFields(serviceName, $(this));
		updateHiddenField(serviceName, $(this));

	});
</script>
@endsection