@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="space50"></div>
        <h1>Edit user</h1>        
        <a href="{{ route('officiumtutus.updateuser.index') }}"><button class="custom-submit-class">Return to users list</button></a>     
        <div class="space50"></div>

        @if(Request::get('result')=="success")
          <p>{{ "Updated user successfully." }}</p>
          <div class="space10"></div>
        @elseif(Request::get('result')=="fail")
          <p>{{ "Failed to update user." }}</p>
          <div class="space10"></div>
        @endif

        <div class="form-container">
          {{ Form::open(['route' => ['officiumtutus.updateuser.update', $user->id], 'method' => 'put', 'id' => 'edit_user' ]) }}        
            <div class="field-container">
              {{ Form::label('email', 'Email')}}
              {{ Form::text('email', $user->email, ['class'=>'custom-input-class']) }}
            </div>
            <div class="field-container">
              {{ Form::label('old_password', 'Old password')}}
              {{ Form::password('old_password', ['class'=>'custom-input-class']) }}              
            </div>
            <div class="field-container">
              {{ Form::label('password', 'Password')}}
              {{ Form::password('password', ['class'=>'custom-input-class']) }}              
            </div>
            <div class="field-container">
              {{ Form::label('confirm_password', 'Confirm password')}}
              {{ Form::password('confirm_password', ['class'=>'custom-input-class']) }}
            </div>            

            {{ Form::submit('Save', ['class'=>'custom-submit-class']) }}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function(){
      $("#edit_user").validate({
        rules : {
          'email': {
            'required': true,
            'email': true
          },
          'old_password': 'required',
          'password': 'required',
          'confirm_password': {
            'required': true,
            'equalTo': "#password"
          }
        }
      });
    });
  </script>
@endsection