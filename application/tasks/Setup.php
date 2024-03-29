<?php
class Setup_Task {

    public function run($arguments = array())
    {

    	$options = array();

    	foreach($arguments as $argument){

			if (($equals = strpos($argument, '=')) !== false)
			{
				$key = substr($argument, 0, $equals);

				$value = substr($argument, $equals+1);
			}

			$options[$key] = $value;

    	}

    	static::validate($options);
		echo PHP_EOL;
		echo PHP_EOL;
    	echo "Begin Database Setup Process...".PHP_EOL;
    	$this->setupdb($options);

    }

	protected static function validate($arguments)
	{
		if (empty($arguments))
		{
			throw new \Exception("Setup parameter is empty!!!.");

		}else if(!isset($arguments['username'])&& !isset($arguments['password'])){

			throw new \Exception("Admin parameter is empty!!!.");

		}
	}


	public function setupdb($arguments)
	{

		$dbpath = path('app').'config/database'.EXT;

		$currentconfig = File::get($dbpath);

		$driver = isset($arguments['driver'])?$arguments['driver']:'';
		$host = isset($arguments['host'])?$arguments['host']:'';
		$database = isset($arguments['database'])?$arguments['database']:'';
		$uname = isset($arguments['uname'])?$arguments['uname']:'';
		$pword = isset($arguments['pword'])?$arguments['pword']:''; 
		$charset = isset($arguments['charset'])?$arguments['charset']:'utf8';
		$username = isset($arguments['username'])?$arguments['username']:'';
		$password = isset($arguments['password'])?$arguments['password']:''; 



		switch ($driver) {
			case 'mysql':
				$setting_db ="array('mysql' => array(
							'driver'   => '{$driver}',
							'host'     => '{$host}',
							'database' => '{$database}',
							'username' => '{$uname}',
							'password' => '{$pword}',
							'charset'  => '{$charset}',
							'prefix'   => '',
						))";
				break;
			case 'sqlite':
				$setting_db ="array('sqlite' => array(
					'driver'   => '{$driver}',
					'database' => '{$database}',
					'prefix'   => '',
				))";
				break;
			case 'pgsql':
				$setting_db ="array('pgsql' => array(
					'driver'   => '{$driver}',
					'host'     => '{$host}',
					'database' => '{$database}',
					'username' => '{$uname}',
					'password' => '{$pword}',
					'charset'  => '{$charset}',
					'prefix'   => '',
					'schema'   => 'public',
				))";
				break;
			case 'sqlsrv':
				$setting_db ="array('sqlsrv' => array(
					'driver'   => '{$driver}',
					'host'     => '{$host}',
					'database' => '{$database}',
					'username' => '{$uname}',
					'password' => '{$pword}',
					'prefix'   => '',
				))";
				break;
			
			default:
				$setting_db = '';
				break;
			}

		$config = str_replace("'default' => '',", "'default' => '{$driver}',", $currentconfig, $count);
		$config = str_replace("'connections' => array(),", "'connections' => {$setting_db},", $config, $count);

		File::put($dbpath, $config);

		if($host == 'localhost' || $host == '127.0.0.1' ){
			$this->upMigration();
		}
    	
		$this->setData($driver,$host,$database,$uname,$pword,$username,$password);

	}


	public function upMigration(){

		echo PHP_EOL;
    	echo "Begin Data Migration Process...".PHP_EOL;
		Command::run(array('migrate:install'));
		Command::run(array('migrate'));

	}

	public function setData($driver,$host,$database,$uname,$pword,$username,$password){

		self::createAdmin($username,$password);

		echo PHP_EOL;
		echo "System Database Setup Complete!".PHP_EOL;
		echo PHP_EOL;
		echo "Database Driver = ".$driver.PHP_EOL;
		echo "Database Host = ".$host.PHP_EOL;
		echo "Database Name = ".$database.PHP_EOL;
		echo "Database Username = ".$uname.PHP_EOL;
		echo "Database Password = ".$pword.PHP_EOL;
		echo PHP_EOL;echo PHP_EOL;
		echo "Login Info ".PHP_EOL;
		echo "Username = ".$username.PHP_EOL;
		echo "Password = ".$password.PHP_EOL;
		echo PHP_EOL;
		echo "Refresh browser".PHP_EOL;

	}

	public static function createAdmin($username,$password){

		echo "Publishing Bundle...".PHP_EOL;
        Command::run(array('bundle:publish'));
        echo "Registering administrator...".PHP_EOL;
        Command::run(array('admin::setup', $username , $password));


	}


}
?>