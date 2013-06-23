@layout('layouts.system')

@section('content')
	<div class="page-header">
	  <h3>Claims Request Form</h3>
	</div>

  {{ Form::open('claims/request/request', 'POST', array('class' => 'form-horizontal')) }}
    <div class="control-group">
        {{ Form::label('claimscat', 'Claims Category', array('class' => 'control-label')) }}
      <div class="controls">
        {{ Form::select('claimscat', $claimsCat , '0',array('class' => 'span4', 'required')); }}
      </div>
    </div>
    <div class="control-group">
      {{ Form::label('month', 'Month Apply For', array('class' => 'control-label')) }}
      <div class="controls">
        {{ Form::text('applydate', '', array('class' => 'span4','placeholder'=>'16/4/2013', 'required', 'id' => 'applydate'));}}
        {{ Form::text('applymonth', '', array('class' => 'span4','placeholder'=>'January 2013', 'required','id' => 'applymonth' ));}}
      </div>
    </div>
	<div class="form-actions ">
	  <button type="submit" class="btn btn-primary">Apply</button>
	  <button type="button" class="btn">Cancel</button>
	</div>
	
  <!-- </form> -->
  {{ Form::close()}}
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
</script>
@endsection