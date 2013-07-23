@layout($syslayout)

@section('content')
<div class="page-header">
    <h3>{{ Str::upper(Lang::line('admin.sysrole')->get()) }}</h3>
</div> 	
<div class="row-fluid">
	<a href="#addRoleForm" role="button" class="btn pull-right" data-toggle="modal" style='margin-bottom:10px'><i class="icon-plus"></i>&nbsp;{{ Str::upper(Lang::line('admin.addnewrole')->get()) }}</a>
</div>
<div id="roleList" class="row-fluid">
	{{ $rolelist }}
</div>

<div id="addRoleForm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">{{ Str::upper(Lang::line('admin.addnewrole')->get()) }}</h3>
</div>
<div class="modal-body">
{{ Form::open('admin/user/role', 'POST', array('id' => 'roleAddForm', 'class' => 'form-horizontal')) }}
{{ Form::hidden('roleid') }}
  <div class="control-group">
    <label class="control-label" for="role">{{ Str::upper(Lang::line('admin.rolename')->get()) }}</label>
    <div class="controls">
      {{ Form::xlarge_text('role',null,array('placeholder'=>Str::title(Lang::line('global.type')->get().' '.Lang::line('admin.rolename')->get()),'required')) }}
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="roleDesc">{{ Str::upper(Lang::line('global.desc')->get()) }}</label>
    <div class="controls">
      {{ Form::xlarge_text('roledesc',null,array('placeholder'=>Str::title(Lang::line('global.type')->get().' '.Lang::line('admin.roledesc')->get()))) }}
    </div>
  </div>
{{ Form::close()}}
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">{{ Str::title(Lang::line('global.close')->get()) }}</button>
<button id="addBtn" class="btn btn-primary" data-loading-text="Saving Role">{{ Str::title(Lang::line('global.save')->get()) }}</button>
</div>
</div>

<div id="editRoleModal" class="modal hide fade" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">{{ Str::upper(Lang::line('admin.editrole')->get()) }}</h3>
</div>
<div class="modal-body">
{{ Form::open('admin/user/role', 'POST', array('id' => 'roleUpdateForm', 'class' => 'form-horizontal')) }}
{{ Form::hidden('roleid') }}
  <div class="control-group">
    <label class="control-label" for="role">{{ Str::upper(Lang::line('admin.rolename')->get()) }}</label>
    <div class="controls">
      {{ Form::xlarge_text('role',null,array('placeholder'=>Str::title(Lang::line('global.type')->get().' '.Lang::line('admin.rolename')->get()),'required')) }}
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="roleDesc">{{ Str::upper(Lang::line('global.desc')->get()) }}</label>
    <div class="controls">
    	{{ Form::xlarge_text('roledesc',null,array('placeholder'=>Str::title(Lang::line('global.type')->get().' '.Lang::line('admin.roledesc')->get()))) }}
    </div>
  </div>
{{ Form::close()}}
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">{{ Str::title(Lang::line('global.close')->get()) }}</button>
<button id="editBtn" class="btn btn-primary"  data-loading-text="Updating Role">{{ Str::title(Lang::line('global.edit')->get()) }}</button>
</div>
</div>


@endsection
@section('scripts')
<script>
	$('#addBtn').click(function() {
		
		$.post('role', $("#roleAddForm").serialize(),function(data) {
			      sourcedata = data;
			    }).success(function() { 
		    		$( "#roleList" ).empty().append( sourcedata );
					$("#roleAddForm :input").val('');
					$('#addRoleForm').modal('hide') 
			    });

	});

	function deleteRole(id){

	    $.post("deleterole", "id="+id ,function(data) {
			      sourcedata = data;
			    }).success(function() {
	            $( "#roleList" ).empty().append( sourcedata );
	          });
	}

	function editRoleModal(id){

		$('#editRoleModal').modal('toggle');

		$.get("roleinfo", { roleid: id},function(data,status){

			for (x in data)
			{ 	

				$('#roleUpdateForm input[name="'+ x +'"]' ).val(data[x]);
			}

		  },"json");

	}

	$('#editBtn').click(function() {
		
		$.post('role', $("#roleUpdateForm").serialize(),function(data) {
			      sourcedata = data;
			    }).success(function() { 
		    		$( "#roleList" ).empty().append( sourcedata );
					$('#editRoleModal').modal('hide');
			    }); 

	});

</script>
@endsection