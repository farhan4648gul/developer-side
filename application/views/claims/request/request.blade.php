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
    <div class="control-group">
        {{ Form::label('claimscat', 'Claims Category', array('class' => 'control-label')) }}
      <div class="controls">
        {{ Form::xlarge_select('claimscat', $claimsCat , '0',array('required')); }}
      </div>
    </div>
    <div class="control-group">
      {{ Form::label('month', 'Month Apply For', array('class' => 'control-label')) }}
      <div class="controls">
        {{ Form::span5_text('applydate', '', array('placeholder'=>'16/4/2013', 'required', 'id' => 'applydate'));}}
        {{ Form::span5_text('applymonth', '', array('placeholder'=>'January 2013', 'required','id' => 'applymonth' ));}}
      </div>
    </div>
  <!-- </form> -->
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
  $( "#applydate" ).datepicker({
      showWeek: true,
      firstDay: 1,
      altField: "#applymonth",
      altFormat: "MM, yy",
      showButtonPanel: true
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
              $('#actionStatModal').modal('toggle');
              $('#actionStat').removeClass().addClass('alert alert-success').text('Your Application Has been Registered. Proceed for details submission');

              setTimeout('window.location.href="{{ url("'+sourcedata.url+'"); }}";',3000);
            });

    });
</script>
@endsection