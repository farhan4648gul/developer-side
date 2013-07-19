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
{{ Form::control_group(Form::label('state', 'Action State'),Form::mini_text('state',1,array('placeholder'=>'Type State Value eg; 1 / 2 / 3','required')));}}
{{ Form::control_group(Form::label('roleid', 'Action By'),Form::xlarge_select('roleid', $allrole));}}
{{ Form::control_group(Form::label('page', 'Action Page'),Form::xlarge_select('page', $pagelist['data']));}}

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
    $('#myModalLabel').empty().html('Add New Step / Status');
    $("#addDataForm :input[name='step']").val('');
    $("#addDataForm :input[name='state']").val('1');
    $("#addDataForm :input[name='stepid']").val('');
    $("#addDataForm :input[name='description']").val('');
    $("#addDataForm :input[name='parentid']").val(id);
    datasource();
  }

  $('#addDataBtn').click(function() {
    var step = $(".modal-body #addDataForm :input[name='step']").val();
    var state = $(".modal-body #addDataForm :input[name='state']").val();

    if(step == ''){
      $("#addDataForm :input[name='step']").focus().addClass('error');
    }else if(state == ''){
      $("#addDataForm :input[name='state']").focus().addClass('error');
    }else{
      $.post('{{ url('admin/modul/step'); }}', $("#addDataForm").serialize(),function(data) {
              sourcedata = data;
            }).success(function() { 
              $("#steplist" ).empty().html( sourcedata );
              $("#addDataForm :input[name='step']").val('');
              $("#addDataForm :input[name='description']").val('');
              $('#addDataModal').modal('hide');
            });
    }

  });

  function editStep(id){

      $('#addDataModal').modal('toggle');
      $('#myModalLabel').empty().html('Edit Step')
      $.get('{{ url('admin/modul/stepinfo'); }}', { stepid: id},function(data,status){

      for (x in data)
      {   
        $('#addDataForm input[name="'+ x +'"]' ).val(data[x]);
      }

      },"json");

      $.get('{{ url('admin/modul/resetnavdata'); }}', { stepid: id}, function(data,status){

      for (x in data)
      {   

        var datavalue = data[x]['data'];
        var $el = $("[name=" + x + "]");
        $el.empty();

        $.each(datavalue, function(key, value) {
          console.log(key);
          var selected = false;
          if(key == data[x]['selected']){
            selected = true;
          }
          $el.append($("<option></option>").attr("value", key).attr("selected", selected).text(value));

        });

      }

      },"json");

  }

  function deleteStep(id){

    $.post('{{ url('admin/modul/deletestep'); }}', "id="+id+"&flowid="+{{ URI::segment(5) }} ,function(data) {
          sourcedata = data;
        }).success(function() {
            $( "#steplist" ).empty().append( sourcedata );
          });
  }

  function datasource(){

      $.get('{{ url('admin/modul/resetnavdata'); }}', function(data,status){

      for (x in data)
      {   

        var datavalue = data[x]['data'];
        var $el = $("[name=" + x + "]");
        $el.empty();

        $.each(datavalue, function(key, value) {
          $el.append($("<option></option>").attr("value", key).text(value));

        });

      }

      },"json");

  }

</script>
@endsection