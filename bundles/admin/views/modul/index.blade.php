@layout('admin::layouts.main')

@section('content')
<div class="page-header">
    <h3>Modul Management</h3>
</div>
<div class="row-fluid">
	<a href="#" role="button" onclick="recompose()" data-loading-text="Loading..." class="btn pull-right" style='margin-bottom:10px'><i class="icon-plus"></i>&nbsp;Recompose</a>
</div>
<div class="row-fluid">
	<div id="container" class="container-fluid">
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
			    }).fail(function() { 

					var fail = '<div class="alert alert-error" >' +
								'<button type="button" class="close" data-dismiss="alert">&times;</button>' +
								'<strong>Composing Modul File Fail!!!</strong></div>'


					$('#container').prepend(fail); 

			    });

	}
</script>
@endsection