@extends('layouts.master')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="space50"></div>
				<h1>OCS admin dashboard</h1>
				
				<div class="space50"></div>
				<ul class="admin-ctas">
					<li><a href="{{ route('officiumtutus.registeredcompany.index') }}"><button class="custom-submit-class">Pending orders</button></a></li>			

					<li><a href="{{ route('officiumtutus.approvedcompany.index') }}"><button class="custom-submit-class">Company database</button></a></li>			

					<li><a href="{{ route('officiumtutus.person.index') }}"><button class="custom-submit-class">Person database</button></a></li>					

					<li><a href="{{ route('officiumtutus.company.index') }}"><button class="custom-submit-class">Shelf companies</button></a></li>							
					<li><a href="{{ route('officiumtutus.jurisdiction.index') }}"><button class="custom-submit-class">Company types</button></a></li>	
					<li><a href="{{ route('officiumtutus.updateuser.index') }}"><button class="custom-submit-class">Users</button></a></li>	
					<li><a href="javascript:void(0);" class="logout"><button class="custom-submit-class">Logout</button></a></li>	
				</ul>
			</div>
		</div>
	</div>
	<script>
	// function logout(to_url) {
	//     var out = window.location.href.replace(/:\/\//, '://log:out@');

	//     jQuery.get(out).error(function() {
	//         window.location = to_url;
	//     });
	// }
	function logout(secUrl, redirUrl) {
	    if (bowser.msie) {
	        document.execCommand('ClearAuthenticationCache', 'false');
	    } else if (bowser.gecko) {
	        $.ajax({
	            async: false,
	            url: secUrl,
	            type: 'GET',
	            username: 'logout'
	        });
	    } else if (bowser.webkit) {
	        var xmlhttp = new XMLHttpRequest();
	        xmlhttp.open("GET", secUrl, true);
	        xmlhttp.setRequestHeader("Authorization", "Basic logout");
	        xmlhttp.send();
	    } else {
	        alert("Logging out automatically is unsupported for " + bowser.name
	            + "\nYou must close the browser to log out.");
	    }
	    setTimeout(function () {
	        window.location.href = redirUrl;
	    }, 200);
	}

	$(".logout").on("click", function(e){
		e.preventDefault();
		logout("{{ url('officiumtutus') }}", "{{ url('officiumtutus') }}");
	});	
	</script>
@endsection