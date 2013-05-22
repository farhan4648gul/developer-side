@layout('admin::layouts.main')

@section('content')
<div class="page-header">
    <h3>Flow Management</h3>
</div>
<div class="row-fluid">
	<a href="#addFlowModal" role="button" class="btn pull-right" data-toggle="modal" style='margin-bottom:10px'><i class="icon-plus"></i>&nbsp;New Flow</a>
</div>
<div id="flowlist" class="row-fluid">
	{{ $flowlist }}
</div>

<div id="addFlowModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Flow Information</h3>
	</div>
	<div class="modal-body">
		{{ Form::open('admin/user/role', 'POST', array('id' => 'flowAddForm', 'class' => 'form-horizontal')) }}
		{{ Form::hidden('flowid') }}
		  <div class="control-group">
		    <label class="control-label" for="flowname">Flow Name</label>
		    <div class="controls">
		      {{ Form::xlarge_text('flowname',null,array('placeholder'=>'Type Flow Name','required')) }}
		    </div>
		  </div>
		{{ Form::close()}}
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<button id="addBtn" class="btn btn-primary">Save Flow</button>
	</div>
</div>

@endsection
@section('scripts')
<script>

	$('#addBtn').click(function() {
		
		$.post('flow', $("#flowAddForm").serialize(),function(data) {
			      sourcedata = data;
			    }).success(function() { 
		    		$( "#flowlist" ).empty().append( sourcedata );

			    });
		$("#flowAddForm :input").val('');
		$('#addFlowModal').modal('hide') 

	});

	function editFlowModal(id){

		$('#addFlowModal').modal('toggle');

		$.get("flowinfo", { flowid: id},function(data,status){

			for (x in data)
			{ 	
				$('#flowAddForm input[name="'+ x +'"]' ).val(data[x]);
			}

		  },"json");

	}

</script>
@endsection