<?php

class Base_Controller extends Controller {


    // public $restful = true;

    public function __construct(){

        parent::__construct();

        View::share('sidebar', Navigator::sidebar());

        $class = get_called_class();

        if(!Request::ajax()){
            switch($class) {
                case 'Home_Controller':
                    $this->filter('before', 'nonauth')->except('dashboard');
                    break;             

                case 'Console_Auth_Controller':
                    $this->filter('before', 'auth')->except(array('authenticate','verifyupdate','logout'));
                    break;
                    
                default:
                    
                    $this->filter('before', 'auth');
                    
                    break;
            }
        }

    }

	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}

}