<?php

use Admin\Libraries\Sneakpeak as Sneakpeak;

class Admin_Home_Controller extends Admin_Base_Controller {

    public function get_dashboard(){

        $data =  Sneakpeak::hddreader();
        $server =  Sneakpeak::get_serverinfo();
        echo "<pre>";print_r($server);
        $data['services'] = Sneakpeak::get_service();
    	return View::make('admin::dashboard.index',$data);

    }

    public function get_statusData(){

        $data =  Sneakpeak::hddreader();
        $data['cpu'] = Sneakpeak::getCpuUsage();
        $data['memory'] = Sneakpeak::get_server_memory_usage();
        $data['memorylimit'] = substr(ini_get('memory_limit'), 0, -1);
        // $data['server'] = Sneakpeak::serverload();

        return json_encode($data);

    }

}