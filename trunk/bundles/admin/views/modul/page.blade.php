@layout($syslayout)

@section('content')
<div class="page-header">
    <h3>Pages Setup</h3>
</div>
<div class="row-fluid">
	<div id="container" class="container-fluid">
	</div>
</div>
<div class="row-fluid">
	<a href="#" role="button" onclick="recompose()" data-loading-text="Loading..." class="btn pull-right" style='margin-bottom:10px'><i class="icon-plus"></i>&nbsp;Recompose Page</a>
</div>
<div class="row-fluid">
  <div class="span12">
    {{ Form::open('admin/modul/page', 'POST') }}
    <div id="struct">{{ $struct }}</div>
    <div class="form-actions">
	    <button type="submit" class="btn pull-right btn-primary">Save changes</button>
  	</div>
    {{ Form::close()}}
  </div>
</div>
@endsection
@section('scripts')
<script>

	function recompose(){
		
		$.post('{{ url('admin/modul/recomp'); }}', function(data) {
			      sourcedata = data;
			    }).success(function() { 
					var notfail = '<div class="alert alert-success" >' +
								'<button type="button" class="close" data-dismiss="alert">&times;</button>' +
								'<strong>Composing Modul File Completed !!!</strong></div>'


					$('#container').prepend(notfail); 
					$( "#struct" ).empty().append( sourcedata );
			    }).fail(function() { 

					var fail = '<div class="alert alert-error" >' +
								'<button type="button" class="close" data-dismiss="alert">&times;</button>' +
								'<strong>Composing Modul File Fail!!!</strong></div>'


					$('#container').prepend(fail); 

			    });

	}
</script>
@endsection