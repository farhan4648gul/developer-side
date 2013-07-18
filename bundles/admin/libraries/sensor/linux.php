<?php namespace Admin\Libraries\Sensor;

use Laravel\Config,stdClass;
/*********************************************************************
*  Class : IO
*  Function : System Server Sensor
*  Author :  joharijumali
*  Description: Class to read hdd, cpu, memory, loads info of current host for linux base machine
**********************************************************************/

class IO{

	public function restCpu(){

		$output = array();
		echo "in";
		exec("sar -u 1 1",$output);
		print_r($output);
		$averageLine = count($output) - 1;
		$header = str_word_count($output[2],1);
		$content = explode(':', $output[$averageLine]);
		$content = str_word_count($content[1],1,'0123456789.');
		$data = array_combine($header,$content);

		$cpu = array(array('Label', 'Value'));

		array_shift($data);

		foreach ($data as $key => $value) {
			array_push($cpu, array(strtoupper($key),floatval($value)));
		}

		return json_encode($data);

		
		/* user - Show the percentage  of  CPU  utilization  that  occurred
  		while executing at the user level (application). */
		
		/* system - Show the percentage  of  CPU  utilization  that  occurred
		while executing at the system level (kernel).*/

		/* idle - Show  the  percentage  of  time that the CPU or CPUs were
		idle and the system did not have an outstanding disk  I/O
		request*/

		/* iowait - Show the percentage of time that the CPU or CPUs were 
		idle during which the system had an outstanding disk I/O request*/

		/* nice - Show the percentage of CPU utilization that occurred 
		while executing at the user level with nice priority*/

		/* steal - Show the percentage of time spent in involuntary wait by the 
		virtual CPU or CPUs while the hypervisor was servicing another virtual processor*/

	} 

	public function restDisk(){

		// $this->executeCmd("iostat -p ALL -k -t| grep '^sd[a-z] ' | awk '{print \$1,\$3,\$4}'");

		exec("iostat -m -x| grep '^sd[a-z] '",$execOut);

		$diskIO = new stdClass;

		$info = array('device','rrqms','wrqms','rs','ws','rMBs','wMBs','avgrq','avgqu','await','svctm','util');

		foreach ($execOut as $key => $value) {
			if(!empty($value)){
				$data = explode(' ', $value);
				$diskData = new stdClass;
				$t = 1;
				foreach ($data as $key2 => $value2) {
					if(!empty($value2) && $key2 != 0){
						$diskData->$info[$t] = $value2;
						$t++;
					}
				}

				$ds = disk_total_space("/dev/".$data[0]);
				$df = disk_free_space("/dev/".$data[0]);

				$diskData->total = $ds;
				$diskData->free = $df;
				$diskData->path = dirname("/dev/".$data[0]);

				$diskIO->$data[0] = $diskData;
			}

		}



		/*

		$diskIO->rrqms = The number of read requests merged per second that were queued to the hard disk
		$diskIO->wrqms = The number of write requests merged per second that were queued to the hard disk
		$diskIO->rs = The number of read requests per second
		$diskIO->ws = The number of write requests per second
		$diskIO->rMBs = The number of MB read from the hard disk per second
		$diskIO->wMBs = The number of MB written to the hard disk per second
		$diskIO->avgrq = The number of sectors written to the hard disk per second
		$diskIO->avgqu = The average queue length of the requests that were issued to the device
		$diskIO->await = The average time (in milliseconds) for I/O requests issued to the device to be served. 
						 This includes the time spent by the requests in queue and the time spent servicing them.
		$diskIO->svctm = The average service time (in milliseconds) for I/O requests that were issued to the device
		$diskIO->util = Percentage of CPU time during which I/O requests were issued to the device (bandwidth utilization for the device). 
						Device saturation occurs when this value is close to 100%.

		*/

		return json_encode($diskIO);
	}

	public function diskCapacity(){

		$ds = disk_total_space("/");
		$df = disk_free_space("/");

		$diskData['total'] = $ds;
		$diskData['free'] = $df;

		return json_encode($diskIO);
	
	}

	public function ping($host){
		// $output = exec("ping -c 1 ".$host." | awk '{print $8,$9}'");
		// $data = explode("=", $output);
		// return $data[1];
		// print_r(expression);
	}

	public static function restLoad(){

		$output = exec('uptime');
		$output = explode(',', trim($output));

		$arrResult = array();

		foreach ($output as $key => $value) {
			if($value != ''){
				array_push($arrResult, trim($value));
			}
		}

		$load = explode(':', trim($arrResult[3]));
		$load = trim($load[1]);


		$up = explode('up', trim($arrResult[0]));
		$uptime = trim($up[1]).' '.trim($arrResult[1]);
		// $uptime = trim(str_replace('days,', 'days', $up[1]));
		// $uptime = trim(str_replace('min,', 'min', $uptime));

		$loadIO = new stdClass;
		/* average load for past 1 minute */
		$loadIO->one = trim($load);
		/* average load for past 5 minute */
		$loadIO->five = trim($arrResult[4]);
		/* average load for past 15 minute */
		$loadIO->fifteen = trim($arrResult[5]);
		/* server uptime */
		$loadIO->uptime = $uptime;
		/* number of user connected */
		$loadIO->user = trim(str_replace('user,', '', $arrResult[2]));

		return json_encode($loadIO);

	}	

	public function restMemory(){

		/* 	kbmemfree - Amount of free memory available in kilobytes.
			kbmemused - Amount of used memory in kilobytes. This does not take into account memory used by the kernel itself.
			%memused - Percentage of used memory
			kbbuffers - Amount of memory used as buffers by the kernel in kilobytes.
			kbcached - Amount of memory used to cache data by the kernel in kilobytes.
			kbswpfree - Amount of free swap space in kilobytes.
			kbswpused - Amount of used swap space in kilobytes.
			%swpused  - Percentage of cached swap memory in relation to the amount of used swap space.
			kbswpcad - Amount of cached swap memory in kilobytes. This is memory that once was swapped out, is swapped back in 
						but still also is in the swap area (if memory is needed it doesn't need to be swapped out again because 
						it is already in the swap area. This saves I/O).
		*/

		$output = array();

		exec("sar -r 1 1",$output);
		$averageLine = count($output) - 1;
		$header = str_word_count($output[2],1);
		$content = explode(':', $output[$averageLine]);
		$content = str_word_count($content[1],1,'0123456789.%');
		$memory = array_combine($header,$content);

		return json_encode($memory);
	}


	public function restProcess(){

		$field = array('mem','cpu', 'arg');
		$content = array();
		exec("ps -eo pmem,pcpu,args| awk '{print $1,$2,$3}' |sort -k 1 -r | head -10",$output);

		foreach ($output as $key => $value) {

			$variable = str_word_count($value,1,'0123456789.\%/:()=_');

			foreach ($variable as $kon => $value) {
				$content[$key][$field[$kon]] = $value;
			}

		}

		return json_encode($content);
	}

}