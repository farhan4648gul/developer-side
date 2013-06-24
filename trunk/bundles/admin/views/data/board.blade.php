@layout($syslayout)

@section('content')
<div class="page-header">
    <h3>Data Management</h3>
</div>
<div class="row-fluid">
  <div class="pull-right">
    <a href="#addDataModal" role="button" class="btn" data-toggle="modal" style='margin-bottom:10px'><i class="icon-plus"></i>&nbsp;Add New Data Group</a>
  </div>
</div>

<div id="dataGroupList" class="rows-fluid show-grid">
	{{ $datalist }}
</div>

<div id="addDataModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">Add New Data Group</h3>
</div>
<div class="modal-body">
{{ Form::open('admin/user/role', 'POST', array('id' => 'addDataForm', 'class' => 'form-horizontal')) }}
  <div class="control-group">
    <label class="control-label" for="navheaderid">Data Group</label>
    <div class="controls">
      {{ Form::xlarge_text('group_name',null,array('placeholder'=>'Type Data Group Name','required')) }}
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="navheaderid">Data Model</label>
    <div class="controls">
      {{ Form::xlarge_select('group_model', $model); }}
    </div>
  </div>
{{ Form::close()}}
</div>
<div class="modal-footer">
  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  <button id="addDataGroupBtn" class="btn btn-primary">Save</button>
</div>
</div>
@endsection
@section('scripts')
<script>

    $('#addDataGroupBtn').click(function() {
      
      $.post('datagroup', $("#addDataForm").serialize(),function(data) {
              sourcedata = data;
            }).success(function() { 
              $( "#dataGroupList" ).empty().html( sourcedata );
              $("#addDataForm :input").val('');
              $('#addDataModal').modal('hide');
            });

    });

</script>
@endsection