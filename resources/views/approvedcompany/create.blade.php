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
        <h1>Create company record</h1>        
        <a href="{{ route('officiumtutus.approvedcompany.index') }}"><button class="custom-submit-class">Back to company database</button></a>

        {{ Form::open([ 'route' => ['officiumtutus.approvedcompany.store'], 'id' => 'add_registered_company' ]) }}  
          <div class="space50"></div>
          <div class="labels">            
            <div class="row">
              <div class="col-md-4"><p>Company code</p></div>
              <div class="col-md-8">
                <input type="text" name="company_code" value="">
              </div>
            </div>
            <div class="row">
              <div class="col-md-4"><p>Company name</p></div> 
              <div class="col-md-8">
                <input type="text" name="company_name" value="">
              </div>  
            </div>  
            <div class="row each-director">
              <div class="col-md-4">User</div>
              <div class="col-md-8">
                <fieldset>                  
                  {{-- <input type="hidden" name="wpuser_id" class="person" value="{{ $company->wpusers[0]->ID }}"> --}}
                  {{-- <input type="hidden" name="companywpuser_id" class="person" value="{{ $company->wpusers[0]->pivot->id }}"> --}}
                  <div class="each-input">
                    <label for="user_person_code">Contact person</label>
                    {!! Form::select("wpuser_id", $userList, "", array('id'=>'change_owner_dropdown')) !!}
                    <input type="hidden" name="user_person_code" id="user_person_code" value="" class="person">
                  </div>
                  {{-- <div class="each-input">
                        <button type="button" class="add-user-to-person custom-submit-class custom-submit-class-2">Add to person database</button>
                      </div>   --}}
                </fieldset>
                
              </div>
            </div>    
            <div class="row">
              <div class="col-md-4">Jurisdiction</div>
              <div class="col-md-8">
                {!! Form::select("jurisdiction", $jurisdictionList, "", array('id'=> 'jurisdiction')) !!}
                {{-- <p>{{ $company->companytypes->jurisdiction }}</p> --}}
              </div>
            </div>
            <div class="row">
              <div class="col-md-4"><p>Company type</p></div>
              <div class="col-md-8">
                {!! Form::select("company_type", $companytypeList, "", array('id'=> 'company_type')) !!}
                {{-- <p>{{ $company->companytypes->name }}</p> --}}
              </div>
            </div>
            <div class="row">
              <div class="col-md-4"><p>Company registration number</p></div>
              <div class="col-md-8">
                <input type="text" name="reg_no" value="">
              </div>
            </div>
            <div class="row">
              <div class="col-md-4"><p>Company tax number</p></div>
              <div class="col-md-8">
                <input type="text" name="tax_no" value="">
              </div>
            </div>
            <div class="row">
              <div class="col-md-4"><p>VAT registration number</p></div>
              <div class="col-md-8">
                <input type="text" name="vat_reg_no" value="">
              </div>
            </div>
            <div class="row">
              <div class="col-md-4"><p>Incorporation date</p></div>
              <div class="col-md-8">
                <input type="text" name="incorporation_date" id="incorporation_date" class="date-input"  placeholder="dd/mm/yyyy" value="">
              </div>
            </div>
            <div class="row">
              <div class="col-md-4"><p>Registered office</p></div>
              <div class="col-md-8">
                <input type="text" name="reg_office" value="">
              </div>
            </div>
            <div class="row">
              <div class="col-md-4"><p>Shareholders</p></div>
              <div class="col-md-8">
                <div class="shareholder">     
                  <input type="hidden" name="shareholder_count" class="shareholder_count" value="">
                  <div class="row each-director">
                    <div class="col-md-12">
                      <fieldset>
                        <legend>Shareholder 1</legend>

                        <div class="each-input">
                          <label for="shareholder_1_shareholder">Shareholder</label>
                          <input type="text" class="nominee_shareholder" value="">
                          <input type="hidden" name="shareholder_1_shareholder" value="">
                        </div>
                        <div class="each-input">
                          <label for="shareholder_1_person_code">Beneficial owner</label>       
                          <input type="text" class="shareholder-ac" value="" >
                          <input type="hidden" name="shareholder_1_person_code" class="person" value="" >
                        </div>
                        <div class="each-input">
                          <label for="shareholder_1_share_amount">Shares held</label>
                          <input type="text" class="person" name="shareholder_1_share_amount" value="">
                        </div>                                                      
                      </fieldset>
                    </div>
                  </div>
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
                            <input type="hidden" disabled="disabled" name="shareholder_0_person_code" class="person shareholder-person-code" value="">
                          </div>
                          <div class="each-input">
                            <label for="shareholder_0_share_amount">Shares held</label>
                            <input type="text" class="shareholder-share-amount" disabled="disabled" class="person" name="shareholder_0_share_amount" value="">
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

                  <div class="row each-director">
                    <div class="col-md-12">
                      <fieldset>
                        <legend>Director 1</legend>

                        <div class="each-input">
                          <label for="director_1_person_code">Name</label>                          
                          <input type="text" class="director-ac" value="" >
                          <input type="hidden" class="person" name="director_1_person_code" value="" >
                        </div>                                          
                      </fieldset>
                    </div>
                  </div>
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
              </div>  
            </div>
            <div class="row">
              <div class="col-md-4"><p>Date of next accounts</p></div>  
              <div class="col-md-8"><input type="text" name="date_of_next_accounts" class="date-input"  placeholder="dd/mm/yyyy" id="date_of_next_accounts" value=""></div>      
            </div>
            <div class="row">
              <div class="col-md-4"><p>Date of last accounts</p></div>  
              <div class="col-md-8"><input type="text" name="date_of_last_accounts" class="date-input"  placeholder="dd/mm/yyyy" id="date_of_last_accounts" value=""></div>      
            </div>            
            <div class="row">
              <div class="col-md-4"><p>Accounts completion deadline</p></div> 
              <div class="col-md-8"><input type="text" name="accounts_completion_deadline" class="date-input"  placeholder="dd/mm/yyyy" id="accounts_completion_deadline" value=""></div>            
            </div>
            <div class="row">
              <div class="col-md-4"><p>Date of last VAT return</p></div>  
              <div class="col-md-8"><input type="text" name="date_of_last_vat_return" class="date-input"  placeholder="dd/mm/yyyy" id="date_of_last_vat_return" value=""></div>            
            </div>
            <div class="row">
              <div class="col-md-4"><p>Date of next VAT return</p></div>  
              <div class="col-md-8"><input type="text" name="date_of_next_vat_return" class="date-input"  placeholder="dd/mm/yyyy" id="date_of_next_vat_return" value=""></div>            
            </div>
            <div class="row">
              <div class="col-md-4"><p>VAT return deadline</p></div>  
              <div class="col-md-8"><input type="text" name="vat_return_deadline" class="date-input"  placeholder="dd/mm/yyyy" id="vat_return_deadline" value=""></div>            
            </div>
            <div class="row">
              <div class="col-md-4"><p>Next AGM due by</p></div>  
              <div class="col-md-8"><input type="text" name="next_agm_due_by" class="date-input"  placeholder="dd/mm/yyyy" id="next_agm_due_by" value=""></div>            
            </div>
            <div class="row">
              <div class="col-md-4"><p>Next domiciliation renewal</p></div> 
              <div class="col-md-8"><input type="text" name="next_domiciliation_renewal" class="date-input"  placeholder="dd/mm/yyyy" id="next_domiciliation_renewal" value=""></div>      
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
                formData: { "user_id" : "" },
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
    ?>
      persons.push('<?php echo $value->person_code." - ".$value->first_name." ".$value->surname; ?>');

    <?php
    endforeach;
    ?>              

    $(".add-to-person").hide();

    function autoCompleteIndividuals($selector) {
      // console.log(persons);
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
                  //  $.each(data, function(i, v) {
                  //    update_to_date_persons.push(v.person_code+" ("+v.first_name+" "+v.surname+")");
                  //  });
                  // }

                  // Handle 'no match' indicated by [ "" ] response
                  // response( data.length === 1 && data[ 0 ].length === 0 ? [] : update_to_date_persons );

                  var data = $.map(data, function(v, i){
                    return (v.person_code+" - "+v.first_name+" "+v.surname);
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

     //    $( ".nominee_shareholder" ).autocomplete({
      //    source: function( request, response ) {
       //      $.ajax({
       //        url: "{{ url('api/getperson') }}",
       //        success: function( data ) {          
       //         var update_to_date_persons = [];
       //         if(data.length){
       //           $.each(data, function(i, v) {
       //             update_to_date_persons.push(v.person_code);
       //           });
       //         }

       //          // Handle 'no match' indicated by [ "" ] response
       //          response( data.length === 1 && data[ 0 ].length === 0 ? [] : update_to_date_persons );
       //        }
       //      });
      //    },
      //    change: function (event, ui) {
     //            if(!ui.item){
     //                //http://api.jqueryui.com/autocomplete/#event-change -
     //                // The item selected from the menu, if any. Otherwise the property is null
     //                //so clear the item for force selection
     //                $(".shareholder").val("");
     //            }

     //        }
      // });

      // $( ".nominee_director" ).autocomplete({
      //    source: persons,
      //    change: function (event, ui) {
     //            if(!ui.item){
     //                //http://api.jqueryui.com/autocomplete/#event-change -
     //                // The item selected from the menu, if any. Otherwise the property is null
     //                //so clear the item for force selection
     //                $(".director").val("");
     //            }

     //        }
      // });

      //  $( ".nominee_secretary" ).autocomplete({
      //    source: persons,
      //    change: function (event, ui) {
     //            if(!ui.item){
     //                //http://api.jqueryui.com/autocomplete/#event-change -
     //                // The item selected from the menu, if any. Otherwise the property is null
     //                //so clear the item for force selection
     //                $(".secretary").val("");
     //            }

     //        }
      // });

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
      //   console.log($(this).val());
      //   $("#company_type").val($(this).val())
      // });

      // $("#company_type").on("change", function(e){
      //   console.log($(this).val());
      //   $("#jurisdiction").val($(this).val())
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