@layout($syslayout)

@section('content')
<div class="page-header">
    <h3>System Logs</h3>    
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<div class="span4">
				<h5>Logs Date : {{ $currentselection }}</h5>
			</div>
			<div class="span4 pull-right">
				{{ Form::search_open();}}
				{{ Form::append_buttons(Form::span4_text('date',null, array('id'=>'date','class' => 'input-medium','placeholder'=> date('Y-m-d'))), array(Form::submit('Search Log Data'))) }}
				{{ Form::close(); }}
			</div>
		</div>
		<div class="row-fluid">
			<div class='alert alert-info'>
		    	@foreach($logs as $val)
		    	<p><small>{{ Typography::info($val);}}</small></p>
		    	@endforeach
			</div>
		</div>
	</div>
</div>

@endsection
@section('scripts')
<script>
$(function() {
  $( "#date").datepicker({
      format: "MM yyyy",
      minViewMode: 1,
      autoclose: true
    });
  });
@endsection