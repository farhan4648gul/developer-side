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
			<div class="span6 pull-right">
				{{ Form::search_open();}}
				{{ Form::search_box('date',null, array('class' => 'input-medium','placeholder'=> date('Y-m-d'))); }}
				{{ Form::submit('Search Log Data'); }}
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