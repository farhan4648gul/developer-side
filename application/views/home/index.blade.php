@layout('layouts.login')

@section('login')
@if(Session::get('error'))
	Sorry, your username or password was incorrect.
@endif

{{Form::open('console/auth/authenticate','POST', array('class'=>'form-actions'))}}
<h3>System Login</h3>
{{ Form::span12_text('username',null,array('placeholder'=>'Username','required')) }}
{{ Form::span12_password('password',array('placeholder'=>'Password','required')) }}
{{Form::submit('Login', array('class' => 'btn btn-info pull-right'))}}
{{Form::token()}}
{{Form::close()}}
@endsection