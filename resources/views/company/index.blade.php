@extends('layouts.master')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<div class="space50"></div>
				<h1>Shelf companies list</h1>
				<a href="{{ route('officiumtutus.company.create') }}"><button class="custom-submit-class">Add a shelf company</button></a>				
				<a href="#" id="remove-selected"><button class="custom-submit-class">Remove selected companies</button></a>				
				<a href="{{ url('/officiumtutus') }}"><button class="custom-submit-class">Return to dashboard</button></a>				
				<div class="space50"></div>
							

				<div id="demo" class="box jplist">
					<!-- data -->
	                <div class="box text-shadow">
						<table class="table table-striped demo-tbl custom-table"> 
							<thead class="jplist-panel">

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
										<span class="header sortable-header">Company type</span>
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
									<th><span class="header">Price €</span></th>
									<th><span class="header">Price $</span></th>
									<th><span class="header">Status</span></th>
									<th></th>

								</tr>

							</thead> 
							<tbody id="table-content"> 
								@if($companies->count() > 0)							
					              	@foreach($companies as $k => $company)
					                    <tr id="id-{{$company->id}}" class="company-id tbl-item">
					                    	<td>{{ Form::checkbox('delete_checkbox[]', $company->id, null, ["class"=>"delete-btn"]) }}</td>
					                    	<td class="code">{{ $company->code }}</td>
					                    	<td class="name">{{ $company->name }}</td>
					                    	<td class="companytype">{{ $company->companytypes->name }}</td>
					                    	<td><span class="date">{{ date('d M Y', strtotime($company->incorporation_date)) }}</span></td>	
					                    	<td>{{ $company->price_eu }}</td>
					                    	<td>{{ $company->price }}</td>			                    						                    	
					                    	<td>
					                    		@if($company->company_wpusers->count() > 0)													
													@foreach($company->company_wpusers as $company_wpuser)
														@if($company_wpuser->pivot->status==2)
															<p>Registered by {{ $company_wpuser->display_name }}</p>
														@elseif($company_wpuser->pivot->status==1)
															<p>Reserved by {{ $company_wpuser->display_name }}</p>
														@elseif($company_wpuser->pivot->status==0)
															<p>Saved by {{ $company_wpuser->display_name }}</p>
														@endif
													@endforeach
					                    	 	@else 
					                    	 		{{ "Available" }}
					                    	 	@endif
					                    	 </td>			                    						                    	
					                    	<td><a href="{{ route('officiumtutus.company.edit', $company->id) }}"><button class="custom-submit-class custom-submit-class-2">Edit</button></a></td>
					                    </tr> 
					              	@endforeach			              	
					            @else					
									<tr><th scope="row"><p>No list to display!</p></th></tr>
					            @endif						
							</tbody> 
						</table>
					</div>
				</div>				
				
			</div>
		</div>
	</div>
<script>
	$(document).ready(function(){
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
				    url: "{{ url('officiumtutus/company') }}/"+IdsToDelete,
				    data: { "_token": "{{ csrf_token() }}" },
				    type: "DELETE",
				    success: function(result) {
				        $.each(IdsToDelete, function(i, value){				        	
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


		//////

	  	// jplist plugin call
	    $('#demo').jplist({
	        itemsBox: '.demo-tbl',
			itemPath: '.tbl-item',
			panelPath: '.jplist-panel',
			// storage: 'localstorage',
			// storageName: 'jplist-table-sortable-cols'
	    });

        //alternate up / down buttons on header click
	    $('.demo-tbl .header').on('click', function () {
	        $(this).next('.sort-btns').find('[data-path]:not(.jplist-selected):first').trigger('click');
	    });


	});
</script>

@endsection