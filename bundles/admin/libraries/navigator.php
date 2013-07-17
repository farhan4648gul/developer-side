<?php namespace Admin\Libraries;

use Bootstrapper\Navigation as Navigation,
    Laravel\Str as Str,
    Laravel\URI as URI;

/*********************************************************************
*  Class : Navigator
*  Function : Navigation Class
*  Author :  joharijumali
*  Description: Class for Admin Modul Navigation
**********************************************************************/

class Navigator{

    /**
     * sidebar function
     * Create sidebar
     * @return string
     * @author joharijumali
     **/

  	public static function sidebar() {

      // $Menu = Header::navigationdata();
      $flow = (URI::segment(3) == 'step')?true:false;

      $navValue = array(
                  array(Navigation::HEADER, Str::upper('EIS MANAGEMENT')),
                  array('Dashboard', url('admin/home/dashboard'),false, false, null, 'tasks'),
                  array(Navigation::HEADER, Str::upper('SYSTEM MANAGEMENT')),
                  array('Data Management', url('admin/data/board'),false, false, null, 'chevron-right'),
                  array('Page Registration', url('admin/modul/page'),false, false, null, 'chevron-right'),
                  array('Flow Management', url('admin/modul/flow'),$flow, false, null, 'chevron-right'),
                  array('Navigation Setup', url('admin/system/navigate'),false, false, null, 'chevron-right'),
                  array('System Logs', url('admin/system/logger'),false, false, null, 'chevron-right'),
                  array(Navigation::HEADER, Str::upper('USER MANAGEMENT')),
                  array('User List', url('admin/user/list'),false, false, null, 'chevron-right'),
                  array('User Role', url('admin/user/role'),false, false, null, 'chevron-right'),
                  array(Navigation::HEADER, Str::upper('LOGOUT')),
                  array('Logout', url('admin/login/logout'),false, false, null, 'off'),
                  );
    
      return Navigation::lists(Navigation::links($navValue));

  	}

    public static function mobileSidebar(){

      $navView = '';
      $navView .= '<ul data-role="listview" data-theme="d" class="nav-search">';
      $navView .= '<li data-icon="delete"><a href="#" data-rel="close">Close menu</a></li>';
      $navView .= '<li data-role="list-divider"  data-theme="d">Menu</li>';
      $navView .= '</ul>';
      $navView .= '<div data-role="collapsible-set" data-inset="false" data-iconpos="right" data-theme="a" data-content-theme="a">';
      $navView .= '<div data-role="collapsible" data-theme="a">';
      $navView .= '<h5>EIS MANAGEMENT</h5>';
      $navView .= '<ul data-role="listview" data-theme="d" data-content-theme="d">';
      $navView .= '<li ><a href="'.url('admin/home/dashboard').'" data-ajax="false">Dashboard</a></li>';
      $navView .= '</ul>';
      $navView .= '</div>';
      $navView .= '</div>';
      $navView .= '<div data-role="collapsible-set" data-inset="false" data-iconpos="right" data-theme="a" data-content-theme="a">';
      $navView .= '<div data-role="collapsible" data-theme="a">';
      $navView .= '<h5>SYSTEM MANAGEMENT</h5>';
      $navView .= '<ul data-role="listview" data-theme="d" data-content-theme="d">';
      $navView .= '<li ><a href="'.url('admin/system/logger').'" data-ajax="false">System Logs</a></li>';
      $navView .= '</ul>';
      $navView .= '</div>';
      $navView .= '</div>';
      $navView .= '<div data-role="collapsible-set" data-inset="false" data-iconpos="right" data-theme="a" data-content-theme="a">';
      $navView .= '<div data-role="collapsible" data-theme="a">';
      $navView .= '<h5>LOGOUT</h5>';
      $navView .= '<ul data-role="listview" data-theme="d" data-content-theme="d">';
      $navView .= '<li data-icon="delete"><a href="'.url('admin/login/logout').'" data-ajax="false">Logout</a></li>';
      $navView .= '</ul>';
      $navView .= '</div>';
      $navView .= '</div>';


      return $navView;
    }

}