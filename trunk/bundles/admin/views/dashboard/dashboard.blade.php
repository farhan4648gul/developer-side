@layout($dashboardlayout)

@section('content')
<div class="page-header">
    <h3>Dashboard</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid" id="LOAD">
			<!-- <blockquote>Loading Server Status &nbsp;<img src="{{url('bundles/admin/img/loader.gif')}}"></blockquote> -->
        </div>
	</div>
</div>
<div class="row-fluid">&nbsp;</div>
<div class="row-fluid">
	<div class="span12">
		<div id="spacejump"></div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

{{ HTML::script('bundles/admin/js/monitor/'.strtolower(PHP_OS).'.js'); }}
@endsection