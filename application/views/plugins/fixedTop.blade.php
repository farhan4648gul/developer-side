<div class="navbar navbar-static-top navbar-inverse nav">
    <div class="navbar-inner">
        <div class="span12">
            <!-- <div class="pull-right">{{ Image::rounded('http://placehold.it/40x40'); }}</div> -->
          	<div class="nav-collapse collapse">
              	<div class="pull-right">
	                <ul class="nav pull-right">
	                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">&nbsp;{{ Str::title(Auth::user()->userprofile->fullname) }} <b class="caret"></b></a>
	                        <ul class="dropdown-menu">
	                            <li><a href="#profileModal" onclick="profileInfo('{{url('console/user/profile')}}')"><i class="icon-user"></i> Profile</a></li>
	                            <li><a href="#resetpasswordModal" data-toggle="modal"><i class="icon-lock"></i> Update Login</a></li>
	                            <li class="divider"></li>
	                            <li><a href="{{ url('console/auth/logout') }}"><i class="icon-off"></i> Logout</a></li>
	                        </ul>
	                    </li>
	                </ul>
            	</div>
            </div>
        </div>
    </div>
</div>

<div id="profileModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">User Profile</h3>
	  </div>
	  <div class="modal-body">
		{{ Form::horizontal_open_for_files('admin/user/register', 'POST', array('id' => 'updateProfileForm')) }}
		{{ Form::hidden('profileid') }}
	  	<div class="control-group">
		    <label class="control-label" for="fullname">Full Name</label>
		    <div class="controls">
		      {{ Form::xlarge_text('fullname',null,array('placeholder'=>'Type Full Name')) }}
		    </div>
	  	</div>
		<div class="control-group">
		    <label class="control-label" for="icno">IC Number</label>
		    <div class="controls">
		      {{ Form::xlarge_text('icno',null,array('placeholder'=>'Type IC Number','required')) }}
		    </div>
	  	</div>
		<div class="control-group">
		    <label class="control-label" for="emel">Active Emel</label>
		    <div class="controls">
		      {{ Form::xlarge_email('emel',null,array('placeholder'=>'Type Active Emel','required')) }}
		    </div>
	  	</div>
<!-- 		<div class="control-group">
		    <label class="control-label" for="dob">Date of Birth</label>
		    <div class="controls">
		      	{{ Form::xlarge_text('dob',null,array('placeholder'=>'Insert DOB')) }}
		    </div>
	  	</div>
		<div class="control-group">
		    <label class="control-label" for="address">Home Address</label>
		    <div class="controls">
		      	{{ Form::xlarge_text('address',null,array('placeholder'=>'Home Address')) }}
		    </div>
	  	</div>
		<div class="control-group">
		    <label class="control-label" for="postcode">Postcode</label>
		    <div class="controls">
		      	{{ Form::xlarge_text('postcode',null,array('placeholder'=>'Postcode')) }}
		    </div>
	  	</div>
		<div class="control-group">
		    <label class="control-label" for="town">Town</label>
		    <div class="controls">
		      	{{ Form::xlarge_text('town',null,array('placeholder'=>'Town')) }}
		    </div>
	  	</div>
		<div class="control-group">
		    <label class="control-label" for="city">City</label>
		    <div class="controls">
		      	{{ Form::xlarge_text('city',null,array('placeholder'=>'City')) }}
		    </div>
	  	</div> -->
		{{ Form::close()}}
	  </div>
	  <div class="modal-footer">
	    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	    <button id="editProfileBtn" class="btn btn-primary">Update</button>
	  </div>
	</div>

	<div id="resetpasswordModal" class="modal hide fade" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">Update Login Info</h3>
	  </div>
	  <div id="resetModalBody" class="modal-body">
		{{ Form::open('admin/user/role', 'POST', array('id' => 'resetForm', 'class' => 'form-horizontal')) }}
	  	<div class="control-group">
			<label class="control-label" for="username">Username</label>
			<div class="controls">
			  {{ Form::xlarge_text('username',null,array('placeholder'=>'Username')) }}
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="oldpassword">Old Password</label>
			<div class="controls">
			  {{ Form::xlarge_password('oldpassword',array('placeholder'=>'Type Old password','required')) }}
			</div>
		</div>
	  	<div class="control-group">
		    <label class="control-label" for="password">New Password</label>
		    <div class="controls">
		      {{ Form::xlarge_password('password',array('placeholder'=>'Type New password','required')) }}
		    </div>
	  	</div>
	  	<div class="control-group">
		    <label class="control-label" for="repassword">Retype Password</label>
		    <div class="controls">
		      {{ Form::xlarge_password('repassword',array('placeholder'=>'Retype New password','required')) }}
		    </div>
	  	</div>
		{{ Form::close()}}
	  </div>
	  <div class="modal-footer">
	    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	    <button id="resetBtn" class="btn btn-primary">Update</button>
	  </div>
	</div>
