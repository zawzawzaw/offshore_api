@extends('layouts.master')

@section('content')
<style>
	input[type="text"] {
    width: 250px;
    height: 30px;
    font-size: 12px;
    padding-left: 5px;
	}
</style>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="space50"></div>
			<h1>Add a person</h1>
			<a href="{{ route('officiumtutus.person.index') }}"><button class="custom-submit-class">Return to person database</button></a>
			<div class="space50"></div>

			<div class="form-container">
				{{ Form::open([ 'route' => ['officiumtutus.person.store'], 'id' => 'add_client' ]) }}	
					<div class="space50"></div>
					<div class="labels">
						<div class="row">
							<div class="col-md-5"><p>Person code</p></div>
							<div class="col-md-7"><input type="text" name="person_code" value=""></div>
						</div>
						<div class="row">
							<div class="col-md-5"><p>Person type</p></div>
							<div class="col-md-7">
								<select name="person_type" id="person_type">
									<option value="1">Individual</option>
									<option value="2">Company</option>
								</select>
							</div>
						</div>
						<div class="row company-only">
							<div class="col-md-5"><p>Company name</p></div>
							<div class="col-md-7"><input type="text" name="third_party_company_name" value=""></div>
						</div>
						<div class="row company-only">
							<div class="col-md-5"><p>Jurisdiction</p></div>
							<div class="col-md-7">
								{!! Form::select('third_party_company_jurisdiction', $countryList) !!}
							</div>
						</div>
						<div class="row company-only">
							<div class="col-md-5"><p>Company registration number</p></div>
							<div class="col-md-7"><input type="text" name="third_party_company_reg_no" value=""></div>
						</div>
						<div class="row person-only">
							<div class="col-md-5"><p>Title</p></div>
							<div class="col-md-7">
                {!! Form::select('title', [
                   '' => '...',
                   1 => 'Mr',
                   2 => 'Mrs',
                   3 => 'Ms',
                   4 => 'Miss'
                ], "", array("id" => "title")) !!}
              </div>
						</div>
						<div class="row person-only">
							<div class="col-md-5"><p>First name</p></div>
							<div class="col-md-7"><input type="text" name="first_name" value=""></div>
						</div>
						<div class="row person-only">
							<div class="col-md-5"><p>Surname</p></div>
							<div class="col-md-7"><input type="text" name="surname" value=""></div>
						</div>
						<div class="row person-only">
							<div class="col-md-5"><p>Nationality</p></div>
							<div class="col-md-7">
								{!! Form::select('nationality', $countryList) !!}
							</div>
						</div>
						<div class="row person-only">
							<div class="col-md-5"><p>Passport number</p></div>
							<div class="col-md-7"><input type="text" name="passport_no" value=""></div>
						</div>
						<div class="row person-only">
							<div class="col-md-5"><p>Passport expiry</p></div>
							<div class="col-md-7"><input type="text" name="passport_expiry" class="date-input" placeholder="dd/mm/yyyy" value="" id="passport_expiry"></div>
						</div>
						<div class="row">
							<div class="col-md-5"><p>Tax residence</p></div>
							<div class="col-md-7">{!! Form::select('tax_residence', $countryList) !!}</div>
						</div>
						<div class="row">
							<div class="col-md-5"><p>Tax number</p></div>
							<div class="col-md-7"><input type="text" name="tax_number" value=""></div>
						</div>
						<div class="row">
							<div class="col-md-5"><p>Email</p></div>
							<div class="col-md-7"><input type="text" name="email" value=""></div>
						</div>
						<div class="row">
							<div class="col-md-5"><p>Mobile telephone</p></div>
							<div class="col-md-7"><input type="text" name="mobile_telephone" class="mobile-telephone telephone" value=""></div>
						</div>
						<div class="row">
							<div class="col-md-5"><p>Business telephone</p></div>
							<div class="col-md-7"><input type="text" name="work_telephone" class="work-telephone telephone" value=""></div>
						</div>
						<div class="row">
							<div class="col-md-5"><p>Home telephone</p></div>
							<div class="col-md-7"><input type="text" name="home_telephone" class="home-telephone telephone" value=""></div>
						</div>
						<fieldset>
							<legend>Home address</legend>
							<div class="row">
								<div class="col-md-5"><p>Line 1</p></div>
								<div class="col-md-7"><input type="text" name="home_address" value=""></div>
							</div>
							<div class="row">
								<div class="col-md-5"><p>Line 2</p></div>
								<div class="col-md-7"><input type="text" name="home_address_2" value=""></div>
							</div>
							<div class="row">
								<div class="col-md-5"><p>City</p></div>
								<div class="col-md-7"><input type="text" name="home_address_3" value=""></div>
							</div>
							<div class="row">
								<div class="col-md-5"><p>Postcode</p></div>
								<div class="col-md-7"><input type="text" name="home_address_5" value=""></div>
							</div>
							<div class="row">
								<div class="col-md-5"><p>Country</p></div>
								<div class="col-md-7">
									{!! Form::select('home_address_6', $countryList) !!}
								</div>
							</div>
						</fieldset>		
						<fieldset>
							<legend>Postal address</legend>				
							<div class="row">
								<div class="col-md-5"><p>Line 1</p></div>
								<div class="col-md-7"><input type="text" name="postal_address" value=""></div>
							</div>
							<div class="row">
								<div class="col-md-5"><p>Line 2</p></div>
								<div class="col-md-7"><input type="text" name="postal_address_2" value=""></div>
							</div>
							<div class="row">
								<div class="col-md-5"><p>City</p></div>
								<div class="col-md-7"><input type="text" name="postal_address_3" value=""></div>
							</div>
							<div class="row">
								<div class="col-md-5"><p>Postcode</p></div>
								<div class="col-md-7"><input type="text" name="postal_address_5" value=""></div>
							</div>
							<div class="row">
								<div class="col-md-5"><p>Country</p></div>
								<div class="col-md-7">
									{!! Form::select('postal_address_6', $countryList) !!}									
								</div>
							</div>
						</fieldset>
						<div class="row">
							<div class="col-md-5"><p>Preferred currency </p></div>
							<div class="col-md-7">
								<select name="preferred_currency" value="">
									<option selected="selected" value="US dollars (US$)">US dollars (US$)</option>
									<option value="Euro (€)">Euro (€)</option>
								</select>
							</div>
						</div>
						{{-- <div class="row">
							<div class="col-md-5"><p>Account registered</p></div>
							<div class="col-md-7"><input type="text" name="account_registered" class="date-input" placeholder="dd/mm/yyyy" value=""></div>
						</div> --}}
						<div class="row">
							<div class="col-md-5"><p>Login IP at registration</p></div>
							<div class="col-md-7"><p></p></div>
						</div>
						<div class="row">
							<div class="col-md-5"><p>Relationship commenced </p></div>
							<div class="col-md-7"><input type="text" name="relationship_commenced" class="date-input" placeholder="dd/mm/yyyy" value=""></div>
						</div>
						<div class="row">
							<div class="col-md-5"><p>Relationship ended </p></div>
							<div class="col-md-7"><input type="text" name="relationship_ended" class="date-input" placeholder="dd/mm/yyyy" value=""></div>
						</div>
						<div class="row">
							<div class="col-md-5"><p class="passport_change_label_on_person_type" data-lbl-company="Incorporation certificate" data-lbl-person="Passport copy">Passport copy</p></div>
							<div class="col-md-7">
								<input type="hidden" name="passport_copy" value="">								
                <span class="btn fileinput-button">
                    <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Passport copy uploaded">Upload file</button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input class="pdf_upload" type="file" name="files" data-fieldname="passport_copy" />
                </span>
                <!-- The container for the uploaded files -->
                <div id="passport_copy_files" class="pdf_files files"><p></p></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-5"><p class="proof_change_label_on_person_type" data-lbl-company="Incumbency certificate" data-lbl-person="Proof of address">Proof of address</p></div>
							<div class="col-md-7">								
								<input type="hidden" name="proof_of_address" value="">		
                <span class="btn fileinput-button">
                    <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Proof of address uploaded">Upload file</button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input class="pdf_upload" type="file" name="files" data-fieldname="proof_of_address" />
                </span>
                <!-- The container for the uploaded files -->
                <div id="proof_of_address_files" class="pdf_files files"><p></p></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-5"><p>Bank reference</p></div>
							<div class="col-md-7">								
								<input type="hidden" name="bank_reference" value="">
                <span class="btn fileinput-button">
                    <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Bank reference uploaded">Upload file</button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input class="pdf_upload" type="file" name="files" data-fieldname="bank_reference" />
                </span>
                <!-- The container for the uploaded files -->
                <div id="bank_reference_files" class="pdf_files files"><p></p></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-5"><p>Professional reference</p></div>
							<div class="col-md-7">
								<input type="hidden" name="professional_reference" value="">
                <span class="btn fileinput-button">
                    <button class="upload-pdf-btn custom-submit-class custom-submit-class-2" data-btn-text="Professional reference uploaded">Upload file</button>
                    <!-- The file input field used as target for the file upload widget -->
                    <input class="pdf_upload" type="file" name="files" data-fieldname="professional_reference" />
                </span>
                <!-- The container for the uploaded files -->
                <div id="professional_reference_files" class="pdf_files files"><p></p></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-5"><p>Notes</p></div>
							<div class="col-md-7"><textarea name="notes" id="notes" cols="50" rows="20"></textarea></div>
						</div>
					</div>
					{{ Form::submit('Save', ['class'=>'custom-submit-class']) }}
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){

		// $('#passport_expiry').datepicker({ dateFormat: 'dd/mm/y' });

		// $('#person_type').on("change", function(e){
		// 	var person_type = $(this).val();
		// 	if(person_type==1) {
		// 		$('.company-only').find('input').prop('disabled', true);
		// 	}else {
		// 		$('.company-only').find('input').prop('disabled', false);
		// 	}
		// });

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
            formData: { "user_name" : "person" }, //general person file name
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

	    // $selector.intlTelInput("setCountry", "sg");
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
		
	});
</script>
@endsection