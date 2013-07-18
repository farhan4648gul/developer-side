<?php namespace Admin\Libraries\Sensor;

use Laravel\Config,stdClass;
/*********************************************************************
*  Class : IOdarwin
*  Function : System Server Sensor
*  Author :  joharijumali
*  Description: Class to read hdd, cpu, memory, loads info of current host for darwin base machine
**********************************************************************/

class IO{

	/**
	 * server load sensor function
	 * @return json_encode
	 * @author joharijumali
	 **/

	public static function restLoad(){

		$output = exec('uptime');
		$output = explode(' up ', $output);
		$output = explode(',', $output[1]);

		$load = explode(':', trim($output[3]));
		array_shift($load);
		$load = str_word_count(implode($load),1,'0123456789.%');

		$loadIO = new stdClass;
		/* average load for past 1 minute */ 
		$loadIO->one = trim($load[0]);
		/* average load for past 5 minute */
		$loadIO->five = trim($load[1]);
		/* average load for past 15 minute */
		$loadIO->fifteen = trim($load[2]);
		/* server uptime */
		$loadIO->uptime = $output[0].''.$output[1];
		// /* number of user connected */
		$loadIO->user = trim(str_replace('user,', '', $output[2]));

		return $loadIO;
	
	}

	public static function  hddreader(){
	
		/* get disk space free (in bytes) */
		$df = disk_free_space('/');
		/* and get disk space total (in bytes)  */
		$dt = disk_total_space('/');
		/* now we calculate the disk space used (in bytes) */
		$du = $dt - $df;
		/* percentage of disk used - this will be used to also set the width % of the progress bar */
		$dp = sprintf('%.2f',($du / $dt) * 100);

		/* and we formate the size from bytes to MB, GB, etc. */
		$data['df'] = self::getSizeGB($df);
		$data['du'] = self::getSizeGB($du);
		$data['dt'] = self::getSizeGB($dt);

		$data['dp'] = $dp;

		return $data;
	}

	public static function getSizeGB( $bytes ){

		$gb = $bytes/(1024*1024*1024);

		return round( $gb, 2 );
	}

	public static function getSizeMB( $bytes ){

		$mb = $bytes/(1024*1024);

		return round( $mb, 2 );
	}

	public static function formatSize( $bytes ){
	        
        $types = array( 'B', 'KB', 'MB', 'GB', 'TB' );
        for( $i = 0; $bytes >= 1024 && $i < ( count( $types ) -1 ); $bytes /= 1024, $i++ );
            return( round( $bytes, 2 ) . " " . $types[$i] );
	}

	public static function onRequestStart() {
		/* initiate cpu request */
		$dat = getrusage();
		define('PHP_TUSAGE', microtime(true));
		define('PHP_RUSAGE', $dat["ru_utime.tv_sec"]*1e6+$dat["ru_utime.tv_usec"]);
	}
	 
	public static function getCpuUsage() {
	    $dat = getrusage();
	    $dat["ru_utime.tv_usec"] = ($dat["ru_utime.tv_sec"]*1e6 + $dat["ru_utime.tv_usec"]) - PHP_RUSAGE;
	    $time = (microtime(true) - PHP_TUSAGE) * 1000000;
	 
	    /* calculate cpu per request */
	    if($time > 0) {
	        $cpu = sprintf("%01.2f", ($dat["ru_utime.tv_usec"] / $time) * 100);
	    } else {
	        $cpu = '0.00';
	    }
	 
	    return $cpu;
	}

	public static function get_server_memory_usage(){
	 
		$memory_usage = memory_get_usage(true);

		// $memory_usage = self::formatSize($memory_usage);

		$memory_peak = memory_get_peak_usage (true);
	 
		return self::getSizeMB($memory_usage);
	}

	public static function get_service(){

		$services = Config::get('admin::service.services');
		$server = Config::get('admin::service.server');

		$serviceStatus = array();
		# Process all services montiored.
		foreach( $services as $serviceName => $servicePort )
		{
			# Determine Port Status.
			$status = @fsockopen($server, $servicePort, $errno, $errstr, 5);
			
			# What is the result.
			if( !$status ){
				$statusText = '<span style="color:#b94a48">Down</span><br><small>'.$errstr.'</small>';
			}else{
				$statusText = '<span style="color:#468847"><strong>Up</strong></span>';
			}
			
			# Set the status.
			array_push($serviceStatus, array('serviceName' => '<strong>'.$serviceName.'</strong>', 'port' => '<strong>'.$servicePort.'</strong>' , 'statusText' => $statusText));
		}

		return $serviceStatus;

	}

	public static function get_serverinfo(){

		ob_start () ;
		phpinfo () ;
		$pinfo = ob_get_contents () ;
		ob_end_clean () ;

		 $s = strip_tags($pinfo,'<h2><th><td>');
		 $s = preg_replace('/<th[^>]*>([^<]+)<\/th>/',"<info>\\1</info>",$s);
		 $s = preg_replace('/<td[^>]*>([^<]+)<\/td>/',"<info>\\1</info>",$s);
		 $vTmp = preg_split('/(<h2>[^<]+<\/h2>)/',$s,-1,PREG_SPLIT_DELIM_CAPTURE);
		 $vModules = array();
		 for ($i=1;$i<count($vTmp);$i++) {
		  if (preg_match('/<h2>([^<]+)<\/h2>/',$vTmp[$i],$vMat)) {
		   $vName = trim($vMat[1]);
		   $vTmp2 = explode("\n",$vTmp[$i+1]);
		   foreach ($vTmp2 AS $vOne) {
		    $vPat = '<info>([^<]+)<\/info>';
		    $vPat3 = "/$vPat\s*$vPat\s*$vPat/";
		    $vPat2 = "/$vPat\s*$vPat/";
		    if (preg_match($vPat3,$vOne,$vMat)) { // 3cols
		     $vModules[$vName][trim($vMat[1])] = array(trim($vMat[2]),trim($vMat[3]));
		    } elseif (preg_match($vPat2,$vOne,$vMat)) { // 2cols
		     $vModules[$vName][trim($vMat[1])] = trim($vMat[2]);
		    }
		   }
		  }
		 }


		return $vModules;
	}


	public static function iostat(){

		/*
		*          disk0       cpu     load average
		*	KB/t tps  MB/s  us sy id   1m   5m   15m
   		*	23.18   8  0.18  25  8 67  0.53 0.49 0.58
		*/
		
		$output = exec('iostat');
		$output = explode(' ', $output);

		$arrResult =array();

		foreach ($output as $key => $value) {
			if($value != ''){
				array_push($arrResult, trim($value));
			}
		}

		$arrayFinal['disk']['KB/t'] = $arrResult[0];
		$arrayFinal['disk']['tps'] = $arrResult[1];
		$arrayFinal['disk']['MB/s'] = $arrResult[2];
		$arrayFinal['cpu']['user'] = $arrResult[3];
		$arrayFinal['cpu']['sys'] = $arrResult[4];
		$arrayFinal['cpu']['idle'] = $arrResult[5];
		$arrayFinal['load']['1m'] = $arrResult[6];
		$arrayFinal['load']['15m'] = $arrResult[7];
		$arrayFinal['load']['15m'] = $arrResult[8];

		$result = (object)$arrayFinal;

		return $result;
	}
}

?>