<?php

class Home_Controller extends Base_Controller {

	public $restful = true;

    public function get_index(){
        return View::make('home.index');
    }

    public function get_dashboard(){

       return View::make('home.dashboard');
    }

    public function get_confirmation(){

        return View::make('home.confirm');
    }

	public function get_setup()
	{
		return View::make('home.setup');
	}

}