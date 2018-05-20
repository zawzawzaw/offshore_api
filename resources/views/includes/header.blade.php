<div class="container">
  <div class="row">
    <div class="col-md-12">     
    
      @if(Auth::check())
        <div class="pull-left">
          <a href="{{ URL::to('/officiumtutus') }}" class="logo middle"><img class="mkdf-normal-logo" src="https://www.offshorecompanysolutions.com/wp-content/uploads/2016/09/OCS-logo-2-lines.png" alt="logo"></a>        
        </div>

        <!--<div class="pull-right test">
          <ul>
            <li><a href="{{ URL::to('/officiumtutus/logout')}}" class="logout-btn">Log out</a></li>
          </ul>        
        </div>-->
      @else
        <div class="pull-left">
          <a href="{{ URL::to('/officiumtutus') }}" class="logo middle"><img class="mkdf-normal-logo" src="https://www.offshorecompanysolutions.com/wp-content/uploads/2016/09/OCS-logo-2-lines.png" alt="logo"></a>
        </div>        
      @endif

    </div>
  </div>
</div>
<script>
  $(document).ready(function(){
    $('.logout-btn').on('click', function(e){
      e.preventDefault();
      $(this).parent().parent('form').submit();
    });    
  });
</script>