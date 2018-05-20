@extends('layouts.master')

@section('content')	
	<style>
		.search_date_field {
			height: 41px;
	    display: inline-block;
	    -webkit-appearance: menulist-button;
	    border: 1px solid #dbdbdb;
	    background: none;
		}
	</style>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<div class="space50"></div>
				<h1>Company database</h1>				
				<a href="{{ url('/officiumtutus/approvedcompany/create') }}"><button class="custom-submit-class hidden-print">Add a company</button></a>
				<a href="{{ url('/api/exportcompanylist') }}" target="_blank"><button class="custom-submit-class hidden-print">Export data</button></a>
				<a href="javascript:void(0);" class="print"><button class="hidden-print custom-submit-class">Print</button></a>
				<a href="{{ url('/officiumtutus') }}"><button class="custom-submit-class hidden-print">Return to dashboard</button></a>				
				<div class="space10"></div>									

				<div id="demo" class="box jplist">
					
					<div class="jplist-panel box panel-top">
						<div class="search-container" style="text-align: center; margin-top: 20px; margin-bottom: 10px;">							
						   	{!! Form::open(['method'=>'GET','url'=>'officiumtutus/approvedcompany','class'=>'search-form','role'=>'search'])  !!}
						   		{!! Form::select("search_date_field", [
						   			'' => 'Date filter', 
						   			'incorporation_date' => 'Incorporation date', 
						   			'renewal_date' => 'Renewal date',
						   			'date_of_next_accounts' => 'Date of next accounts',
						   			'date_of_last_accounts' => 'Date of last accounts',
						   			'accounts_completion_deadline' => 'Account completion deadline',
						   			'date_of_last_vat_return' => 'Date of last VAT return',
						   			'date_of_next_vat_return' => 'Date of next VAT return',
						   			'next_domiciliation_renewal' => 'Next domiciliation renewal',
						   			'vat_return_deadline' => 'VAT return deadline',
						   			'date_of_last_agm' => 'Date of last AGM',
						   			'next_agm_due_by' => 'Next AGM due by'
						   		], Request::input('search_date_field'), ['class' => 'search_date_field']) !!}
						   		<input type="text" name="search_from_date" class="date-input" value="{{ Request::input('search_from_date') }}" placeholder="From date">
						   		<input type="text" name="search_to_date" class="date-input" value="{{ Request::input('search_to_date') }}" placeholder="To date">						   		
							   	<!--<input 
							   	  name="search"
								  data-path="*" 
								  type="text" 
								  value="{{ Request::input('search') }}" 
								  placeholder="Search..." 
								  data-control-type="textbox" 
								  data-control-name="title-filter" 
								  data-control-action="filter" 
							   	/>-->
							   	<input 
							   	  name="search"
								  data-path="*" 
								  type="text" 
								  value="{{ Request::input('search') }}" 
								  placeholder="Search text" 
							   	/>
						   		<button type="submit" style="height: 40px;margin: 0px;float: none;width: 40px;display: inline-block;"><i class="fa fa-search"></i></button>
						   		<button type="submit" class="clear-search" style="height: 40px;margin: 0px;float: none;width: 40px;display: inline-block;"><i class="fa fa-times"></i></button>
						   	{!! Form::close() !!}													
						</div>
						@if(count($companies) > 0)			              			            
						<table class="table table-striped custom-table-2"> 							
							<!-- panel -->
							<thead>						
								<!-- search any text in the element -->

								<tr data-control-type="sort-buttons-group"
	                                data-control-name="header-sort-buttons"
	                                data-control-action="sort"
	                                data-mode="single"
	                                data-datetime-format="{month}/{day}/{year}">
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
									<th>
										<span class="header sortable-header">Incorporated</span>
										<span class="sort-btns">
	                                        <i class="fa fa-caret-up" data-path=".date" data-type="datetime" data-order="asc" title="Sort by Date Asc"></i>
	                                        <i class="fa fa-caret-down" data-path=".date" data-type="datetime" data-order="desc" title="Sort by Date Desc"></i>
	                                    </span>
									</th>																	
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
															
			              	@foreach($companies as $k => $company)
					                    <tr id="id-{{$company->id}}" class="company-id list-item box">
					                    	<td class="code">
					                    		@if($company->code)
					                    			{{ $company->code }}
					                    		@else
					                    			{{ "Pending" }}
					                    		@endif
				                    		</td>
					                    	<td class="name">{{ $company->name }}</td>
					                    	<td class="companytype">{{ $company->companytypes->jurisdiction }}</td>
					                    	<td><span class="date">{{ (strtotime($company->incorporation_date) <= 0) ? "" : date('d M Y', strtotime($company->incorporation_date)) }}</span></td>
					                    	<td class="username">
												@foreach($company->wpusers as $key => $company_wpuser)
													@if($company_wpuser->pivot->status==2)
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
													@endif
												@endforeach
				                    	 	</td>

				                    	 	<td class="hidden-print">
				                    	 	{!! link_to_route('officiumtutus.approvedcompany.show', 'View', [ $company->id, 'search_from_date' => Request::input('search_from_date'), 'search_to_date' => Request::input('search_to_date'), 'search_date_field' => Request::input('search_date_field'), 'search' => Request::input('search')], ['class'=>'custom-submit-class'] ) !!}
				                    	 	{!! link_to_route('officiumtutus.approvedcompany.edit', 'Edit', [ $company->id, 'search_from_date' => Request::input('search_from_date'), 'search_to_date' => Request::input('search_to_date'), 'search_date_field' => Request::input('search_date_field'), 'search' => Request::input('search')], ['class'=>'custom-submit-class'] ) !!}
					                    </tr> 
			              	@endforeach			              	

							</tbody> 													

						</table>
						@else													           
						<div class="box jplist-no-results text-shadow align-center">
							<p>No results found.</p>
						</div>
						@endif
					</div>
								
				</div>				
				
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

				$(".date-input").inputmask("d/m/y", 
	    		{ 
	    			// "placeholder": "dd/mm/yyyy",
	    			showMaskOnHover: false,
  					showMaskOnFocus: false,
  					onincomplete: function(){
              $(this).val('');
            }
	    		}
	    	);

	    	$(".clear-search").on('click', function(e){
	    		e.preventDefault();

	    		$(this).parent('.search-form').find("input, select").val("");
	    		
	    		$(this).parent('.search-form').submit();
	    	});
		});
	</script>
@endsection