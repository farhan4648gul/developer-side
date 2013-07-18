<?php namespace Admin\Libraries;

use Laravel\Bundle as Bundle;

require Bundle::path('admin').'libraries/sensor/'.strtolower(PHP_OS).'.php';

use Laravel\Config,Admin\Libraries\Sensor\IO as Sensor;
use Admin\Models\Monitor\Server,Admin\Models\Monitor\Load;

/*********************************************************************
*  Class : Sneakpeak
*  Function : System Server Status Class
*  Author :  joharijumali
*  Description: Class to read hdd, cpu, memory, loads info of current host
**********************************************************************/

class Sneakpeak{

/**
 * undocumented function
 *
 * @return void
 * @author 
 **/

	public static function initsequence(){

		$date = date("Y-m-d H:i:s");

		$server = new Server;
		$id = $server->cron($date);

		$load = new Load;
		$load->cron($id,Sensor::restLoad(),$date);
		$load->stor($id,Sensor::restLoad(),$date,'stor_load');

	}
	
}

?>