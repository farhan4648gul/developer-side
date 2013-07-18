<?php namespace Admin\Models\Monitor;
use \Laravel\Database\Eloquent\Model as Eloquent;

class Server extends Eloquent {

    public static $timestamps = true;
    public static $table = 'server_repo';
    public static $key = 'server_id';

    public function cron($date){

		$ip = $_SERVER['SERVER_ADDR'];

		$name = $_SERVER['SERVER_NAME'];

		$server = Server::where('server_ip','=',$ip)->first(array('server_id'));

		if(empty($server)){

			$server = new Server;
			$server->server_name = $name;
			$server->server_ip = $ip;
			$server->server_date = $date;
			$server->save();
		}else{
			$server = $server->server_id;
		}
		return $server;

	}

}