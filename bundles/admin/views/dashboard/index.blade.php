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
	<div class="form-actions span8">
		<div class="row-fluid">
			<h4>Server Load</h4>
			<div class="row-fluid">
	          	<div class="span12">
	      			<div id='server_loads'></div>
	      			<div id='server_up'></div>
	          	</div>
          	</div>
        </div>
		<div class="row-fluid">
	  		<h4>Memory Usage</h4>
			<div class="row-fluid">
	          	<div class="span12">
	          		<div id='memory'></div>
	          		<div id='memorytext'></div>
	          	</div>
	        </div>
		</div>
		<div class="row-fluid">
			<div class="form-actions span8">
		  		<h4>Hard Disk Usage</h4>
				<div class="row-fluid">
		          	<div class="span12">
		          		<div id='hdd'></div>
		          	</div>
		        </div>
			</div>
			<div class="form-actions span4">
		  		<h4>CPU Usage</h4>
				<div class="row-fluid">
		          	<div class="span12">
			          	<div id='cpu'></div>
		          	</div>
		        </div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>

      google.load('visualization', '1', {packages:['corechart','gauge']});
      google.setOnLoadCallback(init);

    	function init() {


      		var rawData = jQuery.getJSON("{{ url('admin/home/statusData');}}",function(data) {
      			var cpu = Math.ceil(data.cpu);
      			var memory = Math.ceil(data.memory);
      			var freeHdd = Math.ceil(data.df);
      			var usedHdd = Math.ceil(data.du);
      			var limit = Math.ceil(data.memorylimit);
      			var server = data.server;

      			drawServLoad(server);
      			drawMems(memory,limit);
      			drawCpu(cpu);
      			drawHDD(freeHdd,usedHdd);
      		});

	    }

	    function summary(cpu,freeHdd,usedHdd,memory,limit,server){

	    	$('#server').html('');
	   		$('#server').append('<br/><strong>CPU Usage :</strong> '+cpu+'%');
	   		$('#server').append('<br/><strong>Harddisk Used :</strong> '+usedHdd+' GB &nbsp; <strong><br/>Harddisk Free :</strong> '+freeHdd+' GB');
	   		$('#server').append('<br/><strong>Memory Allocated :</strong> '+limit+'MB &nbsp;<strong><br/>Memory Consumed :</strong> '+memory+'MB');
	   		$('#server').append('<br/><strong>Server Uptime :</strong> '+server.uptime+' <strong>');
	   		$('#server').append('<br/><strong>Server Loads :</strong> '+parseFloat(server.load.one).toFixed(2)+' | '+parseFloat(server.load.five).toFixed(2)+' | '+parseFloat(server.load.fifteen).toFixed(2)+' <strong>');

	    }


	    function drawServLoad(server) {
	    	
			var utc = currentTime();


			var one = parseFloat(parseFloat(server.load.one).toFixed(2));
			var five = parseFloat(parseFloat(server.load.five).toFixed(2));

	        var data = new google.visualization.arrayToDataTable([
	          ['Times', 'Current Loads'],
	          [utc.toString() , five ],
	          [utc.toString() , one ]
	        ]);

			var options = {
			      colors: ['red','green'],
			      legend:{position:'bottom'},
			      chartArea:{left:30,top:30,width:"90%",height:"75%"},
			      animation:{
			        duration: 1000,
			        easing: 'out',
			      },
			      vAxis: {minValue:0, maxValue:2},
			      hAxis: {gridlines:{count:0},logScale:true,textPosition:'none'},

			    };

	        var chart = new google.visualization.AreaChart(document.getElementById('server_loads'));
	        chart.draw(data, options);
	        $('#server_up').html('');
	        $('#server_up').append('<br/><strong>Server Uptime :</strong> '+server.uptime+' <strong>');
	        $('#server_up').append('<br/><strong>Server Loads :</strong> '+parseFloat(server.load.one).toFixed(2)+' | '+parseFloat(server.load.five).toFixed(2)+' | '+parseFloat(server.load.fifteen).toFixed(2)+' <strong>');
	        setInterval(function(){ redrawSerLoad(server,chart,data,options); },5000);
	    }

		function redrawSerLoad(server,chart,data,options){

			var chartData = data;
			var row = chartData.getNumberOfRows();
			var newrow = row;

			if (row > 100) {
				newrow = row - 1;
	      		chartData.removeRow(Math.floor(0));
			};

	      	var rawData = jQuery.getJSON("{{ url('admin/home/server');}}",function(data) {

	      		var loadtime = currentTime();
	      		var one = parseFloat(parseFloat(data.server.load.one).toFixed(2));
	      		$('#server_up').html('');

	      		chartData.insertRows(newrow, [[loadtime.toString(),one]]);
	      		chart.draw(chartData, options);
	      		$('#server_up').append('<br/><strong>Server Uptime :</strong> '+data.server.uptime+' <strong> ');
	      		$('#server_up').append('<br/><strong>Server Loads :</strong> '+parseFloat(data.server.load.one).toFixed(2)+' | '+parseFloat(data.server.load.five).toFixed(2)+' | '+parseFloat(data.server.load.fifteen).toFixed(2)+' <strong>');

	      	});

		}


	    function drawMems(memory,limit) {
	    	
			var utc = currentTime();

	        var data = new google.visualization.arrayToDataTable([
	          ['Times', 'Usage','Limit'],
	          [utc.toString() , memory , limit ]
	        ]);

			var options = {
			      colors: ['red','blue'],
			      legend:{position:'bottom'},
			      chartArea:{left:30,top:30,width:"90%",height:"75%"},
			      animation:{
			        duration: 1000,
			        easing: 'out',
			      },
			      vAxis: {minValue:0, maxValue:limit},
			      hAxis: {gridlines:{count:0},logScale:true,textPosition:'none'},

			    };

	        var chart = new google.visualization.AreaChart(document.getElementById('memory'));
	        chart.draw(data, options);
	        $('#memorytext').html('');
	        $('#memorytext').append('<br/><strong>Memory Allocated :</strong> '+limit+'MB &nbsp;<strong><br/>Memory Consumed :</strong> '+memory+'MB');
	        setInterval(function(){ redrawMems(chart,data,options); },5000);
	    }

		function redrawMems(chart,data,options){

			var chartData = data;
			var row = chartData.getNumberOfRows();
			var newrow = row;

			if (row > 100) {
				newrow = row - 1;
	      		chartData.removeRow(Math.floor(0));
			};

	      	var rawData = jQuery.getJSON("{{ url('admin/home/mems');}}",function(data) {

	      		var memory = Math.ceil(data.memory);
      			var limit = Math.ceil(data.memorylimit);

	      		var loadtime = currentTime();
	      		$('#memorytext').html('');
	      		chartData.insertRows(newrow, [[loadtime.toString(),memory,limit]]);
	      		chart.draw(chartData, options);
	      		$('#memorytext').html('');
	        	$('#memorytext').append('<br/><strong>Memory Allocated :</strong> '+limit+'MB &nbsp;<strong><br/>Memory Consumed :</strong> '+memory+'MB');
	      	});

		}

		function drawCpu(cpu){

	        var data = google.visualization.arrayToDataTable([
			  ['Label', 'Value'],
			  ['CPU', cpu]
			]);

			var options = {
			  width: 400, height: 120,
			  redFrom: 90, redTo: 100,
			  yellowFrom:75, yellowTo: 90,
			  minorTicks: 5
			};

			var chart = new google.visualization.Gauge(document.getElementById('cpu'));
			chart.draw(data, options);
			setInterval(function(){ redrawCPU(chart,data,options); },5000);

		}

		function redrawCPU(chart,data,options){

			var chartData = data;
			chartData.removeRow(0);

	      	var rawData = jQuery.getJSON("{{ url('admin/home/cpu');}}",function(data) {
	      		var cpu = Math.ceil(data.cpu);
	      		chartData.insertRows(0, [['CPU',cpu]]);
	      		chart.draw(chartData, options);

	      	});
		}


		function drawHDD(freeHdd,usedHdd){

	        var data = google.visualization.arrayToDataTable([
	          ['', 'Used Space',  'Free Space'],
	          ['HDD', usedHdd, freeHdd]
	        ]);

	        var options = {
	        	legend:{position:'bottom'},
	        	colors: ['silver','blue'],
	        	areaOpacity:0.5,
	        	vAxis: {title: 'Gigabytes'},
	          	isStacked: true
	        };

	        var chart = new google.visualization.SteppedAreaChart(document.getElementById('hdd'));
	        chart.draw(data, options);

		}

		function currentTime(){

			var now = new Date();
			var h = (now.getHours() <10)? '0' + now.getHours(): now.getHours();
			var m= (now.getMinutes()<10)? '0' + (now.getMinutes() -1): (now.getMinutes()-1);
			var s= (now.getSeconds()<10)? '0' + now.getSeconds(): now.getSeconds();

			return h+":"+m+":"+s;

		}

	    init();

    </script>
@endsection