<?php

use Admin\Models\Modul\Step as Step,
    Admin\Models\Modul\Page as Page,
    Admin\Models\User\Role as Role,
    Admin\Models\Navigation\Header as Header,
    Admin\Models\Navigation\Link as Link,
    Admin\Libraries\Menu as Menu,
    Logger as Logger;

/**
 * System Management Modul class
 *
 * @package default
 * @author joharijumali@gmail.com
 **/

class Admin_System_Controller extends Admin_Base_Controller {


    public function get_index(){

    	return View::make('admin::system.index');

    }


    /**
     * Navigation Setup function
     * Component : navigate
     * Method : ajax post
     * @return void
     * @author joharijumali@gmail.com
     **/

    public function get_navigate(){

        $data['render'] = Menu::navTree();
        $data['headerlist'] = $list = Header::listheader();
        $data['page'] = $listpage = Page::listpages();
        $data['pagelist'] = $listpage = Page::listAvailpages();

        return View::make('admin::system.navigate',$data);

    }

    public function post_navigate()
    {

        $contents = Input::get();

        foreach ($contents['module'] as $key => $value) {
            $module = Header::find($value);
            $module->step  = $key+1;
            $module->save();
        }

        foreach ($contents['parent'] as $key => $value) {
            $module = Link::find($value);
            $module->parentstep  = $key+1;
            $module->save();
        }

        Log::write('System', 'Update Navigation by '.Auth::user()->username);

        return Redirect::to('admin/system/navigate');
    }


    /**
     * navigation utilities function
     *
     * @return json data
     * 
     **/

    public function get_navchild(){

        $input = Input::get();

        $navigation = Link::find($input['navid']);
        $nav = Header::find($navigation->navheaderid);
        $parent = Page::find($navigation->modulpageid);

        $data['navheaderid'] = $navigation->navheaderid;
        $data['module'] = $nav->navheader;
        $data['parentid'] = $navigation->navpageid;
        $data['parent'] = $parent->actionalias;

        return json_encode($data);
    }

    public function get_resetnavdata(){

        $data['navheaderid'] = $list = Header::listheader();
        $data['modulpageid'] = $listpage = Page::listAvailpages();

        return json_encode($data);

    }

    public function post_setmodule(){
        
        $input = Input::get();

        $module = new Header;
        $module->navheader  = $input['navheader'];
        $module->save();

        Log::write('System', 'Add New Navigation Module '.$input['navheader'].' by '.Auth::user()->username);

        return Menu::navTree();
    }

    public function post_setpage(){
        
        $input = Input::get();

        $pages = new Link;
        $pages->navheaderid  = $input['navheaderid'];
        $pages->modulpageid  = $input['modulpageid'];
        $pages->save();


        $header = Header::find($input['navheaderid'])->navheader;
        $page = Page::find($input['modulpageid'])->actionalias;

        Log::write('System', 'Add New Navigation Page '.$header.' / '.$page.' by '.Auth::user()->username);

        return Menu::navTree();
    }

    public function post_setchild(){

        $input = Input::get();

        $pages = new Link;
        $pages->navheaderid  = $input['navheaderid'];
        $pages->parentid  = $input['parentid'];
        $pages->modulpageid  = $input['modulpageid'];
        $pages->save();

        $header = Header::find($input['navheaderid'])->navheader;
        $parent = Page::find($input['parentid'])->actionalias;
        $subpage = Page::find($input['modulpageid'])->actionalias;

        Log::write('System', 'Add New Navigation Sub Page '.$header.'/'.$parent.'/'.$subpage.' by '.Auth::user()->username);

        return Menu::navTree();
    }

    public function post_deletepages(){
        
        $input = Input::get();

        Link::find($input['id'])->delete();

        Log::write('System', 'Delete Navigation Page '.$input['id'].' by '.Auth::user()->username);

        return Menu::navTree();
    }

    public function post_deletemodule(){
        
        $input = Input::get();

        $header = Header::find($input['id']);

        $head = $header->navheader;

        $header->delete();

        $desc = Link::where('navheaderid','=',$input['id'])->get();

        Link::where('navheaderid','=',$input['id'])->delete();
        
        Log::write('System', 'Delete Navigation Module '.$head.' by '.Auth::user()->username);

        foreach ($desc as $key => $value) {
            $page = Page::find($value->modulpageid)->actionalias;
            Log::write('System', 'Delete Navigation Page '.$head.'/'.$page.' by '.Auth::user()->username);
        }

        return Menu::navTree();
    }


    /**
     * System Logger function
     *
     * @return void
     * 
     **/

    public function get_logger(){

        $logs = Logger::get_log(date('Y-m-d'));
        $data['currentselection'] = date('d-m-Y');
        $data['logs'] = !empty($logs) ? $logs : array('No Log Data Recorded');
    	
    	return View::make('admin::system.logs',$data);

    }

    public function post_logger(){

        $input = Input::get();

        $logs = Logger::get_log(date('Y-m-d',strtotime($input['date'])));

        $data['currentselection'] = date('d-m-Y',strtotime($input['date']));
        $data['logs'] = !empty($logs) ? $logs : array('No Log Data Recorded');

        return View::make('admin::system.logs',$data);
    }


}