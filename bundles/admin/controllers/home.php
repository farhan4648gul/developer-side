<?php

use Admin\Libraries\Sneakpeak as Sneakpeak;

class Admin_Home_Controller extends Admin_Base_Controller {

    public function get_dashboard(){

    	Sneakpeak::initsequence();

    	return View::make('admin::dashboard.dashboard');

    }


}