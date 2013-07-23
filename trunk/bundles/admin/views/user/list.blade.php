@layout($syslayout)

@section('content')
	<div class="page-header">
	    <h3>{{ Str::upper(Lang::line('admin.sysuser')->get()) }}</h3>
	</div>
  	<div class="row-fluid">
  		<div class="span5 pull-left">
			{{ Form::search_open('#', 'POST', array('id' => 'searchUserForm'));}}
			{{ Form::append_buttons(Form::span12_text('searchval',null, array('id'=>'searchval','class' => 'input-medium', 'required','placeholder'=> Str::title(Lang::line('global.type')->get().' '.Lang::line('admin.idorname')->get()))), array(Form::button('<i class="icon-search"></i>',array('id'=>'searchButton')))) }}
			{{ Form::close(); }}
  		</div>
  		<div class="span5 pull-right">
  			<a href="#addUserModal" role="button" class="btn pull-right" data-toggle="modal" style='margin-bottom:10px'><i class="icon-plus"></i>&nbsp;{{ Str::title(Lang::line('admin.reguser')->get()) }}</a>
  		</div>
  	</div>
	<div id="userList" class="rows-fluid show-grid">
		{{ $userlist }}
	</div>
	<div id="addUserModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">{{ Str::title(Lang::line('admin.reguser')->get()) }}</h3>
	  </div>
	  <div class="modal-body">
		{{ Form::horizontal_open_for_files('admin/user/register', 'POST', array('id' => 'addUserForm')) }}

	    <h4>{{ Str::title(Lang::line('admin.personalinfo')->get()) }}</h4>
	  	<div class="control-group">
		    <label class="control-label" for="fullname">{{ Str::title(Lang::line('admin.fullname')->get()) }}</label>
		    <div class="controls">
		      {{ Form::xlarge_text('fullname',null,array('placeholder'=>Str::title(Lang::line('global.type')->get().' '.Lang::line('admin.fullname')->get()))) }}
		    </div>
	  	</div>
		<div class="control-group">
		    <label class="control-label" for="icno">{{ Str::title(Lang::line('admin.idno')->get()) }}</label>
		    <div class="controls">
		      {{ Form::xlarge_text('icno',null,array('placeholder'=>Str::title(Lang::line('global.type')->get().' '.Lang::line('admin.idno')->get()),'required')) }}
		    </div>
	  	</div>
		<div class="control-group">
		    <label class="control-label" for="emel">{{ Str::title(Lang::line('admin.activeemel')->get()) }}</label>
		    <div class="controls">
		      {{ Form::xlarge_email('emel',null,array('placeholder'=>Str::title(Lang::line('global.type')->get().' '.Lang::line('admin.activeemel')->get()),'required')) }}
		    </div>
	  	</div>
		<div class="control-group">
		    <label class="control-label" for="role">{{ Str::title(Lang::line('admin.navuserrole')->get()) }}</label>
		    <div class="controls">
		      {{ Form::xlarge_select('role', $allrole); }}
		    </div>
	  	</div>
	  	<h4>{{ Str::title(Lang::line('global.logininfo')->get()) }}</h4>
	  	<div class="control-group">
		    <label class="control-label" for="role">{{ Str::title(Lang::line('global.username')->get()) }}</label>
		    <div class="controls">
		      {{ Form::xlarge_text('username',null,array('required','class' => 'disabled')) }}
		    </div>
	  	</div>
	  	<div class="control-group">
		    <label class="control-label" for="role">{{ Str::title(Lang::line('global.password')->get()) }}</label>
		    <div class="controls">
		      {{ Form::xlarge_text('password',null,array('required','class' => 'disabled')) }}
		    </div>
	  	</div>
		{{ Form::close()}}
	  </div>
	  <div class="modal-footer">
  			<button class="btn" data-dismiss="modal" aria-hidden="true">{{ Str::title(Lang::line('global.close')->get()) }}</button>
  			<button id="addBtn" class="btn btn-primary">{{ Str::title(Lang::line('global.register')->get()) }}</button>
	  </div>
	</div>
	<div id="viewUserModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">{{ Str::title(Lang::line('global.userinfo')->get()) }}</h3>
	  </div>
	  <div class="modal-body">

	    <h4>{{ Str::title(Lang::line('admin.personalinfo')->get()) }}</h4>

		{{ Form::open('admin/user/role', 'POST', array('id' => 'editUserForm', 'class' => 'form-horizontal')) }}
		{{ Form::hidden('userid')}}
		{{ Form::control_group(Form::label('fullname', Str::title(Lang::line('admin.fullname')->get())),Form::xlarge_text('fullname',null,array('placeholder'=>Str::title(Lang::line('global.type')->get().' '.Lang::line('admin.fullname')->get()))));}}
		{{ Form::control_group(Form::label('icno', Str::title(Lang::line('admin.idno')->get())),Form::xlarge_text('icno',null,array('required','placeholder'=>Str::title(Lang::line('global.type')->get().' '.Lang::line('admin.idno')->get()))));}}
		{{ Form::control_group(Form::label('emel', Str::title(Lang::line('admin.activeemel')->get())),Form::xlarge_text('emel',null,array('required','placeholder'=>Str::title(Lang::line('global.type')->get().' '.Lang::line('admin.activeemel')->get()))));}}
		{{ Form::control_group(Form::label('role', Str::title(Lang::line('admin.navuserrole')->get())),Form::xlarge_select('role', $allrole));}}
		{{ Form::control_group(Form::label('status', Str::title('Status')),Form::xlarge_select('status', array('Active'=>'Active','Deactive'=>'Deactive')));}}
		{{ Form::close()}}
	  </div>
	  <div class="modal-footer">
  			<button class="btn" data-dismiss="modal" aria-hidden="true">{{ Str::title(Lang::line('global.close')->get()) }}</button>
  			<button id="editBtn" class="btn btn-primary">{{ Str::title(Lang::line('global.edit')->get()) }}</button>
	  </div>
	</div>
@endsection
@section('scripts')
<script>

	$('#addUserForm input[name="icno"]').keyup(function() {
	  	var icno = $('#addUserForm input[name="icno"]').val();

	  	$('#addUserForm input[name="username"]').val(icno);
	  	$('#addUserForm input[name="password"]').val(icno);
	})

	$('#addBtn').click(function() {

		$.post('register', $("#addUserForm").serialize(),function(data) {
			      sourcedata = data;
			    }).success(function() { 
			    	sourcedata = jQuery.parseJSON(sourcedata);
			    	if(sourcedata.messages){
			    		validated("addUserForm",sourcedata.messages);
			    	}else{
			    		$( "#userList" ).empty().append( sourcedata );
			    		$("#addUserForm :input").val('');
						$('#addUserModal').modal('hide');
			    	}

			    }); 

	});

	function viewUser(id){
		$('#viewUserModal').modal('show');
		$.get('userinfo', { id: id},function(data,status){
			for (x in data)
			{ 	
				$('#editUserForm input[name="'+ x +'"]' ).val(data[x]);

				if(x == 'role' || x == 'status'){
					$("#editUserForm [name=" + x + "]").val(data[x]);
				}

			}
		},"json");
	}


	$('#editBtn').click(function() {

		$.post('updateUser', $("#editUserForm").serialize(),function(data) {
			      sourcedata = data;
			    }).success(function() { 
			    	sourcedata = jQuery.parseJSON(sourcedata);
			    	if(sourcedata.messages){
			    		validated("editUserForm",sourcedata.messages);
			    	}else{
			    		$( "#userList" ).empty().append( sourcedata );
			    		$("#editUserForm :input").val('');
						$('#viewUserModal').modal('hide');
			    	}

			    }); 

	});

	function resetAccount(id){

	    $.post("resetlogin", "id="+id ,function(data) {
			      sourcedata = data;
			    }).success(function() {
	            $( "#userList" ).empty().append( sourcedata );
	          });
	}

	function deleteAccount(id,name){

		var r = confirm("Adakah anda pasti untuk memadam Pengguna " +name.toUpperCase());

		if (r==true){
		    $.post("deleteAccount", "id="+id ,function(data) {
				      sourcedata = data;
				    }).success(function() {
				    sourcedata = jQuery.parseJSON(sourcedata);

				    if(sourcedata.fail){
				    	alert(sourcedata.fail);
				    }else{
				    	$( "#userList" ).empty().append( sourcedata );
				    }
		          });
		}

	}

	$('#searchButton').click(function() {

	    $.post("search", $("#searchUserForm").serialize(),function(data) {
			      sourcedata = data;
			    }).success(function() {
			    sourcedata = jQuery.parseJSON(sourcedata);
	            $( "#userList" ).empty().append( sourcedata );
	          });
	});
</script>
@endsection