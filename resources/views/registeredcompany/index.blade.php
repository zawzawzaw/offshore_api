@extends('layouts.master')

@section('content')	
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<div class="space50"></div>
				<h1>Pending orders</h1>				
				<a href="{{ url('/api/exportpendingcompanylist') }}" target="_blank"><button class="custom-submit-class hidden-print">Export data</button></a>
				<a href="javascript:void(0);" class="print"><button class="hidden-print custom-submit-class">Print</button></a>
				<a href="#" id="remove-selected"><button class="custom-submit-class">Remove selected orders</button></a>		
				<a href="{{ url('/officiumtutus') }}"><button class="custom-submit-class hidden-print">Return to dashboard</button></a>				
				<div class="space10"></div>									

				<div id="demo" class="box jplist">
					
					<div class="jplist-panel box panel-top">
						<div class="search-container">	
							{!! Form::open(['method'=>'GET','url'=>'officiumtutus/registeredcompany','class'=>'navbar-form','role'=>'search'])  !!}						
						   	<input 
						   	  name="search"
							  data-path="*" 
							  type="text" 
							  value="" 
							  placeholder="Search..." 
							  data-control-type="textbox" 
							  data-control-name="title-filter" 
							  data-control-action="filter"
						   	/>						
						   	<button type="submit" style="height: 40px;margin: 0px;float: none;width: 40px;display: inline-block;"><i class="fa fa-search"></i></button>
						   	{!! Form::close() !!}		
						</div>
						@if(count($registeredcompanies) > 0)			
							<table class="table table-striped custom-table-3"> 							
								<!-- panel -->
								<thead>						
									<!-- search any text in the element -->

									<tr data-control-type="sort-buttons-group"
		                                data-control-name="header-sort-buttons"
		                                data-control-action="sort"
		                                data-mode="single"
		                                data-datetime-format="{month}/{day}/{year}">
										<th>{{ Form::checkbox('check_all', null, null, ["id"=>"check-all"]) }}</th>
										<th>
											<span class="header sortable-header">Code</span>
											<span class="sort-btns">
		                                        <i class="fa fa-caret-up" data-path=".code" data-type="text" data-order="asc" title="Sort by Code Asc"></i>
		                                        <i class="fa fa-caret-down" data-path=".code" data-type="text" data-order="desc" title="Sort by Code Desc"></i>
		                                    </span>
										</th>
										<th>
											<span class="header sortable-header">Company name</span>
											<span class="sort-btns">
		                                        <i class="fa fa-caret-up" data-path=".name" data-type="text" data-order="asc" title="Sort by Name Asc"></i>
		                                        <i class="fa fa-caret-down" data-path=".name" data-type="text" data-order="desc" title="Sort by Name Desc"></i>
		                                    </span>
										</th>
										<th>
											<span class="header sortable-header">Jurisdiction</span>
											<span class="sort-btns">
		                                        <i class="fa fa-caret-up" data-path=".companytype" data-type="text" data-order="asc" title="Sort by Company Type Asc"></i>
		                                        <i class="fa fa-caret-down" data-path=".companytype" data-type="text" data-order="desc" title="Sort by Company Type Desc"></i>
		                                    </span>
										</th>
										<!-- <th>
											<span class="header sortable-header">Incorporated</span>
											<span class="sort-btns">
		                                        <i class="fa fa-caret-up" data-path=".date" data-type="datetime" data-order="asc" title="Sort by Date Asc"></i>
		                                        <i class="fa fa-caret-down" data-path=".date" data-type="datetime" data-order="desc" title="Sort by Date Desc"></i>
		                                    </span>
										</th> -->																	
										<th>
											<span class="header sortable-header">User</span>
											<span class="sort-btns">
		                                        <i class="fa fa-caret-up" data-path=".username" data-type="text" data-order="asc" title="Sort by Name Asc"></i>
		                                        <i class="fa fa-caret-down" data-path=".username" data-type="text" data-order="desc" title="Sort by Name Desc"></i>
		                                    </span>
										</th>								
										<th class="hidden-print"><span class="header">Action</span></th>							
									</tr>													
								</thead>				 
								
								<!-- data -->  
								<tbody id="table-content" class="list box text-shadow"> 												
						              	@foreach($registeredcompanies as $k => $company)
						              			<tr id="id-{{$company->id}}" class="company-id list-item box">
					                    		<td>{{ Form::checkbox('delete_checkbox[]', $company->id, null, ["class"=>"delete-btn"]) }}</td>
						                    	<td class="code">						                    		
						                    		@if($company->code)
						                    			{{ $company->code }}
						                    		@else
						                    			{{ "Pending" }}
						                    		@endif
					                    		</td>
						                    	<td class="name">{{ $company->name }}</td>
						                    	<td class="companytype">{{ $company->companytypes->jurisdiction }}</td>
						                    	<!-- <td>
						                    		<span class="date">					 		
						                    		@if(strtotime($company->incorporation_date) <= 0)
						                    			TBC
						                    		@else
														{{ date('d M Y', strtotime($company->incorporation_date)) }}</span>
						                    		@endif
						                    		</span>
						                    	</td> -->
						                    	<td class="username">
																		@foreach($company->wpusers as $key => $company_wpuser)	
																			{{-- @if($company_wpuser->pivot->status == 1 || $company_wpuser->pivot->status == 3)	 --}}
																			<?php
																			$field = App\WpBpXprofileFields::where('name', 'First name')->first();
																			$firstname = App\WpBpXprofileData::where('user_id', $company_wpuser->ID)->where('field_id', $field->id)->first();
																			?>
																			{{ (count($firstname) == 0) ? "" : $firstname->value }}
																			<?php
																			$field = App\WpBpXprofileFields::where('name', 'Surname')->first();
																			$lastname = App\WpBpXprofileData::where('user_id', $company_wpuser->ID)->where('field_id', $field->id)->first();
																			?>
																			{{ (count($lastname) == 0) ? "" : " ".$lastname->value }}
																			{{-- @endif --}}
																		@endforeach
					                    	 	</td>
					                    	 	<td class="hidden-print">
						                    	 	<a style="vertical-align: middle;display: inline-block;" href="{{ route('officiumtutus.registeredcompany.show', $company->id) }}"><button class="custom-submit-class">View</button></a>
						                    	 	@if($company->wpusers[0]->pivot->status == 1)
						                    	 	<a style="vertical-align: middle;display: inline-block;" href="{{ route('officiumtutus.registeredcompany.edit', $company->id) }}"><button class="custom-submit-class">Process</button></a>
						                    	 	@endif
						                    	 	{{-- <a style="vertical-align: middle;display: inline-block;" href="#" class="hide-in-pending" data-companywpuesr-id="{{ $company->wpusers[0]->pivot->id }}"><i class="fa fa-times"></i></a> --}}
					                    	 	</td>		                    						
						                    </tr> 
						              	@endforeach			              	
						            

								</tbody>													

							</table>
						@else					
								<div class="box jplist-no-results text-shadow align-center">
									<p>No results found</p>
								</div>
            @endif
							
					</div>
								
				</div>				
				
				<div class="space50"></div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			// jplist plugin call
		    $('#demo').jplist({
		        itemsBox: '.list',
				itemPath: '.list-item',
				panelPath: '.jplist-panel',
				// storage: 'localstorage',
				// storageName: 'jplist-table-sortable-cols'
		    });

	        //alternate up / down buttons on header click
		    $('.header').on('click', function () {
		        $(this).next('.sort-btns').find('[data-path]:not(.jplist-selected):first').trigger('click');
		    });

		    $(".print").on("click", function(e){
					window.print();
				});

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

				$(".hide-in-pending").on("click", function(e){
					e.preventDefault();

					if (confirm("Are you sure you want to remove from pending orders?")) {
          	$(this).parent().parent().remove();

          	var data = {};

		        data.companywpuser_id = $(this).data("companywpuesr-id");		        

		        console.log(data);

		        var response = makeRequest(data, "{{ url('officiumtutus/hidependingorder') }}", "POST");

		        response.done(function(data, textStatus, jqXHR){                    
		            if(jqXHR.status==200) {
		            	$(this).parent().parent().remove();
		            }
		        });
          } 
					
				});

				$("#remove-selected").on("click", function(e){
			
					e.preventDefault();
					var IdsToDelete = [];

					$(".delete-btn").each(function(i, obj){
						var $checkbox = $(obj);
						if($checkbox.prop("checked")){					
							IdsToDelete.push($checkbox.val());										
						}
					});

					if(IdsToDelete.length > 0) {
						$.ajax({
						    url: "{{ url('officiumtutus/registeredcompany') }}/"+IdsToDelete,
						    data: { "_token": "{{ csrf_token() }}" },
						    type: "DELETE",
						    success: function(result) {
						        $.each(IdsToDelete, function(i, value){				

						        	console.log("#id-"+value)        	
						        	console.log($("#id-"+value))        	
						        	$("#id-"+value).remove();
						        	if($(".company-id").length <= 0) {
						        		$("#table-content").html('<tr><th scope="row"><p>No list to display!</p></th></tr>');
						        	}
						        });
						    },
						    error: function(jqXHR, textStatus, errorThrown) {
						        var response = $.parseJSON(jqXHR.responseText);

						        if(response.error) {
						        	alert(response.error);
						        }else 
						        	alert("Unable to delete selected record!");
						    }
						});	
					}else {
						alert('Check the checkbox infront of item you want to delete.');
					}

				});

				$("#check-all").change(function () {
				    $("input.delete-btn").prop('checked', $(this).prop("checked"));
				});
		});
	</script>
@endsection