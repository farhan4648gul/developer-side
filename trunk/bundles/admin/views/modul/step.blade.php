@layout($syslayout)

@section('content')
<div class="page-header">
    <h3>{{ $flow }}</h3>
</div>
<div class="row-fluid">
	<a href="#addStepModal" role="button" class="btn pull-right" data-toggle="modal" style='margin-bottom:10px'><i class="icon-plus"></i>&nbsp;Add Step</a>
</div>
<div id="steplist" class="row-fluid">
	{{ $steplist }}
</div>

<div id="addStepModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Step Information</h3>
	</div>
	<div class="modal-body">
		{{ Form::open('admin/user/role', 'POST', array('id' => 'stepAddForm', 'class' => 'form-horizontal')) }}
		{{ Form::hidden('stepid') }}
		{{ Form::hidden('flowid',URI::segment(4)) }}
			<div class="control-group">
				<label class="control-label" for="step">Step Name</label>
				<div class="controls">
				  {{ Form::xlarge_text('step',null,array('placeholder'=>'Type Step Name','required')) }}
				</div>
			</div>
		{{ Form::close()}}
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<button id="addBtn" class="btn btn-primary"  data-loading-text="Saving Step..." >Save Step</button>
	</div>
</div>

<div id="editStepModal" class="modal hide fade" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Step Information</h3>
	</div>
	<div class="modal-body">
		{{ Form::open('admin/user/role', 'POST', array('id' => 'stepEditForm', 'class' => 'form-horizontal')) }}
		{{ Form::hidden('stepid') }}
		{{ Form::hidden('flowid',URI::segment(4)) }}
			<div class="control-group">
				<label class="control-label" for="step">Step Name</label>
				<div class="controls">
				  {{ Form::xlarge_text('step',null,array('placeholder'=>'Type Step Name','required')) }}
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="role">Action By</label>
				<div class="controls">
				  {{ Form::xlarge_select('roleid', $allrole); }}
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="next">Next Step</label>
				<div class="controls">
				  {{ Form::xlarge_select('next', $allstep); }}
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="condition1">Conditon 1</label>
				<div class="controls">
				  {{ Form::xlarge_select('condition1', $allstep); }}
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="condition2">Condition 2</label>
				<div class="controls">
				  {{ Form::xlarge_select('condition2', $allstep); }}
				</div>
			</div>
		{{ Form::close()}}
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<button id="editBtn" class="btn btn-primary"   data-loading-text="Saving Step..." >Save Step</button>
	</div>
</div>

@endsection
@section('scripts')
<script>

	$('#addBtn').click(function() {
		
		$.post('step', $("#stepAddForm").serialize(),function(data) {
			      sourcedata = data;
			    }).success(function() { 
		    		$( "#steplist" ).empty().append( sourcedata );
		    		datasource();
    				$("#stepAddForm input[name='step']").val('');
					$('#addStepModal').modal('hide'); 
					$('#editStepModal').modal('hide'); 
			    });

	});
	
	$('#editBtn').click(function() {
		
		$.post('step', $("#stepEditForm").serialize(),function(data) {
			      sourcedata = data;
			    }).success(function() { 
		    		$( "#steplist" ).empty().append( sourcedata );
		    		datasource();
    				$("#stepEditForm input[name='step']").val('');
					$('#addStepModal').modal('hide'); 
					$('#editStepModal').modal('hide'); 
			    });

	});

	function editStep(id){

		$('#editStepModal').modal('toggle');

		$.get('{{ url('admin/modul/stepinfo'); }}', { stepid: id},function(data,status){

			for (x in data)
			{ 	
				$('#stepEditForm input[name="'+ x +'"]' ).val(data[x]);
			}
			datasource();

		  },"json");

	}

	function deleteStep(id){

	    $.post('{{ url('admin/modul/deletestep'); }}', "id="+id+"&flowid="+{{ URI::segment(4) }} ,function(data) {
			      sourcedata = data;
			    }).success(function() {
			    datasource();
	            $( "#steplist" ).empty().append( sourcedata );
	          });
	}

	function datasource(){


      $.get('{{ url('admin/modul/resetstepdata'); }}', function(data,status){

      for (x in data)
      {   

        var datavalue = data[x];
        var $el = $("[name=" + x + "]");
        $el.empty();

        $.each(datavalue, function(key, value) {
          $el.append($("<option></option>")
             .attr("value", key).text(value));
        });

      }

      },"json");

  }

</script>
@endsection