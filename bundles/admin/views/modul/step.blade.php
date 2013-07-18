@layout($syslayout)

@section('content')
<div class="page-header">
     <h3>{{ $flow }}</h3>
</div>
<div class="row-fluid">
	<div class="span12 pull-left">
    <div id="steplist" class="row-fluid" style="overflow:auto">
      {{ $steplist }}
    </div>
	</div>
</div>

<!-- MODAL -->
<div id="addDataModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">Add New Step / Status</h3>
</div>
<div class="modal-body">
{{ Form::open('admin/user/role', 'POST', array('id' => 'addDataForm', 'class' => 'form-horizontal')) }}
{{ Form::hidden('flowid',URI::segment(5))}}
{{ Form::hidden('parentid')}}
{{ Form::hidden('stepid')}}
{{ Form::control_group(Form::label('step', 'Step / Status'),Form::xlarge_text('step',null,array('placeholder'=>'Type Data Value','required')));}}
{{ Form::control_group(Form::label('description', 'Description'),Form::xlarge_text('description',null,array('placeholder'=>'Type Data Description')));}}
{{ Form::control_group(Form::label('roleid', 'Action By'),Form::xlarge_select('roleid', $allrole));}}
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
  function addStep(id){
    $('#addDataModal').modal('toggle');
    $("#addDataForm :input[name='parentid']").val(id);
  }

  $('#addDataBtn').click(function() {
    
    $.post('{{ url('admin/modul/step'); }}', $("#addDataForm").serialize(),function(data) {
            sourcedata = data;
          }).success(function() { 
            $("#steplist" ).empty().html( sourcedata );
            $("#addDataForm :input[name='step']").val('');
            $("#addDataForm :input[name='description']").val('');
            $('#addDataModal').modal('hide');
          });

  });

  function editStep(id){
    console.log(id);
      $('#addDataModal').modal('toggle');
      $('#myModalLabel').empty().html('Edit Step')
    $.get('{{ url('admin/modul/stepinfo'); }}', { stepid: id},function(data,status){

      for (x in data)
      {   
        $('#addDataForm input[name="'+ x +'"]' ).val(data[x]);
      }

      },"json");
  }

  function deleteStep(id){
    console.log(id);
    $.post('{{ url('admin/modul/deletestep'); }}', "id="+id+"&flowid="+{{ URI::segment(5) }} ,function(data) {
          sourcedata = data;
        }).success(function() {
            $( "#steplist" ).empty().append( sourcedata );
          });
  }

</script>
@endsection