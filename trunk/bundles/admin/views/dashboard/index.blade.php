@layout($dashboardlayout)

@section('content')
<div class="page-header">
    <h3>Dashboard</h3>
</div>

<div class="row-fluid">
	<div class="form-actions span4">
  		<h4>Service Status</h4>
		<div class="row-fluid">
          	<div class="span12">
				{{ Table::condensed_open(); }}
				{{ Table::headers('Services','Port' ,'Status'); }}
				{{ Table::body($services); }}
				{{ Table::close(); }}
          	</div>
        </div>
	</div>
	<div class="form-actions span4">
  		<h4>Server Information</h4>
		<div class="row-fluid">
          	<div class="span12">
          		&nbsp;
          	</div>
        </div>
	</div>
	<div class="form-actions span4">
  		<h4>Server Information</h4>
		<div class="row-fluid">
          	<div class="span12">
          		<div id='server_loads'></div>
          	</div>
        </div>
	</div>
</div>
<div class="row-fluid">
	<div class="form-actions span4">
  		<h4>Hard Disk Usage</h4>
		<div class="row-fluid">
          	<div class="span12">
          		<div id='hdd'></div>
          	</div>
        </div>
        <div class="row-fluid">
        	<div class="span12">
        		<center><strong>Used :</strong> {{ $du }} GB &nbsp; <strong>Free :</strong> {{ $df }} GB</center>
          	</div>
        </div>
	</div>
	<div class="form-actions span4">
  		<h4>CPU Usage</h4>
		<div class="row-fluid">
          	<div class="span12">
	          	<center>
	          		<div id='cpu'></div>
	          	</center>
          	</div>
        </div>
        <div class="row-fluid">
          	<div class="span12">
          		&nbsp;
          	</div>
        </div>
	</div>
	<div class="form-actions span4">
  		<h4>Memory Usage</h4>
		<div class="row-fluid">
          	<div class="span12">
          		<div id='memory'></div>
          	</div>
        </div>
        <div class="row-fluid">
          	<div class="span12">
          		&nbsp;
          	</div>
        </div>
	</div>
</div>
@endsection
@section('scripts')
<script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>

      google.load('visualization', '1', {packages:['gauge','corechart']});
      google.setOnLoadCallback(init);

    	function init() {


      		var rawData = jQuery.getJSON("{{ url('admin/home/statusData');}}",function(data) {
      			var cpu = Math.ceil(data.cpu);
      			var memory = Math.ceil(data.memory);
      			var freeHdd = Math.ceil(data.df);
      			var usedHdd = Math.ceil(data.du);
      			var limit = Math.ceil(data.memorylimit);
      			var server = data.server;

      			drawCPU(cpu);
      			drawHDD(freeHdd,usedHdd);
      			drawMem(memory,limit);
      			drawServLoad(server);
      		});

	    }

      	function drawCPU(cpu) {

	        var data = google.visualization.arrayToDataTable([
	          ['Label', 'Value'],
	          ['CPU', cpu ]
	        ]);

	        var options = {
	          width: 400, height: 200,
	          redFrom: 80, redTo: 100,
	          yellowFrom:75, yellowTo: 80,
	          minorTicks: 5
	        };

	        var chart = new google.visualization.Gauge(document.getElementById('cpu'));
	        chart.draw(data, options);
      	}

		function drawHDD(freeHdd,usedHdd) {
		  // Create and populate the data table.
		  var data = google.visualization.arrayToDataTable([
		    ['HDD', 'Gigabytes'],
		    ['Free', freeHdd],
		    ['Used', usedHdd]
		  ]);

		var options = {
		          chartArea: {left:20,top:30,width:"80%",height:"80%"},
		          tooltip: {text:'both'}
		        };

		  // Create and draw the visualization.
		  new google.visualization.PieChart(document.getElementById('hdd')).
		      draw(data, options);
		}

		function drawMem(memory,limit) {
	        var data = google.visualization.arrayToDataTable([
	          ['Memory (MB)', 'Consumed',  'Available'],
	          ['Memory (MB)',memory, (limit -memory)]
	        ]);

	        var options = {
	          vAxis: {title: 'Memory Consumed'},
	          chartArea: {left:20,top:20,width:"50%",height:"80%"},
	          isStacked: true,
	          series: [{color: 'red', visibleInLegend: true},{color: 'blue', visibleInLegend: true}]
	        };

	        var chart = new google.visualization.SteppedAreaChart(document.getElementById('memory'));
	        chart.draw(data, options);
	    }

	    function drawServLoad(server) {

	        var data = google.visualization.arrayToDataTable([
	          ['Times', 'Loads'],
	          [server.load.fifteen ,server.load.fifteen ],
	          [server.load.five ,server.load.five ],
	          [server.load.one ,server.load.one ]
	        ]);

	        var options = {
	          title: 'Server Loads',
	          chartArea: {width: '80%', height: '50%'},
	          curveType: 'function',
	          // hAxis: {gridlines:{count:3},viewWindowMode:'pretty'},
	          // vAxis: {minValue:0,viewWindowMode:'pretty'},
	          legend: {position:'bottom'}
	        };

	        var chart = new google.visualization.LineChart(document.getElementById('server_loads'));
	        chart.draw(data, options);
	        $('#server_loads').append('<br/><center><strong>Server Uptime :</strong> '+server.uptime+' <strong></center>');
	    }

        var int=self.setInterval(function(){init();},5000);
    </script>
@endsection