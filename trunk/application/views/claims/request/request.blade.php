@layout('layouts.system')

@section('content')
<div class="page-header">
    <h3>Claims Application</h3>
</div>
<div class="row-fluid" >
  <div class="span12">
    <a href="#addNewModal" role="button" class="btn pull-right" data-toggle="modal" style='margin-bottom:10px;margin-left:5px'><i class="icon-plus"></i>&nbsp;New Application</a>
  </div>
</div>
<div id="claimsList" class="rows-fluid show-grid">
  {{ $claimlist }}
</div>

<!-- Modal -->
<div id="addNewModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">New Claims Application</h3>
</div>
<div class="modal-body">
  {{ Form::open('claims/request/request', 'POST', array('id' => 'addNewForm', 'class' => 'form-horizontal')) }}
  {{ Form::control_group(Form::label('claimscat', 'Claims Category'),Form::large_select('claimscat', $claimsCat , '0',array('required'))); }}
  {{ Form::control_group(Form::label('applymonth', 'Month Apply For'),Form::large_text('applymonth', '', array('placeholder'=>'16/4/2013', 'required', 'id' => 'applydate', 'data-tabindex'=>'1'))); }}
  {{ Form::close()}}
</div>
<div class="modal-footer">
  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  <button id="addNewBtn" class="btn btn-primary">Save</button>
</div>
</div>
@endsection
@section('scripts')
<script>
$(function() {
  $( "#applydate").datepicker({
      format: "MM yyyy",
      minViewMode: 1,
      autoclose: true
    });
  });

  $('#addNewBtn').click(function() {
    
    $.post('{{ url('claims/request/request'); }}', $("#addNewForm").serialize(),function(data) {
            sourcedata = data;
          }).success(function() { 
            sourcedata = eval("("+sourcedata+")");
            // $("#claimsList" ).empty().html( sourcedata.list );
            $("#addNewForm :input").val('');
            $('#addNewModal').modal('hide');
            $('body').modalmanager('loading');
            bootbox.dialog("<p class='alert alert-success'>Your Application Has been Registered. Proceed for details submission</p>");
            setTimeout('window.location.href="{{ url("'+sourcedata.url+'"); }}";',3000);
          });

  });
</script>
@endsection