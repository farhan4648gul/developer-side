@layout($loginlayout)

@section('login')
@if(Session::get('error'))
	Sorry, your username or password was incorrect.
@endif
<center>
{{Form::open('admin/login', 'POST', array('class'=>'form-actions','data-ajax'=>'false','style'=>'border:1px solid #E5E5E5;margin:0px auto;padding:19px 29px 29px;max-width:300px;box-shadow:0 1px 2px rgba(0, 0, 0, 0.05)'))}}
<h3>System Admin Login</h3>
{{ Form::span12_text('username',null,array('placeholder'=>'Username','required')) }}
{{ Form::span12_password('password',array('placeholder'=>'Password','required')) }}
{{	Form::submit('Login', array('class' => 'btn btn-success'))}}
{{	Form::token()}}
{{	Form::close()}}
</center>
@endsection


