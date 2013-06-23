@layout('layouts.system')

@section('content')
<div class="page-header">
  	<h3>Claims Applied</h3>
</div>
<div id="dataGroupList" class="rows-fluid show-grid">
	{{ $claimlist }}
</div>
@endsection