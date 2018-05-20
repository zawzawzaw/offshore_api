@extends('layouts.master')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="space50"></div>
			<h1>Add a shelf company</h1>
			<a href="{{ route('officiumtutus.company.index') }}"><button class="custom-submit-class">Return to shelf companies list</button></a>
			<div class="space50"></div>
			
			<div class="form-container">
				{!! Form::open(array('route' => 'officiumtutus.company.store', 'id' => 'add_company')) !!}
					<div class="field-container">
						{{ Form::label('company_type', 'Company type')}}
						<div class="custom-input-class-select-container">
							{{ Form::select('company_type', $company_types, null, ['class'=>'custom-input-class']) }}
						</div>
					</div>					
					<div class="field-container">
						{{ Form::label('code', 'Code')}}
						{{ Form::text('code', null, ['class'=>'custom-input-class']) }}
					</div>
					<div class="field-container">
						{{ Form::label('company_name', 'Company name')}}
						{{ Form::text('company_name', null, ['class'=>'custom-input-class']) }}
					</div>
					<div class="field-container">
						{{ Form::label('company_incorporation_date', 'Incorporated')}}
						{{ Form::text('company_incorporation_date', null, ['class'=>'custom-input-class date-input', 'placeholder'=>'dd/mm/yyyy']) }}
					</div>
					<div class="field-container">
						{{ Form::label('company_price_eu', 'Price €')}}
						{{ Form::text('company_price_eu', null, ['class'=>'custom-input-class']) }}
					</div>					
					<div class="field-container">
						{{ Form::label('company_price', 'Price $')}}
						{{ Form::text('company_price', null, ['class'=>'custom-input-class']) }}
					</div>										

					{{ Form::submit('Save', ['class'=>'custom-submit-class']) }}
				{!! Form::close() !!}
			</div>

		</div>
	</div>
</div>

<script>
	$(document).ready(function(){

		// function populate_fields(index, shareholder_id) {		
		// 	$('.populate-shareholder-fields').append('<div class="field-container"><input type="text" name="shareholder_'+shareholder_id+'_share_amount" placeholder="Shareholder '+(parseInt(index)+1)+' share amount" class="custom-input-class" /></div>')
		// }

		// $('#shareholder').on('change', function(e){
		// 	var shareholder_ids_arr = $(this).val();
			
		// 	$('.populate-shareholder-fields').html('');
		// 	$.each(shareholder_ids_arr, function(index, shareholder_id){
		// 		populate_fields(index, shareholder_id);
		// 	});
		// });

		// $('#company_incorporation_date').datepicker({ dateFormat: 'dd/mm/y' });

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

		$('#add_company').validate({
			rules : {
				'code': {
					'required': true,
					'code': true
				},
				'company_type': 'required',
				'company_name': 'required',
				'company_incorporation_date': 'required',
				'company_price_eu': 'required',
				'company_price': 'required'
			}
		});

		$.validator.addMethod("code", function (value, element) 
        {
            return this.optional(element) || /^[A-Z]{2}[0-9]{4}$/.test(value);
        }, "Invalid code");
	});
</script>

@endsection