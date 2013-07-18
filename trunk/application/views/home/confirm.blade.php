@layout('layouts.setup')

@section('setup')<center>
  {{ Form::open('console/auth/verifyupdate', 'POST', array('class'=>'form-actions','style'=>'border:1px solid #E5E5E5;margin:50px auto;padding:19px 29px 29px;max-width:400px;box-shadow:0 1px 2px rgba(0, 0, 0, 0.05)')) }}
  {{ Form::hidden('key',URI::segment(3)) }}
  <h3>User Registration Confirmation</h3>
  <div class="span12">{{ Label::important('Update your user registration preferences'); }}</div>
  
  {{ Form::xlarge_text('username',null,array('placeholder'=>'New Username','required')) }}
  {{ Form::xlarge_password('password',array('placeholder'=>'New Password','required')) }}
  {{ Form::xlarge_password('oldpassword',array('placeholder'=>'Old Password','required')) }}
  {{ Form::submit('Update Login Info', array('class' => 'btn btn-info'))}}
  {{ Form::close()}}
  </center>
@endsection
