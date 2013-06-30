@layout($syslayout)

@section('content')
<div class="page-header">
    <h3>{{ $header }}</h3>
</div>
<div class="row-fluid">
  <div class="pull-right">
    <a href="#addDataModal" role="button" class="btn" data-toggle="modal" style='margin-bottom:10px'><i class="icon-plus"></i>&nbsp;Add New Data</a>
  </div>
</div>
<div id="dataList" class="rows-fluid show-grid">
	{{ $list }}
</div>
<div id="addDataModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">Add New Data</h3>
</div>
<div class="modal-body">
{{ Form::open('admin/user/role', 'POST', array('id' => 'addDataForm', 'class' => 'form-horizontal')) }}
  <div class="control-group">
    <label class="control-label" for="navheaderid">Data</label>
    <div class="controls">
    	{{ Form::hidden('groupid',$groupID)}}
    	{{ Form::hidden('id')}}
      	{{ Form::xlarge_text('data',null,array('placeholder'=>'Type Data Value','required')) }}
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="navheaderid">Description</label>
    <div class="controls">
     	{{ Form::xlarge_text('description',null,array('placeholder'=>'Type Data Description')) }}
    </div>
  </div>
{{ Form::close()}}
</div>
<div class="modal-footer">
  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  <button id="addDataBtn" class="btn btn-primary">Save</button>
</div>
</div>
@endsection
@section('scripts')
<script>

    $('#addDataBtn').click(function() {
      
      $.post('{{ url('admin/data/datainput'); }}', $("#addDataForm").serialize(),function(data) {
              sourcedata = data;
            }).success(function() { 
              $("#dataList" ).empty().html( sourcedata );
              $("#addDataForm :input[name='data']").val('');
              $("#addDataForm :input[name='description']").val('');
              $('#addDataModal').modal('hide');
            });

    });


	function editData(id){

		$('#addDataModal').modal('toggle');

		$.get('{{ url('admin/data/datainfo'); }}', { id: id,groupid:{{ URI::segment(4) }}},function(data,status){

			for (x in data)
			{ 	
				$('#addDataForm input[name="'+ x +'"]' ).val(data[x]);
			}

		  },"json");

	}


	function deleteData(id){

	    $.post('{{ url('admin/data/dataremove'); }}', "id="+id+"&groupid="+{{ URI::segment(4) }} ,function(data) {
			      sourcedata = data;
			    }).success(function() {
	            $( "#dataList" ).empty().append( sourcedata );
	          });
	}

</script>
@endsection