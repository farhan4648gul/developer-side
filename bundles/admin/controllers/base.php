<?php

class Admin_Base_Controller extends Controller {


    public $restful = true;
    // public $dashboard = 'admin::layouts.dashboard';

    public function __construct(){

        parent::__construct();

        $detect = new Mobile_Detect;

        if($detect->isMobile() || $detect->isTablet()){

            $sidebar = Admin\Libraries\Navigator::mobileSidebar();
            $dashboardlayout = $syslayout = 'admin::layouts.m_main';

        }else{
            $sidebar = Admin\Libraries\Navigator::sidebar();
            $syslayout = 'admin::layouts.main';
            $dashboardlayout = 'admin::layouts.dashboard';
        }

        View::share('sidebar', $sidebar);
        View::share('syslayout', $syslayout);
        View::share('dashboardlayout', $dashboardlayout);

        $this->filter('before', 'auth');

        // Asset::container('bootstrapper')
        //     ->bundle('admin')
        //     ->add('bootstrap',            'css/bootstrap.min.css')
        //     ->add('bootstrap-responsive', 'css/bootstrap-responsive.min.css')
        //     ->add('jquery',               'js/jquery-1.9.1.min.js')
        //     ->add('bootstrap-js',         'js/bootstrap.min.js', 'jquery');

        // // Define unminified version of the assets
        // Asset::container('bootstrapper-unminified')
        //     ->bundle('admin')
        //     ->add('bootstrap',            'css/bootstrap.css')
        //     ->add('bootstrap-responsive', 'css/bootstrap-responsive.css')
        //     ->add('jquery',               'js/jquery-1.9.1.js')
        //     ->add('bootstrap-js',         'js/bootstrap.js', 'jquery');

        // Asset::container('mobile')
        //     ->bundle('admin')
        //     ->add('bootstrap',            'css/bootstrap.min.css')
        //     ->add('mobile-css',           'mobile/jquery.mobile-1.3.1.min.css')
        //     ->add('bootstrap-responsive', 'css/bootstrap-responsive.min.css')
        //     ->add('jquery',               'js/jquery-1.9.1.min.js')
        //     ->add('mobile-panel',         'mobile/jquery.mobile.panel.css')
        //     ->add('mobile-js',            'mobile/jquery.mobile-1.3.1.min.js', 'jquery')
        //     ->add('bootstrap-js',         'js/bootstrap.min.js', 'jquery');


        Config::set('auth.driver', 'adminauth');

    }

    /**
     * Catch-all method for requests that can't be matched.
     *
     * @param  string    $method
     * @param  array     $parameters
     * @return Response
     */
    public function __call($method, $parameters){
        return Response::error('404');
    }

}