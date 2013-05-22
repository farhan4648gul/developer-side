<?php

class Admin_Login_Controller extends Controller {

    public $restful = true;

    public function __construct(){

        parent::__construct();

        Config::set('auth.driver', 'adminauth');

        Asset::container('header')->bundle('admin');
        Asset::container('header')->add('bootstrap', 'css/bootstrap.min.css');

    }

    public function get_index(){

        $detect = new Mobile_Detect;

        if($detect->isMobile() || $detect->isTablet()){
            $data['loginlayout'] = 'admin::layouts.m_admin';
        }else{
            $data['loginlayout'] = 'admin::layouts.admin';  
        }


        return View::make('admin::login.index',$data);
    }

    public function post_index(){

        $creds = array(
            'username' => Input::get('username'),
            'password' => Input::get('password'),
        );

        if(Auth::attempt($creds)){
            return Redirect::to(URL::to_action('admin::home@dashboard'));
        } else {
            return Redirect::back()->with('error', true);
        }
        
    }

    public function get_logout(){
        Auth::logout();
        return Redirect::to(URL::to_action('admin::home@index'));
    }

}