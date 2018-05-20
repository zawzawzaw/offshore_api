@extends('layouts.master')

@section('content')	
	
	<div class="container">
		<div class="row">
			<div class="col-md-8">				
				<div class="space50"></div>

				<h1>Edit person details</h1>				
				{{ Form::open(['route' => ['officiumtutus.person.destroy', $person->id], 'method' => 'delete', 'style' => 'display:inline-block;']) }}		
					<button type="submit" class="remove-record custom-submit-class">Delete record</button>
				{{ Form::close() }}
				<a href="{{ route('officiumtutus.person.index') }}"><button class="custom-submit-class">Back to person database</button></a>

				{{ Form::open([ 'route' => ['officiumtutus.person.update', $person->id ], 'method' => 'put', 'id' => 'edit_client' ]) }}	
					<div class="space50"></div>
					<div class="labels">
						<input type="hidden" name="person_role" value="{{ $person->person_role }}">
						<div class="row">
							<div class="col-md-4"><p>Person code</p></div>
							<div class="col-md-8"><input type="text" name="person_code" value="{{ $person->person_code }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Person type</p></div>
							<div class="col-md-8">
								{!! Form::select('person_type', [
								   1 => 'Individual',
								   2 => 'Company'
								], $person->person_type, array("id" => "person_type")) !!}		
							</div>
						</div>			
						<div class="row company-only">
							<div class="col-md-4"><p>Company name</p></div>
							<div class="col-md-8"><input type="text" name="third_party_company_name" value="{{ $person->third_party_company_name }}"></div>
						</div>
						<div class="row company-only">
							<div class="col-md-4"><p>Jurisdiction</p></div>
							<div class="col-md-8">
								{!! Form::select('third_party_company_jurisdiction', $countryList, $person->third_party_company_jurisdiction) !!}
							</div>
						</div>
						<div class="row company-only">
							<div class="col-md-4"><p>Company registration number</p></div>
							<div class="col-md-8">
								<input type="text" name="third_party_company_reg_no" value="{{ $person->third_party_company_reg_no }}">
							</div>
						</div>								
						<div class="row person-only">
							<div class="col-md-4"><p>Title</p></div>
							<div class="col-md-8">
								{!! Form::select('title', [
                   '' => '...',
								   1 => 'Mr',
								   2 => 'Mrs',
								   3 => 'Ms',
								   4 => 'Miss'
								], $person->title, array("id" => "title")) !!}
							</div>
						</div>
						<div class="row person-only">
							<div class="col-md-4"><p>First name</p></div>
							<div class="col-md-8"><input type="text" name="first_name" value="{{ $person->first_name }}"></div>
						</div>
						<div class="row person-only">
							<div class="col-md-4"><p>Surname</p></div>
							<div class="col-md-8"><input type="text" name="surname" value="{{ $person->surname }}"></div>
						</div>
						<div class="row person-only">
							<div class="col-md-4"><p>Nationality</p></div>
							<div class="col-md-8">
							{!! Form::select('nationality', $countryList, $person->nationality) !!}
							</div>
						</div>
						<div class="row person-only">
							<div class="col-md-4"><p>Passport number</p></div>
							<div class="col-md-8"><input type="text" name="passport_no" value="{{ $person->passport_no }}"></div>
						</div>
						<div class="row person-only">
							<div class="col-md-4"><p>Passport expiry</p></div>
							<div class="col-md-8"><input type="text" id="passport_expiry" name="passport_expiry" class="date-input" placeholder="dd/mm/yyyy" value="{{ (strtotime($person->passport_expiry) <= 0) ? "" : date('d/m/Y', strtotime($person->passport_expiry)) }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Tax residence</p></div>
							<div class="col-md-8">								
								{!! Form::select('tax_residence', $countryList, $person->tax_residence) !!}
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Tax number</p></div>
							<div class="col-md-8"><input type="text" name="tax_number" value="{{ $person->tax_number }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Email</p></div>
							<div class="col-md-8"><input type="text" name="email" value="{{ $person->email }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Mobile telephone</p></div>
							<div class="col-md-8"><input type="text" name="mobile_telephone" class="telephone mobile-telephone" value="{{ $person->mobile_telephone }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Business telephone</p></div>
							<div class="col-md-8"><input type="text" name="work_telephone" class="telephone work-telephone" value="{{ $person->work_telephone }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Home telephone</p></div>
							<div class="col-md-8"><input type="text" name="home_telephone" class="telephone home-telephone" value="{{ $person->home_telephone }}"></div>
						</div>
						<fieldset>
							<legend>Home address</legend>
							<div class="row">
								<div class="col-md-4"><p>Line 1</p></div>
								<div class="col-md-8"><input type="text" name="home_address" value="{{ $person->home_address }}"></div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>Line 2</p></div>
								<div class="col-md-8"><input type="text" name="home_address_2" value="{{ $person->home_address_2 }}"></div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>City</p></div>
								<div class="col-md-8"><input type="text" name="home_address_3" value="{{ $person->home_address_3 }}"></div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>Postcode</p></div>
								<div class="col-md-8"><input type="text" name="home_address_5" value="{{ $person->home_address_5 }}"></div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>Country</p></div>
								<div class="col-md-8">{!! Form::select('home_address_6', $countryList, $person->home_address_6) !!}</div>
							</div>
						</fieldset>		
						<fieldset>
							<legend>Postal address</legend>				
							<div class="row">
								<div class="col-md-4"><p>Line 1</p></div>
								<div class="col-md-8"><input type="text" name="postal_address" value="{{ $person->postal_address }}"></div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>Line 2</p></div>
								<div class="col-md-8"><input type="text" name="postal_address_2" value="{{ $person->postal_address_2 }}"></div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>City</p></div>
								<div class="col-md-8"><input type="text" name="postal_address_3" value="{{ $person->postal_address_3 }}"></div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>Postcode</p></div>
								<div class="col-md-8"><input type="text" name="postal_address_5" value="{{ $person->postal_address_5 }}"></div>
							</div>
							<div class="row">
								<div class="col-md-4"><p>Country</p></div>
								<div class="col-md-8">{!! Form::select('postal_address_6', $countryList, $person->postal_address_6) !!}</div>
							</div>
						</fieldset>
						<div class="row">
							<div class="col-md-4"><p>Preferred currency </p></div>
							<div class="col-md-8">
								{!! Form::select('preferred_currency', [
									'US dollars (US$)' => 'US dollars (US$)', 
									'Euro (€)' => 'Euro (€)'
								], $person->preferred_currency) !!}								
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Account registered</p></div>
							<div class="col-md-8"><p>{{ (strtotime($person->account_registered) <= 0) ? $person->account_registered : date('d/m/Y', strtotime($person->account_registered)) }}</p></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Login IP at registration</p></div>
							<div class="col-md-8"><p>{{ $person->login_ip }}</p></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Relationship commenced</p></div>
							<div class="col-md-8"><input type="text" id="relationship_commenced" name="relationship_commenced" class="date-input" placeholder="dd/mm/yyyy" value="{{ (strtotime($person->relationship_commenced) <= 0) ? "" : date('d/m/Y', strtotime($person->relationship_commenced)) }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Relationship ended</p></div>
							<div class="col-md-8"><input type="text" id="relationship_ended" name="relationship_ended" class="date-input" placeholder="dd/mm/yyyy" value="{{ (strtotime($person->relationship_ended) <= 0) ? "" : date('d/m/Y', strtotime($person->relationship_ended)) }}"></div>
						</div>
						<div class="row">
							<div class="col-md-4"><p class="passport_change_label_on_person_type" data-lbl-company="Incorporation certificate" data-lbl-person="Passport copy">Passport copy</p></div>
							<div class="col-md-8">
								<input type="hidden" name="passport_copy" value="{{ $person->passport_copy }}">								
                <span class="btn fileinput-button">
                    <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Passport copy uploaded">Upload file</button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input class="pdf_upload" type="file" name="files" data-fieldname="passport_copy" />
                </span>
                <!-- The container for the uploaded files -->
                <div id="passport_copy_files" class="pdf_files files"><p>{{ $person->passport_copy }}</p></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p class="proof_change_label_on_person_type" data-lbl-company="Incumbency certificate" data-lbl-person="Proof of address">Proof of address</p></div>
							<div class="col-md-8">
								<input type="hidden" name="proof_of_address" value="{{ $person->proof_of_address }}">		
                <span class="btn fileinput-button">
                    <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Proof of address uploaded">Upload file</button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input class="pdf_upload" type="file" name="files" data-fieldname="proof_of_address" />
                </span>
                <!-- The container for the uploaded files -->
                <div id="proof_of_address_files" class="pdf_files files"><p>{{ $person->proof_of_address }}</p></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Bank reference</p></div>
							<div class="col-md-8">
								<input type="hidden" name="bank_reference" value="{{ $person->bank_reference }}">
                <span class="btn fileinput-button">
                    <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Bank reference uploaded">Upload file</button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input class="pdf_upload" type="file" name="files" data-fieldname="bank_reference" />
                </span>
                <!-- The container for the uploaded files -->
                <div id="bank_reference_files" class="pdf_files files"><p>{{ $person->bank_reference }}</p></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Professional reference</p></div>
							<div class="col-md-8">
								<input type="hidden" name="professional_reference" value="{{ $person->professional_reference }}">
                <span class="btn fileinput-button">
                    <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Professional reference uploaded">Upload file</button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input class="pdf_upload" type="file" name="files" data-fieldname="professional_reference" />
                </span>
                <!-- The container for the uploaded files -->
                <div id="professional_reference_files" class="pdf_files files"><p>{{ $person->professional_reference }}</p></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"><p>Notes</p></div>
							<div class="col-md-8"><textarea name="notes" id="notes" cols="60" rows="30">{{ $person->notes }}</textarea></div>
						</div>
					</div>
					{{ Form::submit('Save', ['id'=>'save-btn', 'class'=>'custom-submit-class']) }}
				{{ Form::close() }}
				
				<div class="space50"></div>

			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){

			// $('#passport_expiry').datepicker({ dateFormat: 'dd M yy', startDate: '+1d' });
			// $('#account_registered').datepicker({ dateFormat: 'dd M yy', startDate: '+1d' });
			// $('#relationship_commenced').datepicker({ dateFormat: 'dd M yy', startDate: '+1d' });
			// $('#relationship_ended').datepicker({ dateFormat: 'dd M yy', startDate: '+1d' });


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

			$('#person_type').on("change", function(e){
				var person_type = $(this).val();
				if(person_type==1) {
					$('.company-only').hide();
					$('.person-only').show();
					var passport = $('.passport_change_label_on_person_type').data('lbl-person');					
					var proof = $('.proof_change_label_on_person_type').data('lbl-person');					
					$('.passport_change_label_on_person_type').text(passport);
					$('.proof_change_label_on_person_type').text(proof);
				}else {
					$('.company-only').show();
					$('.person-only').hide();
					var passport = $('.passport_change_label_on_person_type').data('lbl-company');				
					var proof = $('.proof_change_label_on_person_type').data('lbl-company');					
					$('.passport_change_label_on_person_type').text(passport);
					$('.proof_change_label_on_person_type').text(proof);
				}
			});
			$('#person_type').trigger("change");

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
              formData: { "user_name" : "{{ $person->person_code }}" },
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

      initFileUpload($(".pdf_upload"));

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
          if($selector.val()=="") {
            $.getJSON("https://ipinfo.io?token=375d0ebf3cc60d", function(data){
                country = data.country;
                $selector.intlTelInput("setCountry", country);  
            });              
          }
      }

      initInputTel($(".mobile-telephone"));
      initInputTel($(".work-telephone"));
      initInputTel($(".home-telephone"));

      $("#save-btn").on("click", function(e){
      	e.preventDefault();

      	if($('#person_type').val()==1) {
      		$('.company-only').find('input').val("");
      		$('.company-only').find('select').val("");
      	}else {
      		$('.person-only').find('input').val("");
      		$('.person-only').find('select').val("");
      	}

      	$("#edit_client").submit();
      });

      $(".remove-record").on("click", function(e){
	    	e.preventDefault();
	    	if (confirm("Are you sure you want to delete?")) {
	    		$(this).parent('form').submit();
	    	}	
	    });

      // $("select[name=nationality]").prepend("<option value=''>Please select</option>");
      // $("select[name=tax_residence]").prepend("<option value=''>Please select</option>");
			
		});
	</script>

@endsection